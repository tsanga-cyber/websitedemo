<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
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
    <h2>User Information</h2>

    <form action="user_information.php" method="POST">
        <input type="hidden" name="user_id" id="user_id" value="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="action" value="edit">Edit User</button>
    </form>

    <h3>Current Users</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Actions</th>
        </tr>
        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'logistic_company');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle editing users
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'edit') {
            $user_id = $_POST['user_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password']; // Consider hashing this in a real application

            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $email, $password, $user_id);
            $stmt->execute();
            $stmt->close();
        }

        // Handle deleting users
        if (isset($_GET['delete'])) {
            $user_id = $_GET['delete'];
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();
        }

        // Fetch current users
        $result = $conn->query("SELECT id, name, email, password FROM users");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['password']}</td>
                    <td>
                        <button onclick=\"editUser({$row['id']}, '{$row['name']}', '{$row['email']}', '{$row['password']}')\">Edit</button>
                        <a href=\"user_information.php?delete={$row['id']}\"><button>Delete</button></a>
                    </td>
                  </tr>";
        }
        $conn->close();
        ?>
    </table>

    <script>
        function editUser(id, name, email, password) {
            document.getElementById('user_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>
