<?php
// Start the session
session_start();

// Include database connection
$servername = "localhost";
$dbUsername = "root"; // Update if you have a different username
$dbPassword = ""; // Update if you have a password
$dbname = "pmpc"; // Your database name

// Connect to the database
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include the FPDF library
require('C:/xampp/htdocs/pmpc/html/fpdf186/fpdf.php'); // Ensure this path is correct

// Create instance of FPDF with A4 size
$pdf = new FPDF('L', 'mm', 'A4'); // Portrait orientation, millimeters, A4 size
$pdf->SetMargins(10, 10, 10); // Set margins: left, top, right
$pdf->AddPage();

// Set title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Membership Report', 0, 1, 'C');

// Fetch total active members
$totalMembersQuery = "SELECT COUNT(*) as total FROM member WHERE MembershipStatus = 'Active'";
$totalMembersResult = $conn->query($totalMembersQuery);
if (!$totalMembersResult) {
    die("Query failed: " . $conn->error);
}
$totalMembers = $totalMembersResult->fetch_assoc()['total'];

// Add total members to PDF
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Total Active Members: ' . $totalMembers, 0, 1);

// Fetch active members list
$membersQuery = "SELECT MemberID, LastName, FirstName, MiddleName, ContactNo, Email FROM member WHERE MembershipStatus = 'Active'";
$membersResult = $conn->query($membersQuery);

// Check if members exist and add to PDF
if ($membersResult->num_rows > 0) {
    $pdf->Cell(0, 10, 'Active Members List:', 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    
    // Define the cell widths based on page width
    $pdf->Cell(20, 10, 'Mem ID', 1);
    $pdf->Cell(40, 10, 'Last Name', 1);
    $pdf->Cell(40, 10, 'First Name', 1);
    $pdf->Cell(40, 10, 'Middle Name', 1);
    $pdf->Cell(30, 10, 'Phone Number', 1);
    $pdf->Cell(70, 10, 'Email', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    while ($row = $membersResult->fetch_assoc()) {
        $pdf->Cell(20, 10, htmlspecialchars($row['MemberID']), 1);
        $pdf->Cell(40, 10, htmlspecialchars($row['LastName']), 1);
        $pdf->Cell(40, 10, htmlspecialchars($row['FirstName']), 1);
        $pdf->Cell(40, 10, htmlspecialchars($row['MiddleName']), 1);
        $pdf->Cell(30, 10, htmlspecialchars($row['ContactNo']), 1);
        $pdf->Cell(70, 10, htmlspecialchars($row['Email']), 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No active members found.', 0, 1);
}

// Close the database connection
$conn->close();

// Set the header for download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="membership_report.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
header('Expires: 0');

// Output the PDF for download
$pdf->Output('D', 'membership_report.pdf'); // 'D' forces download
exit;
?>
