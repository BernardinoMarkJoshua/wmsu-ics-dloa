<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../CONFIG/Database.php';
include_once '../../MODEL/Faculty.php';


$database = new Database();
$db = $database->connect();

$faculty = new Faculty($db);

$result = $faculty->viewStudent();

$rowcount = $result->rowCount();

if( $rowcount > 0) {

    $faculty_arr = array();
    //$faculty_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $faculty_item = array(

            'student_id' => $student_id,
            'firstname' => $firstname,
            'middlename' => $middlename,
            'lastname' => $lastname,
            'contact_number' => $contact_number,
            'email' => $email,
            'course' => $course

        );

        array_push($faculty_arr, $faculty_item);

    }

    echo json_encode($faculty_arr);

} else {

    echo json_encode(
        array('message' => 'no students found')
    );

}

?>