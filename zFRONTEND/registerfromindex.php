<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICS-DLOA | Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a href="../index.php" class="navbar-brand">ICS-DLOA</a>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="../index.php" class="nav-link text-light">Back</a>
            </li>
        </ul>

    </nav>

    <div class="d-flex justify-content-center mt-1">
        <?php
            if(isset($_POST['submit']) == 'POST') {
                $student_id = $_POST['student_id'];
                $firstname = $_POST['firstname'];
                $middlename = $_POST['middlename'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $contact_num = $_POST['contact_num'];
                $course_sel = $_POST['course_select'];

                $ch = curl_init();
        
                $url = "http://icsdloa.online/API/Registration/studentRegistration.php";
                
                $post_data = array (
                "student_id"=> $student_id,
                "firstname"=> $firstname,
                "middlename"=> $middlename,
                "lastname"=> $lastname,
                "email"=> $email,
                "contact_number"=> $contact_num,
                "course"=> $course_sel
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
        ?>
    </div>

    <div class="container d-flex justify-content-center mt-5">
        <div class="card mb-5" style="width: 40rem">
            <div class="card-body">
              <h2>Register</h2>
              <p>For verification and record purposes we require you to register.</p>

              <div class="container">
                  <form action="register.php" method="POST">

                    <label for="student_id">student id</label>
                    <input type="number" class="form-control" id="student_id" name="student_id"  placeholder="e.g 2016000406" required>


                    <label for="firstname" class="mt-2">First name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="e.g John" required>

                    <label for="middlename" class="mt-2">Middle name</label>
                    <input type="text" class="form-control" id="middlename" name="middlename" placeholder="e.g Martinez" required>

                    <label for="lastname" class="mt-2">Last name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="e.g Doe" required>

                    <label for="contact_num" class="mt-2">Contact number</label>
                    <input type="number" class="form-control" id="contact_num" name="contact_num" placeholder="e.g 09999999999" required>

                    <label for="email" class="mt-2">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="e.g example@exmp.com" required>

                    <label for="course_select" class="mt-2">Course</label>
                    <select class="form-control" id="course_select" name="course_select" required>
                        <option disabled selected value>select course</option>
                        <option>BSCS</option>
                        <option>BSIT</option>
                    </select>
                    
                    <input type="submit" value="submit" name="submit" class="btn btn-success mb-2 mt-3">
                  </form>
              </div>
              
            </div>
          </div>
    </div>
</body>
</html>