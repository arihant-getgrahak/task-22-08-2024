<?php include('connection.php');

$id = $_POST['id'];

$sql = "DELETE FROM student_info WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    $data = array(
        'status' => true
    );

    echo json_encode($data);
} else {
    $data = array(
        'status' => false,
        "message" => "Error deleting record: . '$conn->error'"
    );
    echo json_encode($data);
}