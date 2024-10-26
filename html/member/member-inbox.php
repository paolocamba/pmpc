<?php
session_start();

// Include database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "pmpc";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get MemberID from session
$memberID = $_SESSION['MemberID'] ?? null;

// Pagination variables
$limit = 6; // Number of messages per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if ($memberID) {
    // Fetch total message count
    $countQuery = "SELECT COUNT(*) as total FROM inbox WHERE MemberID = ?";
    $countStmt = $conn->prepare($countQuery);
    $countStmt->bind_param("i", $memberID);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $totalMessages = $countResult->fetch_assoc()['total'];
    
    // Fetch inbox messages for the logged-in member with pagination
    $query = "SELECT Message, Date, isRead, MessageID FROM inbox WHERE MemberID = ? ORDER BY Date DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $memberID, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    
    // Return messages and total count as JSON if it's an AJAX request
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ajax'])) {
        echo json_encode([
            'messages' => $messages,
            'total' => $totalMessages,
            'page' => $page,
            'limit' => $limit
        ]);
        exit; // Exit to avoid rendering the HTML below
    }

    // Handle message read and delete
    if (isset($_GET['message_id'])) {
        $messageId = (int)$_GET['message_id'];
        
        // Mark message as read
        $updateQuery = "UPDATE inbox SET isRead = 1 WHERE MessageID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("i", $messageId);
        $updateStmt->execute();
        
        // Fetch the message details
        $messageQuery = "SELECT Message, Date FROM inbox WHERE MessageID = ?";
        $messageStmt = $conn->prepare($messageQuery);
        $messageStmt->bind_param("i", $messageId);
        $messageStmt->execute();
        $messageResult = $messageStmt->get_result()->fetch_assoc();
        
        echo json_encode($messageResult);
        exit;
    }

    // Handle message deletion
    if (isset($_POST['delete_id'])) {
        $deleteId = (int)$_POST['delete_id'];
        $deleteQuery = "DELETE FROM inbox WHERE MessageID = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $deleteId);
        $deleteStmt->execute();
        echo json_encode(['success' => true]);
        exit;
    }
} else {
    $messages = [];
    $totalMessages = 0;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Inbox Page</title>
    <link rel="stylesheet" href="../../css/member-inbox.css"> <!-- Linking CSS -->
    <link rel="stylesheet" href="../../css/member-general.css">
</head>
<body>

    <div class="container">
        <div class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <img src="../../assets/pmpc-logo.png" alt="PMPC Logo">
                </div>
                <h2 class="pmpc-text">PASCHAL</h2>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="member-landing.php">Home</a></li>
                <li><a href="member-dashboard.php">Dashboard</a></li>
                <li><a href="member-services.html">Services</a></li>
                <li><a href="member-inbox.php" class="active">Inbox</a></li>
                <li><a href="member-about.html">About</a></li>
            </ul>
            <ul class="sidebar-settings">
                <li><a href="member-settings.php">Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>Inbox</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <section class="inbox-section">
                <table class="inbox-table">
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="inboxMessages">
                        <?php if (empty($messages)): ?>
                            <tr><td colspan="2">No messages found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td style="font-weight: <?php echo $message['isRead'] ? 'normal' : 'bold'; ?>" onclick="showMessageDetails(<?php echo $message['MessageID']; ?>)">
                                        <?php echo htmlspecialchars($message['Message']); ?>
                                    </td>
                                    <td><?php echo date('m/d/Y', strtotime($message['Date'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div id="pagination" class="pagination">
                    <!-- Pagination links will be loaded here dynamically -->
                </div>
            </section>
        </div>
    </div>

    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <h2 id="modalMessageTitle"></h2>
            <p id="modalMessageContent"></p>
            <p id="modalMessageDate"></p>
            <button id="deleteMessageButton" onclick="deleteMessage()">Delete Message</button>
        </div>
    </div>

    <script>
        function redirectToIndex() {
            window.location.href = "../../html/index.html";
        }

        function loadMessages(page) {
            fetch('member-inbox.php?page=' + page + '&ajax=true')
                .then(response => response.json())
                .then(data => {
                    const inboxMessages = document.getElementById('inboxMessages');
                    const pagination = document.getElementById('pagination');

                    inboxMessages.innerHTML = ''; // Clear existing content

                    // Check if there are messages
                    if (data.messages.length === 0) {
                        inboxMessages.innerHTML = '<tr><td colspan="2">No messages found.</td></tr>';
                    } else {
                        data.messages.forEach(message => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td style="font-weight: ${message.isRead ? 'normal' : 'bold'};" onclick="showMessageDetails(${message.MessageID})">${message.Message}</td>
                                <td>${new Date(message.Date).toLocaleDateString()}</td>
                            `;
                            inboxMessages.appendChild(row);
                        });
                    }

                    // Generate pagination links
                    const totalPages = Math.ceil(data.total / data.limit);
                    pagination.innerHTML = ''; // Clear existing pagination

                    for (let i = 1; i <= totalPages; i++) {
                        const link = document.createElement('a');
                        link.href = '#';
                        link.textContent = i;
                        link.className = (i === data.page) ? 'active' : ''; // Highlight current page
                        link.onclick = (function(page) {
                            return function() {
                                loadMessages(page);
                            };
                        })(i);
                        pagination.appendChild(link);
                    }
                })
                .catch(error => console.error('Error fetching messages:', error));
        }

        function showMessageDetails(messageId) {
            fetch('member-inbox.php?message_id=' + messageId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalMessageTitle').innerText = 'Message Details';
                    document.getElementById('modalMessageContent').innerText = data.Message;
                    document.getElementById('modalMessageDate').innerText = new Date(data.Date).toLocaleString();
                    document.getElementById('deleteMessageButton').setAttribute('data-id', messageId);
                    document.getElementById('messageModal').style.display = 'block';
                })
                .catch(error => console.error('Error fetching message:', error));
        }

        function closeModal() {
            document.getElementById('messageModal').style.display = 'none';
        }

        function deleteMessage() {
            const messageId = document.getElementById('deleteMessageButton').getAttribute('data-id');
            fetch('member-inbox.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ delete_id: messageId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    loadMessages(1); // Reload the messages
                }
            })
            .catch(error => console.error('Error deleting message:', error));
        }

        // Load initial messages for the first page
        loadMessages(1);
    </script>

</body>
</html>
