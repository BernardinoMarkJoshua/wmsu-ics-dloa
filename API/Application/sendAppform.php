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
    $apply->semester = $data->semester;
    $apply->gpa = $data->gpa;

    $result = $apply->checkStudent();
    //$courseResult = $apply->getStudentCourse();
    //$courseResult = $courseResult->fetch(PDO::FETCH_ASSOC);
    //$apply->course = $courseResult['course'];
    
    $rowcount = $result->rowCount();

    if ($rowcount > 0) {
        if ($apply->sendAppform()) {
            json_encode('Successfully registered to ICS-DLOA');
        }
    } else {
        echo 'no id exist';
    }
?>