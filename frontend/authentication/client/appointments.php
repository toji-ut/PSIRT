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
    $currentUserID = $_SESSION['UserID'];

    if (isset($_POST['acceptSitter'])) {
        // User clicked "Accept" button
        $orderID = $_POST['orderID'];
        $updateOrder = "UPDATE Orders SET ServiceState = 'confirmed' WHERE OrderID = $orderID";
        $conn->query($updateOrder);

        // Additional logic for handling the acceptance action
        // ...

        // Redirect to avoid form resubmission on refresh
        header("Location: ./appointments.php");
        exit();
    } else if (isset($_POST['declineSitter'])) {
        // User clicked "Decline" button
        $orderID = $_POST['orderID'];
        $updateOrder = "UPDATE Orders SET SitterID = null, ServiceState = 'pending' WHERE OrderID = $orderID";

        if ($conn->query($updateOrder) === TRUE) {
            // Redirect after declining the sitter
            header("Location: ./appointments.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="../../globalStyles/styles.css">
</head>
<body>

<div class="client-container">
    <section>
        <!-- Display assigned sitters and appointments -->
        <h2>Assigned Sitters and Appointments</h2>
        <!-- List of assigned sitters, appointments, and actions -->

        <?php
        // Your existing code...
        $currentUserID = $_SESSION['UserID'];

        $assignedSQL = "SELECT Orders.OrderID, Orders.OrderDate, Orders.DueDate, User.FirstName, User.LastName, Animal.AnimalType, Animal.is_sit_at_home, Animal.is_walk, Animal.is_groom
            FROM Orders 
            INNER JOIN User ON Orders.SitterID = User.UserID 
            LEFT JOIN Animal ON Orders.OrderID = Animal.OrderID
            LEFT JOIN Order_Comments ON Orders.OrderID = Order_Comments.OrderNumber
            WHERE Orders.ClientID = $currentUserID AND Orders.ServiceState = 'assigned'";

        $assignedResult = $conn->query($assignedSQL);

        if ($assignedResult->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Sitter Name</th><th>OrderID</th><th>Order Date</th><th>Due Date</th><th>Animal Type</th><th>Sit at Home</th><th>Walk</th><th>Groom</th><th>Accept</th><th>Decline</th></tr>';

            while ($row = $assignedResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
                echo "<td>" . $row['OrderID'] . "</td>";
                echo "<td>" . $row['OrderDate'] . "</td>";
                echo "<td>" . $row['DueDate'] . "</td>";
                echo "<td>" . $row['AnimalType'] . "</td>";
                echo "<td>" . ($row['is_sit_at_home'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . ($row['is_walk'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . ($row['is_groom'] ? 'Yes' : 'No') . "</td>";
                echo "<td>";
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='orderID' value='" . $row['OrderID'] . "'>";
                echo "<input type='submit' name='acceptSitter' value='Accept'>";
                echo "</form>";
                echo "</td>";
                echo "<td>";
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='orderID' value='" . $row['OrderID'] . "'>";
                echo "<input type='submit' name='declineSitter' value='Decline'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            echo '</table>';
        } else {
            echo "No assigned sitters or appointments found.";
        }
        ?>
    </section>

    <section>
        <!-- Display confirmed appointments -->
        <h2>Confirmed Appointments</h2>
        <!-- Display confirmed service records, feedback forms, etc. -->

        <?php
        // Display confirmed appointments
        $confirmedSQL = "SELECT Orders.OrderID, Orders.OrderDate, Orders.DueDate, User.FirstName, User.LastName, Animal.AnimalType, Animal.is_sit_at_home, Animal.is_walk, Animal.is_groom
            FROM Orders 
            INNER JOIN User ON Orders.SitterID = User.UserID 
            LEFT JOIN Animal ON Orders.OrderID = Animal.OrderID
            LEFT JOIN Order_Comments ON Orders.OrderID = Order_Comments.OrderNumber
            WHERE Orders.ClientID = $currentUserID AND Orders.ServiceState = 'confirmed'";

        $confirmedResult = $conn->query($confirmedSQL);

        if ($confirmedResult->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Sitter Name</th><th>OrderID</th><th>Order Date</th><th>Due Date</th><th>Animal Type</th><th>Sit at Home</th><th>Walk</th><th>Groom</th></tr>';

            while ($confirmedRow = $confirmedResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $confirmedRow['FirstName'] . " " . $confirmedRow['LastName'] . "</td>";
                echo "<td>" . $confirmedRow['OrderID'] . "</td>";
                echo "<td>" . $confirmedRow['OrderDate'] . "</td>";
                echo "<td>" . $confirmedRow['DueDate'] . "</td>";
                echo "<td>" . $confirmedRow['AnimalType'] . "</td>";
                echo "<td>" . ($confirmedRow['is_sit_at_home'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . ($confirmedRow['is_walk'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . ($confirmedRow['is_groom'] ? 'Yes' : 'No') . "</td>";
                echo "</tr>";
            }

            echo '</table>';
        } else {
            echo "No confirmed appointments found.";
        }
        ?>
    </section>
    <section>
        <form action="" method="post">
            <input type="submit" name="signOut" value="Sign Out">
        </form>
    </section>

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
    ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
