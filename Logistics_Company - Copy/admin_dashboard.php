<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #5cb85c;
            padding: 10px;
            color: white;
            text-align: right;
        }
        .sidebar {
            width: 200px;
            background-color: #333;
            color: white;
            height: 100vh;
            position: fixed;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <span>Welcome, Admin</span>
    </div>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php?page=users">User Information</a>
        <a href="admin_dashboard.php?page=orders">Order Management</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <?php
        if (isset($_GET['page']) && $_GET['page'] == 'orders') {
            include 'order_management.php';
        } else {
            include 'user_information.php';
        }
        ?>
    </div>
</body>
</html>
