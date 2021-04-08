<?php
    session_start();

    if($_SESSION['status'] == 'invalid' || empty($_SESSION['status'])) {
        echo "<script>window.location.href='login.php'</script>";
    } else if ($_SESSION['role'] == 'admin') {
        echo "<script>window.location.href='admin_landing.php'</script>";
    }
    
    $ch = curl_init();

    $url = "http://icsdloa.online/API/Fetch/fetchStudents.php";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $resp = curl_exec($ch);

    if ($e = curl_error($ch)) {
        echo $e;
    }
    else {
        $decoded = json_decode($resp);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a href="#" class="navbar-brand">ICS-DLOA Faculty</a>
        
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="adviser_landing.php" class="nav-link text-light">Home</a>
            </li>
        </ul>
    </nav>
    
    <div class="container mt-5">
        <h1>Student</h1>
            <div class="table-responsive-sm">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr class="bg-success text-white">
                        <th scope="col" class="font-weight-normal">Student ID</th>
                        <th scope="col" class="font-weight-normal">First name</th>
                        <th scope="col" class="font-weight-normal">Middle name</th>
                        <th scope="col" class="font-weight-normal">Last name</th>
                        <th scope="col" class="font-weight-normal">Email</th>
                        <th scope="col" class="font-weight-normal">Contact number</th>
                    </tr>
                    </thead>
                    <tbody>
    
                    <?php foreach ($decoded as $obj): ?>
                    <tr>
                        <th scope="row"><?php echo $obj->student_id;?></th>
                        <td><?php echo $obj->firstname;?></td>
                        <td><?php echo $obj->middlename;?></td>
                        <td><?php echo $obj->lastname;?></td>
                        <td><?php echo $obj->email?></td>
                        <td><?php echo $obj->contact_number?></td>
                    </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
    </div>

</body>
</html>