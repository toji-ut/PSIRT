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

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header("Location: ../../mainPage.html");
        exit();
    }

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

    $comment = $_POST['comment'];

    // Get the due date from the datetime-local input
    $dueDate = null;

    if($animal === 'dog') {
    $dueDate = $_POST['selectedDateTime']; // Adjust the name based on your HTML form
    } else if($animal === 'cat'){
    $dueDate = $_POST['selectedDateTimeCat']; // Adjust the name based on your HTML form
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
            // Redirect to a different page to avoid form resubmission on refresh
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


