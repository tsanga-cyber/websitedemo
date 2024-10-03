<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        button {
            margin: 5px;
        }
    </style>
</head>
<body>
    <h2>Order Management</h2>
    <form action="order_management.php" method="POST">
        <input type="hidden" name="order_id" id="order_id" value="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="order_name">Order Name:</label>
        <input type="text" id="order_name" name="order_name" required>
        <label for="service">Service:</label>
        <input type="text" id="service" name="service" required>
        <button type="submit" name="action" value="add">Add Order</button>
        <button type="submit" name="action" value="edit">Edit Order</button>
    </form>

    <h3>Current Orders</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Order Name</th>
            <th>Service</th>
            <th>Actions</th>
        </tr>
        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'logistic_company');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle adding and editing orders
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $order_name = $_POST['order_name'];
            $service = $_POST['service'];

            if ($_POST['action'] == 'add') {
                $stmt = $conn->prepare("INSERT INTO orders (name, order_name, service) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $order_name, $service);
                $stmt->execute();
                $stmt->close();
            } elseif ($_POST['action'] == 'edit') {
                $order_id = $_POST['order_id'];
                $stmt = $conn->prepare("UPDATE orders SET name = ?, order_name = ?, service = ? WHERE id = ?");
                $stmt->bind_param("sssi", $name, $order_name, $service, $order_id);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Handle deleting orders
        if (isset($_GET['delete'])) {
            $order_id = $_GET['delete'];
            $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $stmt->close();
        }

        // Fetch current orders
        $result = $conn->query("SELECT id, name, order_name, service FROM orders");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['order_name']}</td>
                    <td>{$row['service']}</td>
                    <td>
                        <button onclick=\"editOrder({$row['id']}, '{$row['name']}', '{$row['order_name']}', '{$row['service']}')\">Edit</button>
                        <a href=\"order_management.php?delete={$row['id']}\"><button>Delete</button></a>
                    </td>
                  </tr>";
        }
        $conn->close();
        ?>
    </table>

    <script>
        function editOrder(id, name, orderName, service) {
            document.getElementById('order_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('order_name').value = orderName;
            document.getElementById('service').value = service;
        }
    </script>
</body>
</html>
