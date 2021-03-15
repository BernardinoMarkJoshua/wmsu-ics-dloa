<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

    include_once '../../CONFIG/Database.php';
    include_once '../../MODEL/Apply.php';

    $database = new Database();
    $db = $database->connect();

    $apply = new Apply($db);

    $data = json_decode(file_get_contents("php://Input"));

    $apply->student_id = $data->student_id;
    $apply->section = $data->section;
    $apply->year = $data->year;
    $apply->course = $data->course;
    $apply->semester = $data->semester;
    $apply->gpa = $data->gpa;

    $result = $apply->checkStudent();

    $rowcount = $result->rowCount();

    if ($rowcount > 0) {
        if ($apply->sendAppform()) {
            echo  "<div class='alert alert-dismissible alert-success'>";
            echo    "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
            echo    "<strong>Register complete</strong> You successfully registered to ICS-DLOA! you can now apply for director's list.";
            echo  "</div>";
        }
    } else {
        echo 'no id exist';
    }
?>