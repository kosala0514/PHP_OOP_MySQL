<?php
class Student
{

    private $id;
    private $name;
    private $gpa;
    private $connection;  // Reference to the database connection

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    // Setter methods for student properties 
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setGpa($gpa)
    {
        $this->gpa = $gpa;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    // Getter method for student ID 
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getGpa()
    {
        return $this->gpa;
    }

    // Create (Insert) a new student
    public function create()
    {
        if (empty($this->name) || empty($this->gpa)) {
            return header('location:index.php?error=All fields are required');
        }

        $query = "insert into `students` (`name`,`gpa`) values ('$this->name', '$this->gpa')";
        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            return header('location:index.php?error=Failed to add student'); 
        }

        return header('location:index.php?success=Successfully added student');
    }

    // Read (Retrieve) a student by ID
    public function read()
    {
        $query = "select * from `students` where `id` = '$this->id'";
        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            return false;
        }
        $row = mysqli_fetch_assoc($result);
        $this->setId($row['id']);
        $this->setName($row['name']);
        $this->setGpa($row['gpa']);
        return true; 
    }

    // Update a student's information
    public function update()
    {
        if (empty($this->id) || empty($this->name) || empty($this->gpa)) {
            return header('location:index.php?error=All Fields are required');
        }

        $query = "update `students` set `name` = '$this->name', `gpa` = '$this->gpa' where `id` = '$this->id'";
        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            return header('location:index.php?error=Failed updated student data'); // Indicate failure to update data
        }

        return header('location:index.php?success=Successfully updated student data'); // Indicate successful update
    }

    // Delete a student by ID
    public function delete()
    {
        $query = "delete from `students` where `id` = '$this->id'";
        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            return header('location:index.php?error=Failed to delete student');
        }

        return header('location:index.php?success=Successfully deleted student'); // Indicate successful deletion
    }

    // Get all students data
    public function getAllStudents()
    {
        $query = "select * from `students`";
        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            die("Failed to retrieve data");
        }

        $students = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = $row;
        }

        return $students;
    }

}
