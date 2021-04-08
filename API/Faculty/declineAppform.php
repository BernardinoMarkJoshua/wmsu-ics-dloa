<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

    include_once '../../CONFIG/Database.php';
    include_once '../../MODEL/Faculty.php';

    $database = new Database();
    $db = $database->connect();

    $faculty = new Faculty($db);

    $data = json_decode(file_get_contents("php://Input"));

    $faculty->student_id = $data->student_id;

    if ($faculty->declineStudenGrade()) {
        if ($faculty->declineAppformWaiting()) {

            $result = $faculty->declineAppformWaiting();
            $rowcount = $result->rowCount();

            if ($rowcount > 0) {
                echo 'you have declined the student';
            }
            else {
                echo 'student does not exist.';
            }
        }
    } else {
        echo 'student does not exist.';
    }
?>