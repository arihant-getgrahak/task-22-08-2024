<?php
$conn = mysqli_connect('localhost', 'root', 'root', 'crud-app');

if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
    exit;
}


$sql = "CREATE TABLE IF NOT EXISTS student_info (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    mobile VARCHAR(10),
    city VARCHAR(30),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

if ($conn->query($sql) === TRUE) {
    // echo '<script language="javascript">';
    // echo 'alert("Database Connetced Successfullt")';
    // echo '</script>';
} else {
    // // echo "Error creating table: " . $conn->error;
    // echo '<script language="javascript">';
    // echo 'alert("Error creating table:")';
    // echo '</script>';
}