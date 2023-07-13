<?php
$studentId = $_POST['id'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$conn = mysqli_connect("localhost","root","","test") or die("Connection Failed");

    $sql = "UPDATE `students` SET `first_name`='{$firstName}',`last_name`='{$lastName}' WHERE id= {$studentId}";

    if(mysqli_query($conn,$sql)){
        echo 1;
    }else{
        echo 0;
    }
?>