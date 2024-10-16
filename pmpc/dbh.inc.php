<?

$host = 'localhost'; // Update with your host
$user = 'root';      // Update with your database username
$password = '';      // Update with your database password
$dbname = 'pmpc';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}