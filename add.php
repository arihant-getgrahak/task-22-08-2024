<?php include('connection.php');

$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$city = $_POST['city'];

$sql = "INSERT INTO student_info (name, email, mobile, city) VALUES ('$name', '$email', '$mobile', '$city')";

if ($conn->query($sql) === TRUE) {
    $data = array(
        'status' => 1,
        'message' => "User Added successfully"
    )
    ;
    echo json_encode($data);
} else {
    $data = array(
        'status' => 0,
        'message' => `Error: " . $sql . "<br>" . $conn->error`
    );
    echo json_encode($data);
}