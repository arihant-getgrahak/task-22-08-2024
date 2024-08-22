<?php
include('connection.php');


$sql = "SELECT * FROM student_info";

$result = $conn->query($sql);

$count_all_rows = mysqli_num_rows($result);

if (isset($_POST['search']['value'])) {
    $search = $_POST['search']['value'];
    $sql .= " WHERE name LIKE '%" . $search . "%' ";
    $sql .= "OR email LIKE '%" . $search . "%' ";
    $sql .= "OR mobile LIKE '%" . $search . "%' ";
    $sql .= "OR city LIKE '%" . $search . "%' ";

    $result = $conn->query($sql);
    $count_all_rows = mysqli_num_rows($result);
}

if (isset($_POST['order'])) {
    $sql .= ' ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $sql .= ' ORDER BY id ASC ';
}

if ($_POST['length'] != -1) {
    $sql .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$data = array();
$result = $conn->query($sql);

$filtered_rows = mysqli_num_rows($result);

while ($row = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array[] = $row['id'];
    $sub_array[] = $row['name'];
    $sub_array[] = $row['email'];
    $sub_array[] = $row['mobile'];
    $sub_array[] = $row['city'];
    $sub_array[] = $sub_array[] = '<a href="javascript:void(0);" data-id="' . $row['id'] . '" class="btn btn-sm btn-info editBtn">Edit</a> <a href="javascript:void(0);" data-id="' . $row['id'] . '" class="btn btn-sm btn-danger Btndelete">Delete</a>';
    $data[] = $sub_array;
}

$output = array(
    'data' => $data,
    'recordsTotal' => $count_all_rows,
    'recordsFiltered' => $filtered_rows,
    "draw" => intval($_POST["draw"]),
);

echo json_encode($output);