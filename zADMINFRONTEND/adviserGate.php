<?php
    session_start();

    if($_SESSION['status'] == 'invalid' || empty($_SESSION['status'])) {
        echo "<script>window.location.href='login.php'</script>";
    }
    else if ($_SESSION['role'] == 'admin') {
        echo "<script>window.location.href='admin_landing.php'</script>";
    }

    $counter = 0;
    $ch = curl_init();

    $url = "http://icsdloa.online/API/Fetch/fetchGate.php";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $resp = curl_exec($ch);

    if ($e = curl_error($ch)) {
        echo $e;
    }
    else {
        $decoded = json_decode($resp);
    }

    if (isset($_POST['accept'])) {
        $student_id = $_POST['stud_id'];
        $ch = curl_init();
    
        $url = "http://icsdloa.online/API/Faculty/acceptGate.php";
        
        $post_data = array (
        "student_id"=> $student_id
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
        echo '<script>window.location.href="adviserGate.php"</script>';
    } 
    else if (isset($_POST['decline'])) {
        $student_id = $_POST['stud_id'];

        $ch = curl_init();
    
        $url = "http://icsdloa.online/API/Faculty/declineGate.php";
        
        $post_data = array (
        "student_id"=> $student_id
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
        echo '<script>window.location.href="adviserGate.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate</title>
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
    
    <div class="container mt-5 ">
        <h1>GATE</h1>   

            <form action="adviserGate.php" method="POST">
                <div class="table-responsive-sm">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr class="bg-success text-white">
                            <th scope="col" class="font-weight-normal">Student ID</th>
                            <th scope="col" class="font-weight-normal">First name</th>
                            <th scope="col" class="font-weight-normal">Middle name</th>
                            <th scope="col" class="font-weight-normal">Last name</th>
                            <th scope="col" class="font-weight-normal">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if($decoded != "no students found") { ?>
                            <?php foreach ($decoded as $obj): ?>
                            <tr>
                                <th scope="row"><?php echo $obj->student_id;?></th>
                                <td><?php echo $obj->firstname;?></td>
                                <td><?php echo $obj->middlename;?></td>
                                <td><?php echo $obj->lastname;?></td>
                                <td>
                                    <form action="adviserGate.php" method="POST">
                                    <input type="hidden" name="stud_id" value="<?php echo $obj->student_id?>"> 
                                    <input type="submit" name="accept" value="Accept" class="btn btn-success">
                                    <input type="submit" name="decline" value="Decline" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
    </div>
</body>
</html>