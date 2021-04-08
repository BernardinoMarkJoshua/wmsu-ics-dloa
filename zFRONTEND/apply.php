<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICS-DLOA | Apply</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<!-- request to generate appform -->
<?php
    $decoded = 'TOGGLE';
    $msg = 1;
    session_start();
    if(!empty($_POST['generate'])) {
        $student_id = $_POST['student_id'];
        $section_select = $_POST['section_select'];
        $year_select = $_POST['year_select'];
        $semester_select = $_POST['semester_select'];

        $_SESSION['section'] = $section_select;
        $_SESSION['year'] = $year_select;
        $_SESSION['semester'] = $semester_select;

        $ch = curl_init();

        $url = "http://icsdloa.online/API/Application/generateAppform.php"."?student_id=".$student_id ."&year=".$year_select."&semester=".$semester_select;
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $resp = curl_exec($ch);
        
        if($e = curl_error($ch)) {
            
            echo $e;
        
        } else {
            
            $decoded = json_decode($resp);    
            $msg = $decoded;
        }

    }
?>

<!-- request to send grades -->
<?php
    $sum = 0;
    $sumofunits = 0;
    
    if(!empty($_POST['apply'])) {
        for ($x = 1; $x <= $_POST['counter'] ; $x++) {
        $student_id = $_POST['student_id'.$x];
        $subject_code = $_POST['student_code'.$x];
        $subject_unit = $_POST['subject_unit'.$x];
        $grade = $_POST['grade'.$x];
        $student_section = $_POST['section'];
        $product = $_POST['subject_unit'.$x] * $grade;
        $sumofunits = $sumofunits + $_POST['subject_unit'.$x];  
        $sum = $sum + $product; 
        $year = $_SESSION['year'];
        $semester = $_SESSION['semester'];
        
            $ch = curl_init();

            $url = "http://icsdloa.online/API/Application/sendGrade.php";
            
            $post_data = array (
            "student_id"=> $student_id,
            "subject_code"=> $subject_code, 
            "grade"=> $grade,
            "year"=> $year,
            "semester"=> $semester,
            "subject_unit"=> $subject_unit
            );
        
            $header = [
            'Content-Type: Text/plain'
            ];
        
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $output = curl_exec($ch);
        
            if ($output === false) {
                echo "cURL Error: " . curl_error($ch);
            }
            curl_close($ch);
        }

        // request to send application form
        $gpa = $sum/$sumofunits;

        $ch1 = curl_init();

        $url1 = "http://icsdloa.online/API/Application/sendAppform.php";
        
        $post_data1 = array (
            "student_id"=> $student_id,
            "section"=> $student_section,
            "year"=> $year,
            "semester"=> $semester,
            "gpa"=> $gpa
            );
        
            $header1 = [
            'Content-Type: Text/plain'
            ];
        
            curl_setopt($ch1, CURLOPT_URL, $url1);
            curl_setopt($ch1, CURLOPT_POST, 1);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($post_data1));
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $header1);
            $output = curl_exec($ch1);
        
            if ($output === false) {
                echo "cURL Error: " . curl_error($ch1);
            } 
            else if ($output === true) {
                $msg = 'Successfully apllied to ICS-DLOA';
            }
            curl_close($ch1);
            session_destroy();
        }
    $counter = 0;
