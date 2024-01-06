<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Handler Dashboard</title>
    <link rel="stylesheet" href="../../globalStyles/styles.css">
</head>
<body>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signOut'])) {
    // Unset all session variables
    $_SESSION = array();

    session_destroy();

    header("Location: ../../mainPage.html");
    exit();
}
?>

<div class="handler-container">
    <section>
        <!-- Display of service requests, their status, and actions -->
        <h2>Service Requests</h2>
        <!-- List of orders, accept/deny buttons -->
        <?php
        session_start();

        // Establish database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "PSIRT";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignSitter'])) {
            $orderID = $_POST['orderID'];
            $selectedSitterID = $_POST['sitterSelection'];

            // Update the order with the assigned sitter and change ServiceState from pending to assigned
            $updateQuery = "UPDATE Orders SET SitterID = $selectedSitterID, ServiceState = 'assigned' WHERE OrderID = $orderID";

            if ($conn->query($updateQuery) === TRUE) {
                header("Location: ./handler.php"); 
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }

        $sql = "SELECT Orders.OrderID, Orders.ServiceState, Orders.ClientID, Orders.OrderDate, Orders.DueDate, Order_Comments.CommentText, Animal.AnimalType, Animal.is_sit_at_home, Animal.is_walk, Animal.is_groom
                FROM Orders
                LEFT JOIN Order_Comments ON Orders.OrderID = Order_Comments.OrderNumber
                LEFT JOIN Animal ON Orders.OrderID = Animal.OrderID
                WHERE Orders.ServiceState = 'pending'";
        $result = $conn->query($sql);

        $sqlSitters = "SELECT UserID, FirstName, LastName FROM User WHERE Role = 'sitter'";
        $sitterResult = $conn->query($sqlSitters);

        echo '<table>';
        echo '<tr><th>OrderID</th><th>Service State</th><th>Client ID</th><th>Order Date</th><th>Due Date</th><th>Comment Text</th><th>Animal Type</th><th>Sit at Home</th><th>Walk</th><th>Groom</th><th>Sitters Offered</th><th>Assign Sitter</th></tr>';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['OrderID'] . "</td>";
                echo "<td>" . $row['ServiceState'] . "</td>";
                echo "<td>" . $row['ClientID'] . "</td>";
                echo "<td>" . $row['OrderDate'] . "</td>";
                echo "<td>" . $row['DueDate'] . "</td>";
                echo "<td>" . $row['CommentText'] . "</td>";
                echo "<td>" . $row['AnimalType'] . "</td>";
                echo "<td>" . ($row['is_sit_at_home'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . ($row['is_walk'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . ($row['is_groom'] ? 'Yes' : 'No') . "</td>";
                echo "<td>"; 

                // Dropdown menu for available sitters
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='orderID' value='" . $row['OrderID'] . "'>";
                echo "<select name='sitterSelection'>";
                while ($sitterRow = $sitterResult->fetch_assoc()) {
                    echo "<option value='" . $sitterRow['UserID'] . "'>" . $sitterRow['FirstName'] . " " . $sitterRow['LastName'] . "</option>";
                }
                echo "</select>";

                echo "</td>";
                echo "<td>"; 

                // Assign button for each row
                echo "<input type='submit' name='assignSitter' value='Assign'>";

                echo "</form>";

                echo "</td>";
                echo "</tr>";

                // Reset sitters result pointer for next row
                $sitterResult->data_seek(0);
            }
        } else {
            echo "<p>No pending service requests.</p>";
        }

        echo '</table>';

        $conn->close();
        ?>

        <section>
            <form action="" method="post">
                <input type="submit" name="signOut" value="Sign Out">
            </form>
        </section>
    </section>
</div>

</body>
</html>
