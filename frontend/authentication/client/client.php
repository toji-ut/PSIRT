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

    //echo $animal, " ", $sitAtHome, " ", $walk, " ", $groom;
    // echo $currentUserID, "\n";

    // Insert a new order
    $createOrder = "INSERT INTO Orders(ClientID, ServiceState, OrderDate) VALUES ($currentUserID,'pending', NOW())";

    $conn->query($createOrder);
    // Get the last inserted OrderID
    $orderID = $conn->insert_id;

    // Insert data into Animal table with the obtained OrderID
    $logOrder = "INSERT INTO Animal(OrderID, AnimalType, is_sit_at_home, is_walk, is_groom) VALUES ($orderID, '$animal', $sitAtHome, $walk, $groom)";


    if ($conn->query($logOrder) === TRUE) {
        //echo "New records created successfully";

        // Redirect to a different page to avoid form resubmission on refresh
        header("Location: ../../SuccessPage.html");
        exit();
    }
}

$conn->close();
?>



