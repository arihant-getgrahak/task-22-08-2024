<?php include('connection.php');

$id = $_POST['id'];

$sql = "SELECT * FROM student_info WHERE id = '$id'";

$result = $conn->query($sql);

$count_all_rows = mysqli_num_rows($result);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
}


