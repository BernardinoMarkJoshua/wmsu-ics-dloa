<?php
    $msg = "";
    if(isset($_POST['register'])) {
        $email = $_POST['email_inp'];
        $name = $_POST['name_inp'];
        $faculty_id = $_POST['faculty_id_inp'];
        $password = $_POST['password_inp'];
        $cpassword = $_POST['cpassword_inp'];
        $contact = $_POST['contact_inp']; 
        $role = $_POST['role_select'];

        if($password != $cpassword)
            $msg = "Your passwords don't match";
        else {
            $msg = "Faculty member succcessfully registered";
            $hash = password_hash($password, PASSWORD_BCRYPT);

            $ch = curl_init();
            $url = "http://localhost/webacts/Cybersolution_Ver2/API/Registration/facultyRegistration.php";

            $post_data = array(
                "faculty_id" => $faculty_id,
                "email" => $email,
                "name" => $name,
                "contact_number" => $contact,
                "role" => $role,
                "password" => $hash
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
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create members</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    
    <div class="container d-flex justify-content-center mt-5">
        <div class="card mb-5" style="width: 35rem;">
            <div class="card-body">
                <h1>Register</h1>
                <?php if ($msg != "") echo $msg?>
                <form action="registerUsers.php" method="POST">

                    <label for="email_inp" class="mt-3">email</label>
                    <input type="text" class="form-control" id="email_inp" name="email_inp" placeholder="e.g example@exp.com" required>
                    
                    <label for="name_inp" class="mt-3">name</label>
                    <input type="text" class="form-control" id="name_inp" name="name_inp" placeholder="e.g Ronald Arcilla" required>
                    
                    <label for="faculty_id_inp" class="mt-3">faculty id</label>
                    <input type="text" class="form-control" id="faculty_id_inp" name="faculty_id_inp" placeholder="e.g icsuser112233" required>

                    <label for="contact_inp" class="mt-3">contact number</label>
                    <input type="text" class="form-control" id="contact_inp" name="contact_inp" placeholder="e.g example@exp.com" required>
                    
                    <label for="password_inp" class="mt-3">password</label>
                    <input type="password" class="form-control" id="password_inp" name="password_inp" placeholder="password" required>
                    
                    <label for="cpassword_inp" class="mt-3">confirm password</label>
                    <input type="password" class="form-control" id="cpassword_inp" name="cpassword_inp" placeholder="confirm password" required>

                    <label for="role_select" class="mt-3">role</label>
                    <select class="form-control" id="role_select" name="role_select" required>
                        <option>ADVISER</option>
                        <option>ADMIN</option>
                    </select>

                    <input type="submit" value="Register" name="register" id="register" class="btn btn-success mb-2 mt-3">
                
                </form>
            </div> 
        </div>
    </div>

</body>
</html>