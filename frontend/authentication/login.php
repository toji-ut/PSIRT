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

    if ($result->num_rows > 0) {
        // Get the user's IP address (IPv4)
        $userIP = getHostByName(getHostName());

        // Extract IPv4 address if it's IPv6-mapped IPv4 address
        if (filter_var($userIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $userIP = trim(shell_exec("host -t A " . escapeshellarg($userIP)));
            $userIP = substr($userIP, strrpos($userIP, ' ') + 1);
        }

        // Get the user's ID
        $userID = $username; // Replace with the actual UserID

        // Set the UserID in the session
        $_SESSION['UserID'] = $userID;

        // Check if an entry exists for this user in the UserIP table
        $checkExistingQuery = "SELECT UserID FROM IP_Addresses WHERE UserID = '$userID'";
        $resultIP = $conn->query($checkExistingQuery);

        if ($resultIP->num_rows > 0) {
            // If an entry exists, update the IPv4 address
            $updateIPQuery = "UPDATE IP_Addresses SET IPAddress = '$userIP' WHERE UserID = '$userID'";
            $conn->query($updateIPQuery);
        } else {
            // If no entry exists, insert a new entry
            $insertIPQuery = "INSERT INTO IP_Addresses (UserID, IPAddress) VALUES ('$userID', '$userIP')";
            $conn->query($insertIPQuery);
        }

        $row = $result->fetch_assoc();
        $role = $row['Role'];

        // Redirect based on user role
        switch ($role) {
            case 'client':
                header("Location: ./client/appointments.php");
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
        // Invalid user, display an error message using JavaScript
        echo '<script>';
        echo 'alert("Invalid Password Or User");';
        echo 'window.location.href = "./login.html";';
        echo '</script>';
    }
}

$conn->close();
?>
