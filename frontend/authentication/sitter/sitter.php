<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sitter Dashboard</title>
    <link rel="stylesheet" href="../../globalStyles/styles.css">
</head>
<body>

<div class="sitter-container">
    <section>
        <!-- List of assigned service requests and access to client info -->
        <h2>Assigned Service Requests</h2>
        <!-- Display client info, service report forms, etc. -->

        <?php

        // Establish database connection
        $servername = "localhost";
        $username = "root";
        $password = "Onkar221";
        $dbname = "PSIRT";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Start the session
        session_start();

        // Set the UserID in the session
        $currentUserID = $_SESSION['UserID'];

        // Retrieve data from the database
        $sql = "SELECT OrderID, ServiceState, ClientID, OrderDate, DueDate FROM Orders WHERE `SitterID` = $currentUserID AND `ServiceState`= 'assigned'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>OrderID</th><th>Service State</th><th>Client ID</th><th>Order Date</th><th>Due Date</th><th>Action</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['OrderID'] . "</td>";
                echo "<td>" . $row['ServiceState'] . "</td>";
                echo "<td>" . $row['ClientID'] . "</td>";
                echo "<td>" . $row['OrderDate'] . "</td>";
                echo "<td>" . $row['DueDate'] . "</td>";
                echo "<td>";
                echo '<form action="" method="post">';
                echo '<input type="hidden" name="orderID" value="' . $row['OrderID'] . '">';
                echo '<input type="submit" name="completeOrder" value="Complete">';
                echo '</form>';
                echo "</td>";
                echo "</tr>";
            }
        }

        echo '</table>';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['completeOrder'])) {
            $orderID = $_POST['orderID'];

            // Update the status of the order from "Assigned" to "Completed"
            $updateQuery = "UPDATE Orders SET ServiceState = 'completed' WHERE OrderID = $orderID";

            if ($conn->query($updateQuery) === TRUE) {
                header("Location: ./sitter.php"); // Redirect to the sitter dashboard after completion
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }

        $conn->close();
        ?>

    </section>

    <section>
        <!-- Display completed services and actions -->
        <h2>Completed Services</h2>
        <!-- Display completed service records, feedback forms, etc. -->

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

        // Retrieve data from the database
        $sql = "SELECT OrderID, ServiceState, ClientID, OrderDate, DueDate FROM Orders WHERE `ServiceState`= 'completed'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>OrderID</th><th>Service State</th><th>Client ID</th><th>Order Date</th><th>Due Date</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['OrderID'] . "</td>";
                echo "<td>" . $row['ServiceState'] . "</td>";
                echo "<td>" . $row['ClientID'] . "</td>";
                echo "<td>" . $row['OrderDate'] . "</td>";
                echo "<td>" . $row['DueDate'] . "</td>";
                echo "</tr>";
            }
        }

        echo '</table>';
        $conn->close();
        ?>
    </section>
</div>

</body>
</html>
