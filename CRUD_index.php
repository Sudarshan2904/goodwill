
<?php

$insert = false;
$update = false;
$delete = false;
// Connecting to a DataBase:
$server_name = "localhost";
$username = "root";
$password = "";
$database = "noteapp";

// Create a connection 
$conn = mysqli_connect($server_name,$username,$password, $database);

// Die if connection was not successful 
if (!$conn){
    die ("Sorry we failed to connect: ". mysqli_connect_error());
}

  if(isset($_GET['delete'])){
    $srno = $_GET['delete'];
    $delete = true;
    //SQL Query to be executed:  
    $sql = "DELETE FROM `notes` WHERE `srno` = $srno";
    $result =  mysqli_query($conn, $sql);
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
  if (isset($_POST['snoEdit'])){
    $edit = true;
    // Update the record 
    $srno = $_POST['snoEdit'];
    $title = $_POST['titleedit'];
    $description = $_POST['descriptionedit'];


    // Updating a data in the table of DB  
    $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`srno` = '$srno';";
    $result =  mysqli_query($conn, $sql);
    if($result){
      $update = true;
    }
    else{
      echo "The record has not been updated successfully because of this error --> ". mysqli_error($conn); 
      }
    }

  else{
  $title = $_POST['title'];
  $description = $_POST['description'];


// Inserting a data in the table of DB  
$sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
$result =  mysqli_query($conn, $sql);

// check for table creation success 
if($result){
    $insert = true;
}
else{
    echo "The record has not been inserted successfully because of this error --> ". mysqli_error($conn); 
    }
}
}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script 
    src="https://code.jquery.com/jquery-3.5.1.js"
    integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous">
    </script>
    

    <title>CRUD APP-PHP</title>
   
  </head>
  <body>

  <!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit modal
</button> -->
<!--Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/sudphp/CRUD_index.php" method="post">
      <div class="modal-body">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="form-group">
            <label for="exampleInputEmail1">Note Title Edit</label>
            <input type="text" class="form-control" id="titleedit" name="titleedit" aria-describedby="emailHelp" placeholder="">
          </div>
         
          <div class="form-group">
            <label for="description">Note Description Edit</label>
            <textarea class="form-control" id="descriptionedit" name="descriptionedit" rows="3"></textarea>
          </div>
          <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
          </div>
        <div class="modal-footer d-block m-auto">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>



    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">iNotes</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
         
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>

    <?php
      if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> You note has been inserted successfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
    ?>

    <?php
      if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> You note has been deleted successfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
    ?>

    <?php
      if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> You note has been updated successfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
    ?>

    <div class="container my-4">
      <h2>Add a Note</h2>
      <form action="/sudphp/CRUD_index.php?" method="post">
        <div class="form-group">
          <label for="exampleInputEmail1">Note Title</label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" placeholder="">
        </div>
       
        <div class="form-group">
          <label for="description">Note Description</label>
          <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
    </div>

    <div class="container my-4" ">
      <table class="table " id="myTable"  >
        <thead>
          <tr>
            <th scope="col">Sr.No</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php
          // 2]
          //  SQL Query to be executed:  
          $sql = "SELECT * FROM `notes`";
          $result =  mysqli_query($conn, $sql);

          // Display the rows returned by the SQL query:
          $srno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $srno +=1;
              echo  "<tr>
              <th scope='row'> ".$srno ." </th>
              <td>".$row['title'] ."</td>
              <td>".$row['description'] ."</td>
              <td> <button class='edit btn btn-primary' id=".$row['srno']."> Edit </button> <button class='delete btn btn-primary' id=d".$row['srno']."> Delete </button> </td>
            </tr>";
          }
        ?>
        </tbody> 
      </table>
    </div>
    <hr>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
      $('#myTable').DataTable();
      } );
    </script>
     <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit",);
          tr =  e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title, description);
          titleedit.value = title;
          descriptionedit.value = description;
          snoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle')
        })
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("delete");
          sno = e.target.id.substr(1,);
          tr =  e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;

          if(confirm("Are you sure to delete this Note!")){
            console.log("Yes");
            window.location = `/sudphp/CRUD_index.php?delete=${sno}`;
            // To Do things for security: Create a form and use post request to submit the form 

          }
          else{
            console.log("No");
          }
        })
      })
    </script>
  </body>
</html>