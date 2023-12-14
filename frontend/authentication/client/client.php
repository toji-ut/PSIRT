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
    $animal = $_POST['requestType'];
    $sitAtHome = isset($_POST['sitAtHome']) ? 1 : 0;
    $walk = isset($_POST['walk']) ? 1 : 0;
    $groom = isset($_POST['groom']) ? 1 : 0;
    $currentUserID = $_SESSION['UserID'];

    $dueDate = null;

    // Get the due date from the datetime-local input
    if($animal === 'dog') {
        $dueDate = $_POST['selectedDateTimeDog'];
    } else if($animal === 'cat'){
        $dueDate = $_POST['selectedDateTimeCat'];
    }

    // Insert a new order with due date
    $createOrder = "INSERT INTO Orders(ClientID, OrderDate, DueDate) VALUES ($currentUserID, NOW(), $dueDate)";
    $conn->query($createOrder);

    // Get the last inserted OrderID
    $orderID = $conn->insert_id;

    // Insert data into Animal table with the obtained OrderID
    $logOrder = "INSERT INTO Animal(OrderID, AnimalType, is_sit_at_home, is_walk, is_groom) VALUES ($orderID, '$animal', $sitAtHome, $walk, $groom)";
    if ($conn->query($logOrder) === TRUE) {

        // Redirect to a different page to avoid form resubmission on refresh
        header("Location: ../../SuccessPage.html");
        exit();
    }
}

$conn->close();
?>
