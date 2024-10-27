<?php
// Start the session
session_start();

// Include database connection
$servername = "localhost";
$dbUsername = "root"; // Update if you have a different username
$dbPassword = ""; // Update if you have a password
$dbname = "pmpc"; // Your database name

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total members
$totalMembersQuery = "SELECT COUNT(*) as total FROM member";
$totalMembersResult = $conn->query($totalMembersQuery);
$totalMembers = $totalMembersResult->fetch_assoc()['total'];

// Fetch active member applications
$activeMemberApplicationsQuery = "SELECT COUNT(*) as total FROM membership_application WHERE Status = 'In Progress'";
$activeMemberApplicationsResult = $conn->query($activeMemberApplicationsQuery);
$activeMemberApplications = $activeMemberApplicationsResult->fetch_assoc()['total'];

// Fetch loan applications
$loanApplicationsQuery = "SELECT COUNT(*) as total FROM loanapplication";
$loanApplicationsResult = $conn->query($loanApplicationsQuery);
$loanApplications = $loanApplicationsResult->fetch_assoc()['total'];

// Fetch medical records
$medicalRecordsQuery = "SELECT COUNT(*) as total FROM medical";
$medicalRecordsResult = $conn->query($medicalRecordsQuery);
$medicalRecords = $medicalRecordsResult->fetch_assoc()['total'];

// Fetch account requests
$accountRequestsQuery = "SELECT COUNT(*) as total FROM Account_request";
$accountRequestsResult = $conn->query($accountRequestsQuery);
$accountRequests = $accountRequestsResult->fetch_assoc()['total'];

// Fetch appointments
$appointmentsQuery = "SELECT COUNT(*) as total FROM appointments";
$appointmentsResult = $conn->query($appointmentsQuery);
$appointments = $appointmentsResult->fetch_assoc()['total'];

// Fetch messages from members
$messagesQuery = "SELECT CONCAT(m.FirstName, ' ', m.LastName) AS MemberName, 
                         a.MessageContent, a.DateSent, a.MessageID 
                  FROM admin_messages a 
                  JOIN member m ON a.MemberID = m.MemberID 
                  ORDER BY a.DateSent DESC";
$messagesResult = $conn->query($messagesQuery);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/admin.css"> <!-- Linking CSS -->
    <link rel="stylesheet" href="../../css/admin-general.css">
    <link rel="stylesheet" href="../../css/member-inbox.css">
</head>
<body>
    <!-- Container for the sidebar and main content -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <img src="../../assets/pmpc-logo.png" alt="PMPC Logo">
                </div>
                <h2 class="pmpc-text">PASCHAL</h2> <!-- Text beside the logo -->
            </div>

            <ul class="sidebar-menu">
                <li><a href="admin.php" class="active">Dashboard</a></li>
                <li><a href="admin-members.php">Members</a></li>
                <li><a href="admin-loans.php">Loans</a></li>
                <li><a href="admin-transactions.php">Transactions</a></li>
                <li><a href="admin-appointments.php">Appointments</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Admin Panel</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <section class="dashboard-metrics">
                <div class="metric-box">
                    <h3><?php echo $totalMembers; ?></h3>
                    <p>Members</p>
                </div>
                <div class="metric-box">
                    <h3><?php echo $activeMemberApplications; ?></h3>
                    <p>Member Application</p>
                </div>
                <div class="metric-box">
                    <h3><?php echo $loanApplications; ?></h3>
                    <p>Loan Application</p>
                </div>
                <div class="metric-box">
                    <h3><?php echo $medicalRecords; ?></h3>
                    <p>Medical Records</p>
                </div>
                <div class="metric-box">
                    <h3><?php echo $accountRequests; ?></h3>
                    <p>Account Request</p>
                </div>
                <div class="metric-box">
                    <h3><?php echo $appointments; ?></h3>
                    <p>Appointments</p>
                </div>
            </section>

            <!-- Message Inbox Section -->
            <section class="inbox-section">
                <h2>Member Messages</h2>
                <table class="inbox-table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Message</th>
                            <th>Date Sent</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="inboxMessages">
                        <?php
                        if ($messagesResult->num_rows > 0) {
                            while ($message = $messagesResult->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$message['MemberName']}</td>
                                    <td>{$message['MessageContent']}</td>
                                    <td>" . date('F j, Y, g:i a', strtotime($message['DateSent'])) . "</td>
                                    <td>
                                        <button class='view-btn' onclick='showViewMessageModal({$message['MessageID']})'>View</button>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No messages found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>

        </div>
    </div>

    <!-- Modal for Viewing and Replying to Messages -->
    <div id="viewMessageModal" class="modal view-message-modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeViewMessageModal()">&times;</span>
            <h2 id="modalMessageTitle">Message Details</h2>
            <p id="modalMessageContent">Message content goes here...</p>
            <p id="modalMessageDate"></p>
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

    <!-- Dim Background Overlay -->
    <div id="modalBackground" class="modal-background"></div>

    <script>
        function redirectToIndex() {
            window.location.href = "../../html/index.html";
        }

        function showViewMessageModal(messageId) {
            fetch('admin-fetch-message.php?message_id=' + messageId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalMessageTitle').innerText = 'Message Details';
                    document.getElementById('modalMessageContent').innerText = data.Message;
                    document.getElementById('modalMessageDate').innerText = new Date(data.Date).toLocaleString();
                    document.getElementById('deleteMessageButton').setAttribute('data-id', messageId); // Set the message ID here
                    document.getElementById('viewMessageModal').style.display = 'flex';
                    document.getElementById('modalBackground').style.display = 'block'; // Show dim background
                })
                .catch(error => console.error('Error fetching message:', error));
        }

        function closeViewMessageModal() {
            document.getElementById('viewMessageModal').style.display = 'none';
            document.getElementById('modalBackground').style.display = 'none'; // Hide dim background
        }

        function openReplyModal() {
            const messageId = document.getElementById('deleteMessageButton').getAttribute('data-id'); // Get message ID from current modal
            document.getElementById('messageId').value = messageId;
            document.getElementById('replyMessageModal').style.display = 'flex';
            document.getElementById('viewMessageModal').style.display = 'none'; // Hide view message modal
        }

        function closeReplyModal() {
            document.getElementById('replyMessageModal').style.display = 'none';
            document.getElementById('modalBackground').style.display = 'none'; // Hide dim background
        }

        function deleteMessage() {
            const messageId = document.getElementById('deleteMessageButton').getAttribute('data-id'); // Get the message ID
            if (!messageId) {
                alert('No message selected for deletion.');
                return;
            }

            fetch('admin-delete-message.php', {
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
                    closeViewMessageModal(); // Close the modal
                    location.reload(); // Reload the page to update messages
                } else {
                    alert(data.error || 'Failed to delete message.');
                }
            })
            .catch(error => console.error('Error deleting message:', error));
        }

        function sendReply() {
            const messageId = document.getElementById('messageId').value;
            const replyContent = document.getElementById('replyContent').value;

            if (!replyContent) {
                alert('Please enter a reply.');
                return;
            }

            fetch('admin-reply.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    message_id: messageId,
                    reply_content: replyContent
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Reply sent successfully.');
                    closeReplyModal();
                } else {
                    alert(data.error || 'Failed to send reply.');
                }
            })
            .catch(error => console.error('Error sending reply:', error));
        }
    </script>
</body>
</html>
