<?php
include ('DatabaseConnection.php');
require_once ('Student.php'); 
$db = new DatabaseConnection("localhost", "root", "", "db_name");
$connection = $db->getConnection();
$student = new Student($connection);

$students = $student->getAllStudents();

if(isset($_GET['id']) and isset($_GET['to_delete'])){
    $std_id = $_GET['id'];
    $student->setId($std_id);
    $student->delete();
}
elseif (isset($_GET['id'])) {
    $updateId = $_GET['id'];
    $student->setId($updateId);
    $isFoundStudent = $student->read();
    if ($isFoundStudent) {
        $updateMode = true;  // Flag to indicate update mode
    } else {
        die("Failed to retrieve student data!");
    }
} else {
    $updateMode = false; // Default to create mode
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty of Technology - Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5 ">
    <h1 class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3">Demo Application - PHP (OOP) + MySQL</h1>
    <form action="<?php echo $updateMode ? "index.php?id=" . $student->getId() : "index.php" ?>" method="post">
        <?php if ($updateMode): ?>
            <input type="hidden" name="id" value="<?php echo $student->getId(); ?>">
        <?php endif; ?>
        <label class="form-label" for="name">Name:</label><br>
        <input class="form-control col-4" type="text" id="name" name="name" value="<?php echo $updateMode ? $student->getName() : ""; ?>"
            placeholder="John"><br>
        <label class="form-label" for="gpa">GPA:</label><br>
        <input class="form-control col-4" type="number" step="any" id="gpa" name="gpa" value="<?php echo $updateMode ? $student->getGpa() : ""; ?>"
            placeholder="3.2"><br><br>
        <input class="btn btn-primary col-4 text-center" type="submit" name="<?php echo $updateMode ? "update_student" : "add_student" ?>"
            value="<?php echo $updateMode ? "Update" : "Add" ?>">
    </form>
    <?php
    if (isset($_GET['error'])) {
        echo "<h3 class='text-danger m-5'>" . $_GET['error'] . "</h3>";
    }
    ?>
    
    <?php
    if (isset($_GET['success'])) {
        echo "<h3 class='text-success m-5'>" . $_GET['success'] . "</h3>";
    }
    ?>
    <?php
    if (isset($_POST['add_student'])) {
        $name = $_POST['name'];
        $gpa = $_POST['gpa'];
        $student->setGpa($gpa);
        $student->setName($name);
        $student->create();
    }


    if (isset($_POST['update_student'])) {
        $student_id = $_GET['id'];
        $name = $_POST['name'];
        $gpa = $_POST['gpa'];
        $student->setGpa($gpa);
        $student->setName($name);
        $student->setId($student_id);
        $student->update();
    }
    ?>
    <table class="table table-hover">
        <tr class="text-left">
            <th>ID</th>
            <th>Name</th>
            <th>GPA</th>
            <th>Action</th>
        </tr>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?php echo $student['id']; ?></td>
                <td><?php echo $student['name']; ?></td>
                <td><?php echo $student['gpa']; ?></td>
                <td><a class="btn btn-success" a href="index.php?id=<?php echo $student['id'] ?>">Update</a>
                <a class="btn btn-danger" href="index.php?id=<?php echo $student['id'] ?>&to_delete=1">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>