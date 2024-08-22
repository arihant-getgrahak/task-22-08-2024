<?php include('connection.php');

$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$city = $_POST['city'];
$id = $_POST['id'];

$sql = "UPDATE student_info SET name = '$name', email = '$email', mobile = '$mobile', city = '$city' WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    $data = array(
        'status' => true,
    );

    echo json_encode($data);
} else {
    $data = array(
        'status' => false,
        "message" => "Error updating record: . '$conn->error'"
    );

    echo json_encode($data);
}