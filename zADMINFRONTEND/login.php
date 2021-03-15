<?php

    session_start();


    // sets the default session variables to empty string and session status to invalid
    if ($_SESSION['status'] == 'invalid' || empty($_SESSION['status'])) {
        $_SESSION['status'] = 'invalid';
        $msg = "";
    } 

    else if ($_SESSION['role'] == 'ADVISER') {
        echo "<script>window.location.href='adviser_landing.php'</script>";
    }

    else if ($_SESSION['role'] == 'ADMIN') {
        echo "<script>window.location.href='admin_landing.php'</script>";
    }


    // fires the command needed to login user
    if (isset($_POST['login'])) {
        $faculty_id = $_POST['faculty_id_inp'];
        $password = $_POST['password_inp'];

        $ch = curl_init();
    
        $url = "http://localhost/webacts/Cybersolution_Ver2/API/Faculty/login.php";
        
        $post_data = array (
        "faculty_id"=> $faculty_id
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
        $decoded = json_decode($output);
        
        if ($output === false) {
            $_SESSION['status'] = 'invalid';
            $msg = "cURL Error: " . curl_error($ch);
        }
        else if ($decoded === null) {
            $_SESSION['status'] = 'invalid';
            $msg = "username may be incorrect please try again.";
        }
        else if (password_verify($password, $decoded[0]->password)) {
            $_SESSION['status'] = 'valid';

            foreach ($decoded as $obj) {
                $_SESSION['faculty_id'] = $obj->faculty_id;
                $_SESSION['username'] = $obj->name;
                $_SESSION['role'] = $obj->role;
            } 

            if ($_SESSION['role'] == 'ADVISER') {
                echo "<script>window.location.href='adviser_landing.php'</script>";
            }

            else if ($_SESSION['role'] == 'ADMIN') {
                echo "<script>window.location.href='admin_landing.php'</script>";
            }

            curl_close($ch);
        }
        else {
            $msg ="password is incorrect";
        } 
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICS Faculty</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">
        

        <div class="container d-flex justify-content-center mt-4">
            <div class="card mb-5">
                <div class="card-body" style="width: 35rem;">
                    <h1>Login</h1>
                    <form action="login.php" method="POST">
                        <label for="faculty_id_inp" class="mt-3">faculty id</label>
                        <input type="text" class="form-control" id="faculty_id_inp" name="faculty_id_inp" required>
                        <label for="password_inp" class="mt-3">Password</label>
                        <input type="password" class="form-control" id="password_inp" name="password_inp" required>
                        <input type="submit" value="login" name="login" id="login" class="btn btn-success mb-2 mt-3">
                    </form>
                    <?php echo $msg;?>
                </div> 
            </div>
        </div>

    </div>

</body>
</html>