<?php
session_start();
session_regenerate_id(true);

// Check if the user is logged in
if (!isset($_SESSION['memberID'])) {
    header("Location: ../memblogin.html");
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Log errors to a file instead of displaying them
ini_set('log_errors', 1);
ini_set('error_log', 'path/to/error.log'); // Set the path to your PHP error log file

include('../db_connect.php');

// Get MemberID from session
$memberID = $_SESSION['memberID'] ?? null;

// Pagination variables
$limit = 6; // Number of messages per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


$memberID = $_SESSION['memberID'] ?? null;
$messages = [];
$totalMessages = 0;

// Load messages if memberID is set
if ($memberID) {
    // Fetch total messages
    $countQuery = "SELECT COUNT(*) as total FROM inbox WHERE MemberID = ?";
    $countStmt = $conn->prepare($countQuery);
    $countStmt->bind_param("i", $memberID);
    $countStmt->execute();
    $totalMessages = $countStmt->get_result()->fetch_assoc()['total'];
    
    // Fetch paginated messages
    $query = "SELECT Message, Date, isRead, MessageID FROM inbox WHERE MemberID = ? ORDER BY Date DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $memberID, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    
    // Handle AJAX request to load messages
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ajax'])) {
        echo json_encode(['messages' => $messages, 'total' => $totalMessages, 'page' => $page, 'limit' => $limit]);
        exit;
    }

    // Handle fetching a specific message details
if (isset($_GET['message_id'])) {
    $messageId = (int)$_GET['message_id'];
    
    // Fetch the message details
    $messageQuery = "SELECT Message, Date, related_message_id FROM inbox WHERE MessageID = ?";
    $messageStmt = $conn->prepare($messageQuery);
    $messageStmt->bind_param("i", $messageId);
    $messageStmt->execute();
    $messageResult = $messageStmt->get_result()->fetch_assoc();

    // Check if there is a related_message_id
    if ($messageResult['related_message_id']) {
        // Fetch the corresponding admin message
        $adminMessageQuery = "SELECT MessageContent, DateSent FROM admin_messages WHERE MessageID = ?";
        $adminMessageStmt = $conn->prepare($adminMessageQuery);
        $adminMessageStmt->bind_param("i", $messageResult['related_message_id']);
        $adminMessageStmt->execute();
        $adminMessageResult = $adminMessageStmt->get_result()->fetch_assoc();

        // Add admin message details to the response
        $messageResult['AdminMessage'] = $adminMessageResult['MessageContent'];
        $messageResult['AdminMessageDate'] = $adminMessageResult['DateSent'];
    }

    echo json_encode($messageResult);
    exit;
}


    // Handle message deletion
    if (isset($_POST['delete_id'])) {
        $deleteId = (int)$_POST['delete_id'];
        
        if ($deleteId) { // Ensure delete ID is valid
            $deleteQuery = "DELETE FROM inbox WHERE MessageID = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $deleteId);
            $deleteStmt->execute();

            if ($deleteStmt->affected_rows > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Message could not be deleted.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid message ID.']);
        }
        exit;
    }
} else {
    $messages = [];
    $totalMessages = 0;
}

// Handle sending a message to the admin
if (isset($_POST['message_category']) && isset($_POST['message_content'])) {
    $category = $_POST['message_category'];
    $content = $_POST['message_content'];

    if (!empty($category) && !empty($content)) {
        $sendMessageQuery = "INSERT INTO admin_messages (MemberID, Category, MessageContent, DateSent) VALUES (?, ?, ?, NOW())";
        $sendMessageStmt = $conn->prepare($sendMessageQuery);
        $sendMessageStmt->bind_param("iss", $memberID, $category, $content);
        if ($sendMessageStmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Message could not be sent.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
    }
    exit;
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
                <li><a href="member-services.php">Services</a></li>
                <li><a href="member-inbox.php" class="active">Inbox</a></li>
                <li><a href="member-about.php">About</a></li>
            </ul>
            <ul class="sidebar-settings">
                <li><a href="member-settings.php">Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>Inbox</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <!-- Add the "Send Message to Admin" button here -->
            <button class="send-message-button" onclick="openSendMessageModal()">Send Message to Admin</button>

            <section class="inbox-section">
                <table class="inbox-table">
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="inboxMessages">
                        <tr><td colspan="3">Loading messages...</td></tr>
                    </tbody>
                </table>
                <div id="pagination" class="pagination">
                    <!-- Pagination links will be loaded here dynamically -->
                </div>
            </section>
        </div>
    </div>

    <!-- Dim Background Overlay -->
    <div id="modalBackground" class="modal-background"></div>

    <!-- Open Message Modal (Center) -->
    <div id="viewMessageModal" class="modal view-message-modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeViewMessageModal()">&times;</span>
            <h2 id="modalMessageTitle">Message Details</h2>
            <p id="modalMessageContent">Message content goes here...</p>
            <p id="modalMessageDate"></p>
            <button id="deleteMessageButton" onclick="deleteMessage()">Delete Message</button>
        </div>
    </div>

    <!-- Send Message Modal (Bottom Right) -->
    <div id="sendMessageModal" class="modal send-message-modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeSendMessageModal()">&times;</span>
            <h2>Send a Message to Admin</h2>
            <form id="sendMessageForm">
                <label for="messageCategory">Select Message Category</label>
                <select id="messageCategory" name="message_category" required>
                    <option value="">Select Category</option>
                    <option value="General Query">General Query or Question</option>
                    <option value="Membership">About Membership</option>
                    <option value="Loan">About Loan</option>
                    <option value="Medical">About Medical</option>
                    <option value="Services">About Services</option>
                </select>
                <label for="messageContent">Your Message</label>
                <textarea id="messageContent" name="message_content" rows="4" required></textarea>
                <button type="button" onclick="sendMessage()">Send Message</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadMessages(1);
            setInterval(checkForNewMessages, 2000);
    

            function loadMessages(page) {
                fetch('member-inbox.php?page=' + page + '&ajax=true')
                    .then(response => response.json())
                    .then(data => {
                        const inboxMessages = document.getElementById('inboxMessages');
                        inboxMessages.innerHTML = '';
                        data.messages.forEach(message => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${message.Message}</td>
                        <td>${new Date(message.Date).toLocaleDateString()}</td>
                        <td><button class='view-btn' onclick="showViewMessageModal(${message.MessageID})">View</button></td>
                    `;
                            inboxMessages.appendChild(row);
                        });
                        setPagination(data.total, data.page, data.limit);
                    })
                    .catch(error => console.error('Error loading messages:', error));
            }

            function setPagination(total, page, limit) {
                const pagination = document.getElementById('pagination');
                pagination.innerHTML = '';
                const totalPages = Math.ceil(total / limit);
                for (let i = 1; i <= totalPages; i++) {
                    const link = document.createElement('a');
                    link.href = '#';
                    link.textContent = i;
                    link.className = (i === page) ? 'active' : '';
                    link.onclick = (function(i) {
                        return function(event) {
                            event.preventDefault();
                            loadMessages(i);
                        };
                    })(i);
                    pagination.appendChild(link);
                }
            }

            function checkForNewMessages() {
                fetch('member-inbox.php?page=1&ajax=true')
                    .then(response => response.json())
                    .then(data => {
                        loadMessages(1); // Reload first page if new messages are found
                    })
                    .catch(error => console.error('Error checking for new messages:', error));
            }
    

    // Function to show the view message modal
    function showViewMessageModal(messageId) {
    fetch('member-inbox.php?message_id=' + messageId)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalMessageTitle').innerText = 'Message Details';
            document.getElementById('modalMessageContent').innerText = data.Message;
            document.getElementById('modalMessageDate').innerText = new Date(data.Date).toLocaleString();

            // Check if there is an admin message to display
            if (data.related_message_id) {
                const adminMessageContent = data.AdminMessage || 'No reply found.';
                const adminMessageDate = new Date(data.AdminMessageDate).toLocaleString() || '';
                document.getElementById('modalMessageContent').innerText += `\n\nAdmin Replied to:\n${adminMessageContent} \n`;
            }

            // Set the messageId in the delete button's data attribute
            document.getElementById('deleteMessageButton').setAttribute('data-id', messageId);
            document.getElementById('viewMessageModal').style.display = 'flex';
            document.getElementById('modalBackground').style.display = 'block'; // Show dim background
        })
        .catch(error => console.error('Error fetching message:', error));
}


    // Function to close the view message modal
    function closeViewMessageModal() {
        document.getElementById('viewMessageModal').style.display = 'none'; // Hide the modal
        document.getElementById('modalBackground').style.display = 'none'; // Hide the dim background
    }

    // Function to open the send message modal
    function openSendMessageModal() {
        document.getElementById('sendMessageModal').style.display = 'flex';
        document.getElementById('modalBackground').style.display = 'block'; // Show dim background
    }

    // Function to close the send message modal
    function closeSendMessageModal() {
        document.getElementById('sendMessageModal').style.display = 'none';
        document.getElementById('modalBackground').style.display = 'none'; // Hide dim background
    }

    // Function to confirm deletion of a message
    function confirmDelete(messageId) {
        const confirmation = confirm("Are you sure you want to delete this message?");
        if (confirmation) {
            deleteMessage(messageId);
        }
    }

    // Function to delete a message
    function deleteMessage() {
    const messageId = document.getElementById('deleteMessageButton').getAttribute('data-id');
    
    if (!messageId) {
        alert("Invalid message ID.");
        return;
    }

    fetch('member-inbox.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            delete_id: messageId // Pass the message ID for deletion
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Message deleted successfully.');
            closeViewMessageModal();
            loadMessages(1); // Reload messages after deletion
        } else {
            alert(data.error || 'Failed to delete message.');
        }
    })
    .catch(error => console.error('Error deleting message:', error));
}


    // Function to send a message
    function sendMessage() {
        const category = document.getElementById('messageCategory').value;
        const content = document.getElementById('messageContent').value;

        if (!category || !content) {
            alert('Please fill out all fields.');
            return;
        }

        fetch('member-inbox.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                message_category: category,
                message_content: content
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Message sent successfully.');
                closeSendMessageModal();
            } else {
                alert(data.error || 'Failed to send message.');
            }
        })
        .catch(error => console.error('Error sending message:', error));
    }

    // Attach functions to the global scope for HTML elements
    window.openSendMessageModal = openSendMessageModal;
    window.closeSendMessageModal = closeSendMessageModal;
    window.showViewMessageModal = showViewMessageModal;
    window.closeViewMessageModal = closeViewMessageModal;
    window.confirmDelete = confirmDelete;
    window.deleteMessage = deleteMessage;
    window.sendMessage = sendMessage;
});

    </script>
</body>
</html>