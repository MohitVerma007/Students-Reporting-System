<?php


$conn = mysqli_connect("localhost", "root", "", "records");
if (!$conn) {
    echo "Disconnect";
}
$status = '';

if (isset($_POST['get_result'])) {
    $stu = mysqli_real_escape_string($conn, $_POST['student_name']);
    $eng1 = $_POST['eng1_mark'];
    $mth1 = $_POST['math1_mark'];
    $sci1 = $_POST['science1_mark'];
    $eng2 = $_POST['eng2_mark'];
    $mth2 = $_POST['math2_mark'];
    $sci2 = $_POST['science2_mark'];
 
    $english = ($eng1+$eng2)/2;
    $math = ($mth1+$mth2)/2;
    $science = ($sci1+$sci2)/2;
    $sem1= ($eng1+$mth1+$sci1)/3;
     $sem2 = ($eng2+$mth2+$sci2)/3;
 
    $result = mysqli_query($conn, "SELECT `id` FROM `student_result` WHERE `name` = '$stu'");
    if (mysqli_num_rows($result) > 0) {
        $status =  '<div class="alert alert-warning" role="alert">
        This student data is already exist...
        </div>';
    } 
    else {
    $query = "INSERT INTO `student_result`(`name`, `eng1`, `math1`, `sci1`, `sem1`, `sem2`) 
                    VALUES('$stu','$english','$math','$science','$sem1','$sem2')";
    $run_query = mysqli_query($conn, $query);
    if ($run_query == true) {
        $status =  '<div class="alert alert-info" role="alert">
                        Successfully Inserted data ...
                </div>';
    } else {
        $status =  '<div class="alert alert-danger" role="alert">
                    Something Went Wrong!
            </div>';
    }
}

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Record Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Record Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="message">
        <?php if ($status) {
            echo $status;
        } ?>
    </div>

    <div class="container m-5 ">
        <h2>Student Record Management</h1>
            <hr>
            <form id="libraryForm" method="POST" action="index.php">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 ">
                        <div class="mb-3">
                            <label for="bookName" class="form-label ">Student Name</label>
                            <input type="text" class="form-control" name="student_name" id="bookName">

                        </div>
                    </div>

                    <!--  -->
                    <!-- Semester 1 -->
                    <h4 class="text-center my-3">Semester-I Marks</h4>
                    <div class="col-sm-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="eng1" name="eng1_mark" placeholder="Marks">
                            <label for="floatingInput">English</label>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="math1" name="math1_mark" placeholder="Marks">
                            <label for="floatingInput">Maths</label>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="science1" name="science1_mark" placeholder="Marks">
                            <label for="floatingInput">Science</label>
                        </div>

                    </div>
                    <!-- semester 2  -->
                    <h4 class="text-center my-3">Semester-II Marks</h4>
                    <div class="col-sm-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="eng2" name="eng2_mark" placeholder="Marks">
                            <label for="floatingInput">English</label>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="math2" name="math2_mark" placeholder="Marks">
                            <label for="floatingInput">Maths</label>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="science2" name="science2_mark" placeholder="Marks">
                            <label for="floatingInput">Science</label>
                        </div>

                    </div>

                </div>
                <div class="col-md-12 my-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" name="get_result">Get Result</button>
                </div>

            </form>

    </div>

    <div class="container m-5">
        <h2>Records</h1>
            <hr>
            <div id="table">

                <table class="table table-bordered">

                    <thead class="text-center">
                        <tr>
                            <th rowspan="2">Name</th>
                            <th colspan="3">Average Marks</th>
                            <th rowspan="2">Semester-I</th>
                            <th rowspan="2">Semester-II</th>
                        </tr>
                        <tr>
                            <th scope="col">English</th>
                            <th scope="col">Maths</th>
                            <th scope="col">Science</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="text-center">
                        <?php
                        $num  = 0;
                        $result = mysqli_query($conn, "SELECT * FROM `student_result` ORDER BY `sem1` DESC,`sem1` DESC");
                        if (mysqli_num_rows($result) > 0) {

                            while ($row = mysqli_fetch_array($result)) {
                                $num = $num + 1; 
                            
                        ?>
                                    <tr>
                                        <td><?= $row["name"]; ?></td>
                                        <td><?= $row["eng1"]; ?></td>
                                        <td><?= $row["math1"]; ?></td>
                                        <td><?= $row["sci1"]; ?></td>
                                        <td><?=  $row["sem1"]; ?></td>
                                        <td><?= $row["sem2"]; ?></td>

                                    </tr>

                        <?php
                            }
                        } else {
                            $status = 'No New Records';
                            if ($status) {
                                echo '<div class="alert alert-light alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
      <strong>' . $status . '</strong>   </div>';
                            }
                        }
                        ?>
                    </tbody>
                </table>

            </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

</body>

</html>