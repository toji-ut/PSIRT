<?php
session_start();

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "Onkar221";
$dbname = "PSIRT";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM User WHERE `UserID`='$username' AND `Password`='$password'";
    $result = $conn->query($sql);


    $userID =  $username;// Replace with the actual UserID

    // Start the session

    // Set the UserID in the session
    $_SESSION['UserID'] = $userID;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row['Role'];

        // Redirect based on user role
        switch ($role) {
            case 'client':
                header("Location: ./client/client.html");
                break;
            case 'sitter':
                header("Location: ./sitter/sitter.php");
                break;
            case 'handler':
                header("Location: ./handler/handler.php");
                break;
            default:
                echo "Invalid role";
        }
        exit();
    } else {
        // Invalid user, display an error message
        echo "Invalid username or password";
    }
}

$conn->close();
?>