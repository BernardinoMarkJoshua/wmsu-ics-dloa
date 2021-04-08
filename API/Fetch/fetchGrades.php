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

    if ($faculty->viewStudentGrades()) {
        
        $result = $faculty->viewStudentGrades();

        $rowcount = $result->rowCount();

        $faculty_arr = array();

        if ($rowcount > 0) {

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {

                extract($row);

                $faculty_item = array(
                    'subject_code' => $subject_code,
                    'subject_name' => $subject_name,
                    'subject_unit' => $subject_unit,
                    'grade' => $grade
                );


                array_push($faculty_arr, $faculty_item);
            }
        echo json_encode($faculty_arr);
        }
        
        else {
            echo 'error';
        }

    } else {
        echo 'error';
    }
?>