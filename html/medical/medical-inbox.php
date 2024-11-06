<?php
session_start();

// Prevent caching
header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 

// Check if the user is logged in
if (!isset($_SESSION['staffID'])) {
    header("Location: ../stafflogin.php");
    exit();
}

// Retrieve staffID from session
$staffId = $_SESSION['staffID'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Log errors to a file instead of displaying them
ini_set('log_errors', 1);
ini_set('error_log', 'path/to/error.log'); // Set the path to your PHP error log file

// Include database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "pmpc";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Start output buffering to catch any unwanted output
ob_start();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination variables
$limit = 5; // Messages per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total messages count
$countQuery = "SELECT COUNT(*) AS total FROM admin_messages WHERE Category = 'Medical'";
$countResult = $conn->query($countQuery);
$totalMessages = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalMessages / $limit);


// AJAX handler for paginated message loading
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ajax'])) {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $messagesQuery = "SELECT CONCAT(m.FirstName, ' ', m.LastName) AS MemberName, 
                             a.Category, a.MessageContent, a.DateSent, a.MessageID 
                      FROM admin_messages a 
                      JOIN member m ON a.MemberID = m.MemberID
                      WHERE a.Category = 'Medical' 
                      ORDER BY a.DateSent DESC
                      LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($messagesQuery);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $messagesResult = $stmt->get_result();

    $messages = [];
    while ($message = $messagesResult->fetch_assoc()) {
        $messages[] = $message;
    }

    echo json_encode([
        'messages' => $messages,
        'totalPages' => $totalPages
    ]);
    exit;
}


if (isset($_GET['check_new_messages'])) {
    header('Content-Type: application/json');

    // Fetch only unread messages
    $newMessagesQuery = "
        SELECT CONCAT(m.FirstName, ' ', m.LastName) AS MemberName, 
               a.Category, a.MessageContent, a.DateSent, a.MessageID 
        FROM admin_messages a 
        JOIN member m ON a.MemberID = m.MemberID 
        WHERE a.isViewed = 0 
        ORDER BY a.DateSent DESC
    ";
    $newMessagesResult = $conn->query($newMessagesQuery);

    $newMessages = [];
    if ($newMessagesResult->num_rows > 0) {
        while ($message = $newMessagesResult->fetch_assoc()) {
            $newMessages[] = $message;
        }
    }

    // Update `isViewed` status for newly fetched messages
    if (!empty($newMessages)) {
        $messageIds = implode(',', array_column($newMessages, 'MessageID'));
        $updateViewedQuery = "UPDATE admin_messages SET isViewed = 1 WHERE MessageID IN ($messageIds)";
        $conn->query($updateViewedQuery);
    }

    ob_end_clean();
    echo json_encode(['newMessages' => $newMessages]);
    exit;
}


