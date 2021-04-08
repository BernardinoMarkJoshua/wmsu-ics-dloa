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

    $faculty->faculty_id = $data->faculty_id;

    if ($faculty->readAdviserInfo()) {
        
        $result = $faculty->readAdviserInfo();

        $rowcount = $result->rowCount();

        $faculty_arr = array();

        if ($rowcount > 0) {

            while($row = $result->fetch(PDO::FETCH_ASSOC)) {

                extract($row);

                $faculty_item = array(  
                    'adviser_course' => $adviser_course,
                    'adviser_year' => $adviser_year,
                    'adviser_section' => $adviser_section,
                    'adviser_semester' => $adviser_semester
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