?>


    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-2">
        <a href="../index.php" class="navbar-brand">ICS-DLOA</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link text-light">Home</a>
                </li>
            </ul>
    </nav>

    <div class="container" <?php if ($msg == 'msg 1') {echo 'style= "display:block; width: 40rem;"';} else {echo 'style= "display: none;"';}?>>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Slow down!</strong> you have already applied please wait for approval.
        </div>
    </div>

    <div class="container" <?php if ($msg == 'msg 2') {echo 'style= "display:block; width: 40rem;"';} else {echo 'style= "display: none;"';}?>>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Oops!</strong> This id is not yet registered.
        </div>
    </div>

    <div class="container" <?php if ($msg == 'Successfully apllied to ICS-DLOA') {echo 'style= "display:block; width: 40rem;"';} else {echo 'style= "display: none;"';}?>>
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?php echo $msg;?></strong>
        </div>
    </div>

    <div class="container d-flex justify-content-center mt-4">
        <div class="card mb-5">
            <div class="card-body" <?php if (is_string($decoded)) {echo 'style= "display: none;"';} else {echo 'style= "display:block; width: 50rem;"';}?>>
                <h2>Apply</h2>
                <p>Last step! please enter your grades.</p>
                    <div class="container">
                        <form action="apply.php" method="POST">
                        <table class="table table-striped table-sm">
                            <thead>
                            <tr class="bg-success text-white">
                                <th scope="col" class="font-weight-normal">Subject code</th>
                                <th scope="col" class="font-weight-normal">Subject name</th>
                                <th scope="col" class="font-weight-normal">units</th>
                                <th scope="col" class="font-weight-normal">grade</th>
                            </tr>
                            </thead>
                            <tbody>
    
                                <?php foreach ($decoded as $obj): ?>
                                    <tr>
                                        <th scope="row"><?php echo $obj->subject_code?></th>
                                        <td><?php echo $obj->subject_name?></td>
                                        <td><?php echo $obj->subject_units?></td>
                                        <input type="hidden" name="section" id="section" value="<?php echo $section_select?>">
                                        <input type="hidden" name="counter" id="counter" value="<?php echo $counter+=1?>">
                                        <input type="hidden" name="subject_unit<?php echo $counter?>" id="subject_unit<?php echo $counter?>" value="<?php echo $obj->subject_units?>">
                                        <input type="hidden" name="student_id<?php echo $counter?>" id="student_id<?php echo $counter?>" value="<?php echo $student_id?>">
                                        <input type="hidden" name="student_code<?php echo $counter?>" id="student_code<?php echo $counter?>" value="<?php echo $obj->subject_code?>">
                                        <td><input type="text" id="grade<?php echo $counter?>" name="grade<?php echo $counter?>"class="form-control" required></td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                        <input type="submit" value="Apply" id="apply" name="apply" class="btn btn-success mb-2 mt-3">
                        </form>

                    </div>
                </form>
            
            </div>
          </div>
    </div>

    <div class="container d-flex justify-content-center">
        <div class="card mb-5" <?php if (is_string($decoded)) {echo 'style= "display:block; width: 40rem;"';} else {echo 'style= "display: none;"';}?>>
            <div class="card-body">
              <h2>Apply</h2>
              <p>Fill this up to apply for Dean's list.</p>

              <div class="container">
                  <form action="apply.php" method="POST">

                    <label for="student_id" class="mt-3">Student id</label>
                    <input type="number" class="form-control" id="student_id" name="student_id" placeholder="e.g 2016000406" required>


                    <label for="year" class="mt-3">Year</label>
                    <select class="form-control" id="year_select" name="year_select" required>
                        <option disabled selected value>select year</option>
                        <option value="1">1st</option>
                        <option value="2">2nd</option>
                        <option value="3">3rd</option>
                        <option value="4">4th</option>
                    </select>



                    <input type="hidden" id="semester_select" name="semester_select" value="1">
                     


                    <label for="section" class="mt-3">Section</label>
                    <select class="form-control" id="section_select" name="section_select" required>
                        <option disabled selected value>select section</option> 
                        <option>A</option>
                        <option>B</option>
                    </select>
                    
                    <input type="submit" value="Generate" name="generate" id="generate" class="btn btn-success mb-2 mt-3" >
                  </form>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="mt-3"><small>WMSU ICS student and don't have an account?</small></p>
                    <a href="register.php" class="ml-2">Register</a>
                  </div>
              </div>

            </div>
          </div>
    </div>
    
</body>
</html>