// Handle AJAX requests based on the provided parameters
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['message_id'])) {
        $messageId = intval($_GET['message_id']);
        
        // Fetch the original message
        $query = "SELECT MessageContent, DateSent, isReplied FROM admin_messages WHERE MessageID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $messageId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = $result->fetch_assoc();
            if ($message['isReplied']) {
                // Fetch the reply from the inbox table
                $replyQuery = "SELECT Message, Date FROM inbox WHERE related_message_id = ?";
                $replyStmt = $conn->prepare($replyQuery);
                $replyStmt->bind_param("i", $messageId);
                $replyStmt->execute();
                $replyResult = $replyStmt->get_result();
                if ($replyResult->num_rows > 0) {
                    $reply = $replyResult->fetch_assoc();
                    $message['AdminReply'] = $reply['Message'];
                    $message['ReplyDate'] = $reply['Date'];
                }
            }
            ob_clean();
            header('Content-Type: application/json');
            echo json_encode($message);
        } else {
            ob_clean();
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Message not found']);
        }
        exit;
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id'])) {
        // Handle message deletion
        $deleteId = intval($_POST['delete_id']);
        $deleteQuery = "DELETE FROM admin_messages WHERE MessageID = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            ob_clean();
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } else {
            ob_clean();
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Message could not be deleted.']);
        }
        exit;
    }

    if (isset($_POST['message_id']) && isset($_POST['reply_content'])) {
        $messageId = intval($_POST['message_id']);
        $replyContent = $_POST['reply_content'];
    
        if (!empty($replyContent) && $messageId) {
            // Check if the message ID exists in admin_messages and get MemberID
            $checkMessageQuery = "SELECT MemberID FROM admin_messages WHERE MessageID = ?";
            $stmt = $conn->prepare($checkMessageQuery);
            $stmt->bind_param("i", $messageId);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $message = $result->fetch_assoc();
                $memberID = $message['MemberID']; // Get the MemberID from the original message
    
                // Insert reply into the inbox table
                $sendReplyQuery = "INSERT INTO inbox (MemberID, Message, Date, related_message_id) VALUES (?, ?, NOW(), ?)";
                $stmt = $conn->prepare($sendReplyQuery);
                $stmt->bind_param("isi", $memberID, $replyContent, $messageId); // Use the retrieved MemberID
    
                if ($stmt->execute()) {
                    // Update isReplied field in admin_messages table
                    $updateInboxQuery = "UPDATE admin_messages SET isReplied = 1 WHERE MessageID = ?";
                    $updateStmt = $conn->prepare($updateInboxQuery);
                    $updateStmt->bind_param("i", $messageId);
                    $updateStmt->execute();
    
                    ob_clean();
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                } else {
                    ob_clean();
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Reply could not be sent.']);
                }
            } else {
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Message not found.']);
            }
        } else {
            ob_clean();
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        }
        exit;
    }
    
    
    if (isset($_POST['message_content'])) {
        // Handle sending a new message
        $content = $_POST['message_content'];
        $memberID = $_POST['send_to'] !== 'all' ? intval($_POST['send_to']) : null;

        if (!empty($content)) {
            if ($memberID) {
                // Send to a specific member
                $sendMessageQuery = "INSERT INTO inbox (MemberID, Message, Date) VALUES (?, ?, NOW())";
                $stmt = $conn->prepare($sendMessageQuery);
                $stmt->bind_param("is", $memberID, $content);
            } else {
                // Send to all members
                $sendMessageQuery = "INSERT INTO inbox (MemberID, Message, Date) SELECT MemberID, ?, NOW() FROM member";
                $stmt = $conn->prepare($sendMessageQuery);
                $stmt->bind_param("s", $content);
            }

            if ($stmt->execute()) {
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
            } else {
                ob_clean();
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Message could not be sent.']);
            }
        } else {
            ob_clean();
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Message content is required.']);
        }
        exit;
    }
}

// Fetch paginated messages from members
$messagesQuery = "SELECT CONCAT(m.FirstName, ' ', m.LastName) AS MemberName, 
                         a.Category, a.MessageContent, a.DateSent, a.MessageID 
                  FROM admin_messages a 
                  JOIN member m ON a.MemberID = m.MemberID 
                  WHERE a.Category = 'medical'
                  ORDER BY a.DateSent DESC
                  LIMIT ? OFFSET ?";
$stmt = $conn->prepare($messagesQuery);
$stmt->bind_param("ii", $limit, $offset); // Bind limit and offset values
$stmt->execute();
$messagesResult = $stmt->get_result();


// Fetch member names for sending messages to specific members
$membersQuery = "SELECT MemberID, CONCAT(FirstName, ' ', LastName) AS MemberName FROM member";
$membersResult = $conn->query($membersQuery);

