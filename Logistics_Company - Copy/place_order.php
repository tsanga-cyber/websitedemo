<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Your Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 50px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Place Your Order</h2>
        <form action="place_order.php" method="POST">
            <label for="user_name">Your Name:</label>
            <input type="text" id="user_name" name="user_name" required>
            <label for="order_name">Order Name:</label>
            <input type="text" id="order_name" name="order_name" required>
            <label for="service">Service:</label>
            <input type="text" id="service" name="service" required>
            <button type="submit">Submit Order</button>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_name = $_POST['user_name'];
        $order_name = $_POST['order_name'];
        $service = $_POST['service'];

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'logistic_company');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert the order into the orders table
        $stmt = $conn->prepare("INSERT INTO orders (name, order_name, service) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_name, $order_name, $service);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Order placed successfully!');
                    window.location.href='index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error placing order: " . $stmt->error . "');
                    window.location.href='order_form.php';
                  </script>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
