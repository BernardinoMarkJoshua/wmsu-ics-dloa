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

    $faculty->course = $data->course;
    $faculty->year = $data->year;
    $faculty->semester = $data->semester;
    $faculty->section = $data->section;

    if ($faculty->viewAppform()) {
        
        $result = $faculty->viewAppform();

        $rowcount = $result->rowCount();

        $faculty_arr = array();

        if ($rowcount > 0) {

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {

                extract($row);

                $faculty_item = array(
                    'student_id' => $student_id,
                    'firstname' => $firstname,
                    'middlename' => $middlename,
                    'lastname' => $lastname,
                    'section' => $section,
                    'course' => $course,
                    'year' => $year,
                    'semester' => $semester,
                    'date' => $date,
                    'gpa' => $gpa
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