ob_end_clean();

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical - Inbox</title>
    <link rel="stylesheet" href="../../css/admin-dashboard.css">
    <link rel="stylesheet" href="../../css/member-general.css">
    <link rel="stylesheet" href="../../css/admin.css">
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
                <li><a href="medicalofficer.php" >Medical</a></li>
                <li><a href="medical-inbox.php" class="active">Inbox</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="#admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>Medical Officer Inbox</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <!-- Send Message Button -->
            <button class="send-message-button" onclick="openSendMessageModal()">Send Message</button>

            <!-- Message Inbox Section -->
            <section class="inbox-section">
                <table class="inbox-table">
                    <thead>
                        <tr>
                            <th>Member Name</th>
                            <th>Category</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="inboxMessages">
                        <?php
                        if ($messagesResult->num_rows > 0) {
                            while ($message = $messagesResult->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$message['MemberName']}</td>
                                    <td>{$message['Category']}</td>
                                    <td>{$message['MessageContent']}</td>
                                    <td>" . date('F j, Y, g:i a', strtotime($message['DateSent'])) . "</td>
                                    <td><button class='view-btn' onclick='showViewMessageModal({$message['MessageID']})'>View</button></td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No messages found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
                <!-- Pagination Controls -->
                <div id="pagination" class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="<?= ($i === $page) ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>


            

        </div>
    </div>

    <!-- Modal for Viewing and Replying to Messages -->
<div id="viewMessageModal" class="modal view-message-modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeViewMessageModal()">&times;</span>
        <h2 id="modalMessageTitle">Message Details</h2>
        <p id="modalMessageContent">Message content goes here...</p>
        <p id="modalMessageDate"></p>
        <h3>Admin Reply:</h3>
        <p id="adminReplyContent">No reply found.</p> <!-- Element to display admin reply -->
        <button id="deleteMessageButton" onclick="deleteMessage()">Delete</button>
        <button class="reply-btn" onclick="openReplyModal()">Reply</button>
    </div>
</div>

    <!-- Modal for Sending Replies -->
    <div id="replyMessageModal" class="modal send-message-modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeReplyModal()">&times;</span>
        <h2>Reply to Member</h2>
        <form id="replyMessageForm">
            <input type="hidden" id="messageId" name="message_id">
            <label for="replyContent">Your Reply</label>
            <textarea id="replyContent" name="reply_content" rows="4" required></textarea>
            <button type="button" onclick="sendReply()">Send Reply</button>
        </form>
    </div>
</div>


    <!-- Modal for Sending Message to Members -->
    <div id="sendMessageModal" class="modal send-message-modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeSendMessageModal()">&times;</span>
            <h2>Send a Message</h2>
            <form id="sendMessageForm">
            <label for="sendMessageTo">Send to:</label>
                <select id="sendMessageTo" name="send_to" required>
                    <option value="all">All Members</option>
                    <?php
                    while ($member = $membersResult->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($member['MemberID']) . "'>" . htmlspecialchars($member['MemberName']) . "</option>";
                    }
                    ?>
                </select>

                <label for="messageContent">Your Message</label>
                <textarea id="messageContent" name="message_content" rows="4" required></textarea>
                <button type="button" onclick="sendMessage()">Send Message</button>

            </form>
        </div>
    </div>

    <!-- Modal Background -->
    <div id="modalBackground" class="modal-background"></div>

    <!-- Scripts at the Bottom of the Body -->
    <script>
document.addEventListener("DOMContentLoaded", function () {

/// Automatically check for new messages every 2 seconds
setInterval(checkForNewMessages, 2000);

function checkForNewMessages() {
    fetch('medical-inbox.php?check_new_messages=true')
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                
                // Check if there are new messages
                if (data.newMessages && data.newMessages.length > 0) {
                    // Reload the current page to respect pagination
                    const currentPage = new URLSearchParams(window.location.search).get('page') || 1;
                    loadPageData(currentPage);
                }
            } catch (error) {
                console.error('Error parsing JSON:', error, 'Response text:', text);
            }
        })
        .catch(error => console.error('Error checking for new messages:', error));
}

// Load specific page data and update messages list
function loadPageData(page) {
    fetch(`medical-inbox.php?page=${page}&ajax=true`)
        .then(response => response.json())
        .then(data => {
            const inboxMessages = document.getElementById("inboxMessages");
            inboxMessages.innerHTML = ""; // Clear current messages

            data.messages.forEach(message => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${message.MemberName}</td>
                    <td>${message.Category}</td>
                    <td>${message.MessageContent}</td>
                    <td>${new Date(message.DateSent).toLocaleString()}</td>
                    <td><button class='view-btn' onclick='showViewMessageModal(${message.MessageID})'>View</button></td>
                `;
                inboxMessages.appendChild(row);
            });
        })
        .catch(error => console.error("Error loading page:", error));
}


document.querySelectorAll("#pagination a").forEach(link => {
    link.addEventListener("click", function(event) {
        event.preventDefault(); // Prevent page reload
        const page = this.getAttribute("href").split("page=")[1];

        fetch(`medical-inbox.php?page=${page}&ajax=true`)
            .then(response => response.json())
            .then(data => {
                const inboxMessages = document.getElementById("inboxMessages");
                inboxMessages.innerHTML = ""; // Clear current messages

                data.messages.forEach(message => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${message.MemberName}</td>
                        <td>${message.Category}</td>
                        <td>${message.MessageContent}</td>
                        <td>${new Date(message.DateSent).toLocaleString()}</td>
                        <td><button class='view-btn' onclick='showViewMessageModal(${message.MessageID})'>View</button></td>
                    `;
                    inboxMessages.appendChild(row);
                });
            })
            .catch(error => console.error("Error loading page:", error));
    });
});



    // Show the Send Message Modal
    function openSendMessageModal() {
        document.getElementById('sendMessageModal').classList.add('active');
        document.getElementById('modalBackground').style.display = 'block';
    }

    // Close the Send Message Modal
    function closeSendMessageModal() {
        document.getElementById('sendMessageModal').classList.remove('active');
        document.getElementById('modalBackground').style.display = 'none';
    }

    function showViewMessageModal(messageId) {
    fetch('medical-inbox.php?message_id=' + messageId)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalMessageTitle').innerText = 'Message Details';
            document.getElementById('modalMessageContent').innerText = data.MessageContent;
            document.getElementById('modalMessageDate').innerText = new Date(data.DateSent).toLocaleString();

            // Check if there's an admin reply
            const adminReplyContent = document.getElementById('adminReplyContent');
            if (data.AdminReply) {
                adminReplyContent.innerText = data.AdminReply; // Set the admin reply
            } else {
                adminReplyContent.innerText = "No reply found."; // Set default message
            }

            document.getElementById('deleteMessageButton').setAttribute('data-id', messageId);
            document.getElementById('viewMessageModal').style.display = 'flex';
            document.getElementById('modalBackground').style.display = 'block'; // Show dim background
        })
        .catch(error => console.error('Error fetching message:', error));
}


