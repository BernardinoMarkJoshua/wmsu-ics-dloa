<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

    include_once '../../CONFIG/Database.php';
    include_once '../../MODEL/Student.php';

    $database = new Database();
    $db = $database->connect();

    $student = new Student($db);

    $data = json_decode(file_get_contents("php://Input"));

    $student->student_id = $data->student_id;
    $student->firstname = $data->firstname;
    $student->middlename = $data->middlename;
    $student->lastname = $data->lastname;
    $student->email = $data->email;
    $student->contact_number = $data->contact_number;
    $student->course = $data->course;

    if ($student->RegisterStudent()) {

        echo   '<div class="alert alert-dismissible alert-success" style="width: 50rem">';
        echo        '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        echo        '<strong>Well done!</strong>successfuly registered! you can now apply for Dean\'s list!.';
        echo    '</div>';

    }
?>