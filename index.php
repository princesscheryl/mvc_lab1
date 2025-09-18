<?php
// ------------------------------------------------------
// Database connection settings for XAMPP
$servername = "127.0.0.1";     // or "localhost"
$username   = "root";          // XAMPP default user
$password   = "";              // leave empty unless you set one
$dbname     = "mylabdb";       // your database name
$port       = 3306;            // standard MySQL port (3307 is usually MariaDB)

// Create connection with error handling
try {
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    
    // Set charset to prevent character encoding issues
    $conn->set_charset("utf8");
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// SQL query to fetch data from students table
$sql = "SELECT id, name, major FROM students ORDER BY id ASC";

try {
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
} catch (Exception $e) {
    die("Query error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Table</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2 { 
            text-align: center; 
            margin-top: 20px; 
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .no-records {
            text-align: center;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>Student Records</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Major</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                // Output each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row["major"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='no-records'>No records found</td></tr>";
            }
            
            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>