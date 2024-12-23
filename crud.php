<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create operation
if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $conn->query("INSERT INTO users (name, email, age) VALUES ('$name', '$email', $age)");
}

// Update operation
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $conn->query("UPDATE users SET name='$name', email='$email', age=$age WHERE id=$id");
}

// Delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
}

// Read operation (fetch all users)
$users = $conn->query("SELECT * FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
    <style>
        /* Basic reset */
        body, h1, h2, table, form {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        h2 {
            color: #007BFF;
            margin-bottom: 10px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        form input[type="text"], form input[type="email"], form input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td a {
            color: #007BFF;
            text-decoration: none;
            margin-right: 10px;
        }

        td a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create User</h2>
        <form method="POST">
            Name: <input type="text" name="name" required><br><br>
            Email: <input type="email" name="email" required><br><br>
            Age: <input type="number" name="age" required><br><br>
            <button type="submit" name="create">Create</button>
        </form>

        <h2>Users List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $users->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td>
                            <a href="?edit=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if (isset($_GET['edit'])): ?>
            <?php
            $edit_id = $_GET['edit'];
            $edit_result = $conn->query("SELECT * FROM users WHERE id=$edit_id");
            $edit_row = $edit_result->fetch_assoc();
            ?>
            <h2>Edit User</h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $edit_row['id']; ?>">
                Name: <input type="text" name="name" value="<?php echo $edit_row['name']; ?>" required><br><br>
                Email: <input type="email" name="email" value="<?php echo $edit_row['email']; ?>" required><br><br>
                Age: <input type="number" name="age" value="<?php echo $edit_row['age']; ?>" required><br><br>
                <button type="submit" name="update">Update</button>
            </form>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
