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
    $apply->subject_code = $data->subject_code;
    $apply->grade = $data->grade;

    $result = $apply->checkStudent();

    $rowcount = $result->rowCount(); 

    if ($rowcount > 0) {
        if ($apply->sendGrades ()) {
            echo json_encode(
                array(
                    'message' => 'Grade sent!'
                )
            );
        }
    } else {
        echo json_encode(
            array(
                'message' => 'grade not sent!'
            )
        );
    }

?>