<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

    include_once '../../CONFIG/Database.php';
    include_once '../../MODEL/Apply.php';

    $database = new Database();
    $db = $database->connect();

    $apply = new Apply($db);

    $apply->student_id = isset($_GET['student_id']) ? $_GET['student_id'] : die();
    $apply->course = isset($_GET['course']) ? $_GET['course'] : die();
    $apply->year = isset($_GET['year']) ? $_GET['year'] : die();
    $apply->semester = isset($_GET['semester']) ? $_GET['semester'] : die();

    $result = $apply->checkStudent();

    $rowcount = $result->rowCount(); 

    if ($rowcount > 0){

        $result2 = $apply->checkYearandSemester();

        $rowcount2 = $result2->rowCount();
        
        $subj_arr = array();
        if ($rowcount2 > 0) {

            while($row = $result2->fetch(PDO::FETCH_ASSOC)) {

                extract($row);

                $subj_item = array(
                    'subject_code' => $subject_code,
                    'subject_name' => $subject_name,
                    'subject_units' => $subject_units
                );


                array_push($subj_arr, $subj_item);
            }
        }
        echo json_encode($subj_arr);
    } else {
        echo json_encode('invalid id input');
    }

?>