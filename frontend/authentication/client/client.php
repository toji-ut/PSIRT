<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Requests and Comments</title>
    <link rel="stylesheet" href="../../globalStyles/styles.css">
</head>
<body>

<p>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signOut'])) {
        // Unset all session variables
        $_SESSION = array();

        session_destroy();

        header("Location: ../../mainPage.html");
        exit();
    }

    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
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

    $comment = $_POST['comment'];

    $dueDate = null;

    if($animal === 'dog') {
    $dueDate = $_POST['selectedDateTime']; 
    } else if($animal === 'cat'){
    $dueDate = $_POST['selectedDateTimeCat']; 
    }

    // Insert a new order with due date
    $createOrder = "INSERT INTO Orders(ClientID, OrderDate, DueDate) VALUES ($currentUserID, NOW(), '$dueDate')";
    $conn->query($createOrder);

    // Get the last inserted OrderID
    $orderID = $conn->insert_id;

    // Insert data into Animal table with the obtained OrderID
    $logOrder = "INSERT INTO Animal(OrderID, AnimalType, is_sit_at_home, is_walk, is_groom) VALUES ($orderID, '$animal',
    $sitAtHome, $walk, $groom)";

        if ($conn->query($logOrder) === TRUE) {

        $logComment = "INSERT INTO Order_Comments(OrderNumber, ResponderID, CommentText, CommentDate) VALUES ($orderID,
        $currentUserID, '$comment', NOW())";

            if($conn->query($logComment) === TRUE) {
            header("Location: ./appointments.php");
            exit();
            }
        }
    }

    $conn->close();

    ?>

</p>

</body>
</html>


