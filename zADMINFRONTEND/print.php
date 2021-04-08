<?php
    session_start();

    $date_issued = " ";
    $student_semester = 0;
    $student_name = " ";
    $student_id = $_SESSION['verify_student_id'];
    $student_section = " ";
    $student_year = 0;
    $student_course = " ";
    $adviser_name = $_SESSION['username'];
    $school_year = "2020-2021";
    $student_gpa = 0;

    $ics_director="RODERICK P. GO";
    $ggc_coordinator = "LUCY FELIX-SADIWA";
    $institute_secretary = "GADMAR M. BELAMIDE";
    $student_affair_coordinator = "MARJORIE A. ROJAS";
    $information_technology_department_head = "JOHN AUGUSTUS A. ESCORIAL";
    $computer_science_department_head = "ODON A. MARAVILLAS";
    
    $subject1 = " ";
    $subject_unit1 = " ";
    $subject_grade1 = " ";

    //CURL FETCH GRADES START
        $ch = curl_init(); 
        $url = "http://icsdloa.online/API/Fetch/fetchGrades.php";
        
        $post_data = array (
        "student_id"=> $student_id
        );

        $header = [
        'Content-Type: Text/plain'
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $output = curl_exec($ch);
        $decoded_grades = json_decode($output);

        curl_close($ch);                
    //CURL FETCH GRADES END

    //CURL FETCH APPFORM START
        $ch = curl_init();
        $url = "http://icsdloa.online/API/Fetch/fetchSpecificAppform.php";
        
        $post_data = array (
        "student_id"=> $student_id
        );

        $header = [
        'Content-Type: Text/plain'
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $output = curl_exec($ch);
        $decoded_appform = json_decode($output);

        foreach ($decoded_appform as $obj) {
            $student_name = $obj->lastname .", ". $obj->firstname .", ". $obj->middlename;
            $student_course = $obj->course;
            $student_section = $obj->section;
            $student_year = $obj->year;
            $student_gpa = $obj->gpa;

            if ($obj->semester == 1) {
                $student_semester = $obj->semester ."st";
            }
            else {
                $student_semester = $obj->semester ."nd";
            }
            $date_issued = $obj->date;
        }
        curl_close($ch);
    //CURL FETCH APPFORM END  

    $html = "
        <div class='container'> 
            <div class='top1'>
                <img src='assets/wmsulogo.png' alt='wmsulogo'>
            </div>

            <div class='top2'>
                <span>Republic of the philippines</span><br/>
                <span>Western Mindanao State University</span><br/>
                <span class='institute'>INSTITUTE OF COMPUTER STUDIES</span><br/>
                <span>Zamboanga City</span>
            </div>

            <div class='top1'>
                <img src='assets/icslogo.png' alt='icslogo'>
            </div>
        </div>

        <div class ='container2'>
            <br/>
            <br/>
            <br/>
            <span>FOR: </span> 
            <span class='institute'>{$ics_director}</span> <br/>
            <span class='director'>&emsp;&emsp;&emsp;Director, ICS</span>
        </div>

        <div class ='container2'>
            <span class='director'>&emsp;&emsp;&emsp;I have the honor to apply for the inclusion in the Director's List for the {$student_semester} semester, 
            school year {$school_year}, Based on my academic ratings for the given period, to wit:</span>

                <div class='table-container'>
                    <table>
                        <th>
                            <tr>
                                <td>Subject name</td>
                                <td>units</td>
                                <td>Grade</td>
                            </tr>
                        </th>";


                foreach ($decoded_grades as $obj) {
                    $html .= "
                        <tb>
                            <tr>
                                <td>{$obj->subject_name}</td>
                                <td>{$obj->subject_unit}</td>
                                <td>{$obj->grade}</td>
                            </tr>
                        </tb>
                    ";
                }
                

                $html .="<tb>
                            <tr>
                                <td style='font-size: 10px; font-weight: bold;'>Total units and GPA:</td>
                                <td>6</td>
                                <td>{$gpa}</td>
                            </tr>
                        </tb>
                    </table>
                <div>

                <div class='container3'>

                    <div class='container4'>
                        <br/>
                        <br/>
                        <span><u>{$adviser_name}</u></span> 
                        <br/>
                        <span><strong>Adviser</strong></span>
                    </div>

                    <div class='container5'>
                        <span><strong>Student name:</strong> {$student_name}</span><br/>
                        <span><strong>Student id:</strong> {$student_id}</span><br/>
                        <span><strong>Section:</strong> {$student_section}</span><br/>
                        <span><strong>Year:</strong> {$student_year}</span><br/>
                        <span><strong>Course:</strong> {$student_course}</span><br/>
                    </div>
                </div>

                <hr>

                <br/>
                    <span><strong>{$ics_director}</strong></span> <br/>
                    <span>Director, ICS</span> <br>
                <br/>

                <div>
                    <span>Sir<span><br/>
                    
                    <span>
                        &emsp;&emsp;&emsp;Upon verification by the committee, Mr./Mrs. <u>{$student_name}</u> has been found to possess the
                        qualifications, and none of the disqualifications, for the inclusion in the Institute's Dirctor's List for the perdiod indicated.
                    </span>
                    <br/>
                    <br/>
                    <span>
                        &emsp;&emsp;&emsp;Therefore, we hereby recommend for approval of his/her application as a Director's Lister.
                    </span>
                </div>

                <br/>
                <br/>

                <div class='container-committee'>
                    <div class='committee-left'>
                        <span><strong>{$ggc_coordinator}</strong></span><br/>
                        <span>Member / Gender and Guidance & Counseling Coordinator</span><br/>
                        <br/>
                        <span><strong>{$student_affair_coordinator}</strong></span><br/>
                        <span>Member / Student Affair Coordinator</span><br/>
                    </div>

                    <div class='committee-right'>
                        <span><strong>{$institute_secretary}</strong></span><br/>
                        <span>Member / Institute Secretary</span><br/>
                        <br/>
                        <span><strong>{$information_technology_department_head}</strong></span><br/>
                        <span>Member / Information Technology Department Head</span><br/>
                    </div>

                    <div class='committee-center'>
                        <span><strong>{$computer_science_department_head}</strong></span><br/>
                        <span>Member / Computer Science Department Head</span><br/>
                    </div>
                <div>

                <hr>

                <div class='footer'>
                    <div>
                        <span><strong>Date: </strong><u>{$date_issued}<u></span>
                    </div>
                    <br/>
                    <span>
                        &emsp;&emsp;&emsp;Upon the recommendation of the Committee, Mr./Ms.<u>{$student_name}</u> is hereby admitted for the inclusion in the Director's List
                        for the academic period herein stated.  
                    </span> <br/>
                    <br/>
                    <div class='footer-admin'>
                        <span><strong>{$ics_director}</strong></span><br/>
                        <span>Director</span>
                    </div>
                </div>
        </div>
    ";
    include('mpdf/vendor/autoload.php');
    $mpdf = new \Mpdf\Mpdf();
    $stylesheet = file_get_contents('assets/style.css');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($html,2);
    $mpdf->output();
?>
