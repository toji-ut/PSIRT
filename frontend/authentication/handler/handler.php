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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignSitter'])) {
            $orderID = $_POST['orderID'];
            $selectedSitterID = $_POST['sitterSelection'];

            // Update the order with the assigned sitter and change ServiceState from pending to assigned
            $updateQuery = "UPDATE Orders SET SitterID = $selectedSitterID, ServiceState = 'assigned' WHERE OrderID = $orderID";

            if ($conn->query($updateQuery) === TRUE) {
                header("Location: ./handler.php"); // Redirect after assigning the sitter
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }

        $sql = "SELECT OrderID, ServiceState, ClientID, OrderDate, DueDate FROM Orders WHERE `ServiceState`= 'pending'";
        $result = $conn->query($sql);

        $sqlSitters = "SELECT UserID, FirstName, LastName FROM User WHERE Role = 'sitter'";
        $sitterResult = $conn->query($sqlSitters);

        echo '<table>';
        echo '<tr><th>OrderID</th><th>Service State</th><th>Client ID</th><th>Order Date</th><th>Due Date</th><th>Sitters Offered</th><th>Assign Sitter</th></tr>';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['OrderID'] . "</td>";
                echo "<td>" . $row['ServiceState'] . "</td>";
                echo "<td>" . $row['ClientID'] . "</td>";
                echo "<td>" . $row['OrderDate'] . "</td>";
                echo "<td>" . $row['DueDate'] . "</td>";
                echo "<td>"; // Column for dropdown menu

                // Dropdown menu for available sitters
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='orderID' value='" . $row['OrderID'] . "'>";
                echo "<select name='sitterSelection'>";
                while ($sitterRow = $sitterResult->fetch_assoc()) {
                    echo "<option value='" . $sitterRow['UserID'] . "'>" . $sitterRow['FirstName'] . " " . $sitterRow['LastName'] . "</option>";
                }
                echo "</select>";

                echo "</td>";
                echo "<td>"; // Column for assign button

                // Assign button for each row
                echo "<input type='submit' name='assignSitter' value='Assign'>";

                echo "</form>";

                echo "</td>";
                echo "</tr>";

                // Reset sitters result pointer for next row
                $sitterResult->data_seek(0);
            }
        }

        echo '</table>';

        $conn->close();
        ?>
    </section>
</div>

</body>
</html>