function closeViewMessageModal() {
    document.getElementById('viewMessageModal').style.display = 'none'; // Hide the modal
    document.getElementById('modalBackground').style.display = 'none'; // Hide the dim background
}


    // Show the Reply Modal
    function openReplyModal() {
        const messageId = document.getElementById('deleteMessageButton').getAttribute('data-id');
        document.getElementById('messageId').value = messageId;
        document.getElementById('replyMessageModal').classList.add('active');
        document.getElementById('viewMessageModal').classList.remove('active');
        document.getElementById('modalBackground').style.display = 'block';
    }

    // Close the Reply Modal
    function closeReplyModal() {
        document.getElementById('replyMessageModal').classList.remove('active');
        document.getElementById('modalBackground').classList.remove('active');
    }

    // Send the Reply
    function sendReply() {
        const messageId = document.getElementById('messageId').value;
        const replyContent = document.getElementById('replyContent').value;

        if (!replyContent) {
            alert('Please enter your reply.');
            return;
        }

        fetch('medical-inbox.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                message_id: messageId,
                reply_content: replyContent
            })
        })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    alert('Reply sent successfully.');
                    closeReplyModal();
                } else {
                    alert(data.error || 'Failed to send reply.');
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.error('Response text:', text); // Log the raw response for debugging
                alert('Unexpected response from server.');
            }
        })
        .catch(error => console.error('Error sending reply:', error));
    }

    // Delete the Message
    function deleteMessage() {
        const messageId = document.getElementById('deleteMessageButton').getAttribute('data-id');

        fetch('medical-inbox.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                delete_id: messageId
            })
        })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    alert('Message deleted successfully.');
                    closeViewMessageModal();
                    location.reload();
                } else {
                    alert('Failed to delete message.');
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.error('Response text:', text); // Log the raw response for debugging
                alert('Unexpected response from server.');
            }
        })
        .catch(error => console.error('Error deleting message:', error));
    }

    // Send the Message
    function sendMessage() {
        const content = document.getElementById('messageContent').value;
        const sendTo = document.getElementById('sendMessageTo').value;

        if (!content) {
            alert('Please enter a message.');
            return;
        }

        fetch('medical-inbox.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                message_content: content,
                send_to: sendTo
            })
        })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    alert('Message sent successfully.');
                    closeSendMessageModal();
                } else {
                    alert(data.error || 'Failed to send message.');
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.error('Response text:', text); // Log the raw response for debugging
                alert('Unexpected response from server.');
            }
        })
        .catch(error => console.error('Error sending message:', error));
    }

    // Attach functions to the global scope for HTML elements
    window.openSendMessageModal = openSendMessageModal;
    window.closeSendMessageModal = closeSendMessageModal;
    window.showViewMessageModal = showViewMessageModal;
    window.closeViewMessageModal = closeViewMessageModal;
    window.openReplyModal = openReplyModal;
    window.closeReplyModal = closeReplyModal;
    window.sendReply = sendReply;
    window.deleteMessage = deleteMessage;
    window.sendMessage = sendMessage;
});
</script>


</body>