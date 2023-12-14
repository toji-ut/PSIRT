<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Handler Dashboard</title>
    <link rel="stylesheet" href="../../globalStyles/styles.css">
</head>
<body>

<div class="handler-container">
    <section>
        <!-- Display of service requests, their status, and actions -->
        <h2>Service Requests</h2>
        <!-- List of service requests, accept/deny buttons, etc. -->
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

        $sql = "SELECT OrderID, ServiceState, ClientID, OrderDate, DueDate FROM Orders WHERE `ServiceState`= 'pending'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>OrderID</th><th>Service State</th><th>Client ID</th><th>Order Date</th><th>Due Date</th></tr>';

            // Loop through the fetched data and display it in table rows
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


        ?>
    </section>
</div>

</body>
</html>


