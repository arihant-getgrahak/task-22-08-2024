<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.1.4/datatables.min.css" rel="stylesheet">
</head>
<title>Student Management System</title>
</head>

<body>
  <h1 class="text-center">Student Management System</h1>
  <div class="container-fluid">
    <div class="row">
      <div class="container">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModel">
              Add User
            </button>

          </div>
        </div>
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8 mt-5">
            <table id="student_table" class="table">
              <thead>
                <th>SNo.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>City</th>
                <th>Options</th>
              </thead>
              <tbody>
                <td>01</td>
                <td>Arihant Jain</td>
                <td>arihant.jain@getgrahak.in</td>
                <td>+919672670732</td>
                <td>Jaipur</td>
                <td>
                  <a href="edit.php">Edit</a>
                  <a href="delete.php">Delete</a>
                </td>
              </tbody>
            </table>
          </div>
          <div class="col-md-2"></div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.1.4/datatables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <script type="text/javascript">
    $("#student_table").DataTable({
      'serverSide': true,
      "processing": true,
      "paging": true,
      "order": [],
      "ajax": {
        url: "fetch.php",
        type: "POST",
      },
      "fnCreateRow": function (nRow, aData, iDataIndex) {
        $(nRow).attr('id', aData[0]);
      },
      "columnDefs": [{
        "targets": [0, 5],
        "orderable": false
      }]
    });
    // </script>


  <script type="text/javascript">
    $(document).on("submit", "#add_user_form", function (e) {
      e.preventDefault();
      var name = $("#name").val();
      var email = $("#email").val();
      var mobile = $("#mobile").val();
      var city = $("#city").val();

      if (name == "" || email == "" || mobile == "" || city == "") {
        alert("Please enter all fields");
        return false;
      }
      $.ajax({
        url: "add.php",
        type: "POST",
        data: {
          name: name,
          email: email,
          mobile: mobile,
          city: city
        },
        success: function (data) {
          var json = JSON.parse(data);
          console.log(json);
          console.log(json.status)
          status = json.status;
          if (!status) {
            alert("Error: " + json.message);
            return false;
          }

          $("#addUserModel").modal("hide");
          $("#student_table").DataTable().ajax.reload();
          alert("User added successfully");
        }
      });
    })

    $(document).on("click", ".editBtn", function () {
      var id = $(this).data("id");
      var trid = $(this).closest('tr').attr('id');
      $.ajax({
        url: "fetch_single.php",
        type: "POST",
        data: {
          id: id
        },
        success: function (data) {
          var json = JSON.parse(data);
          $("#id").val(json.id);
          $("#trid").val(trid);
          $("#_name").val(json.name);
          $("#_email").val(json.email);
          $("#_mobile").val(json.mobile);
          $("#_city").val(json.city);
          $("#editUserModel").modal("show");
        }
      });
    })
    $(document).on("submit", "#edit_user_form", function (e) {
      e.preventDefault();
      var id = $("#id").val();
      var trid = $("#trid").val();
      var name = $("#_name").val();
      var email = $("#_email").val();
      var mobile = $("#_mobile").val();
      var city = $("#_city").val();
      if (name == "" || email == "" || mobile == "" || city == "") {
        alert("Please enter all fields");
        return false;
      }

      $.ajax({
        url: "update.php",
        type: "POST",
        data: {
          id: id,
          name: name,
          email: email,
          mobile: mobile,
          city: city
        },
        success: function (data) {
          var json = JSON.parse(data);
          status = json.status;
          if (!status) {
            alert("Error: " + json.message);
            return false;
          } else {
            table = $("#student_table").DataTable();
            var button = `
              <a href="javascript:void();" data-id="${id}" class="btn btn-sm btn-info editBtn">Edit</a>
              <a href="javascript:void();" data-id="${id}" class="btn btn-sm btn-danger Btndelete">Delete</a>
              `;
            var row = table.row("[id='" + trid + "']");
            row.row("[id='" + trid + "']").data([id, name, email, mobile, city, button]);
            $("#editUserModel").modal("hide");
            alert("User updated successfully");
          }
        }
      })
    });
    $(document).on("click", ".Btndelete", function () {
      var id = $(this).data("id");
      if (confirm("Are you sure you want to delete this user?")) {
        $.ajax({
          url: "delete.php",
          type: "POST",
          data: {
            id: id
          },
          success: function (data) {
            var json = JSON.parse(data);
            status = json.status;
            if (!status) {
              alert("Error: " + json.message);
              return false;
            } else {
              $("#" + id).closest('tr').remove()
            }
          }
        });
      }
    })

  </script>

  <!-- add user model -->
  <div class="modal fade" id="addUserModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="add_user_form" action="javascript:void(0)" method="POST">
          <div class="modal-body">
            <div class="mb-3 row">
              <label for="name" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="email" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="email">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="mobile" class="col-sm-2 col-form-label">Mobile Number</label>
              <div class="col-sm-10">
                <input type="tel" class="form-control" id="mobile">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="city" class="col-sm-2 col-form-label">City</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="city">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- edit modal -->
  <div class="modal fade" id="editUserModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="edit_user_form" action="javascript:void(0)" method="POST">
          <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="trid" id="trid">
            <div class="mb-3 row">
              <label for="_name" class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="_name">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="_email" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="_email">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="_mobile" class="col-sm-2 col-form-label">Mobile Number</label>
              <div class="col-sm-10">
                <input type="tel" class="form-control" id="_mobile">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="_city" class="col-sm-2 col-form-label">City</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="_city">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>