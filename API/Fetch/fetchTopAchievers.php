<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../CONFIG/Database.php';
    include_once '../../MODEL/Achiever.php';


    $database = new Database();
    $db = $database->connect();

    $achiever = new Achiever($db);

    $result = $achiever->viewTopAchievers();

    $rowcount = $result->rowCount();

    if( $rowcount > 0) {

        $achiever_arr = array();
        //$achiever_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            $achiever_item = array(

                'student_ID' => $student_id,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'course' => $course,
                'section' => $section,
                'gpa' => $gpa 

            );

            array_push($achiever_arr, $achiever_item);

        }

        echo json_encode($achiever_arr);

    } else {

        echo json_encode(
            array('message' => 'no achievers found')
        );

    }
?>