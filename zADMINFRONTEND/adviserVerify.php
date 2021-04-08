<?php
    session_start();

    if($_SESSION['status'] == 'invalid' || empty($_SESSION['status'])) {
        echo "<script>window.location.href='login.php'</script>";
    } else if ($_SESSION['role'] == 'admin') {
        echo "<script>window.location.href='admin_landing.php'</script>";
    }

    $fact_id = $_SESSION['faculty_id'];
    
    $ch = curl_init();
    
    $url = "http://icsdloa.online/API/Faculty/getAdviserInfo.php";
    
    $post_data = array (
    "faculty_id"=> $fact_id
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

    
    foreach ($decoded as $obj) {
        $adviser_course = $obj->adviser_course;
        $adviser_year= $obj->adviser_year;
        $adviser_section = $obj->adviser_section;
        $adviser_semester = $obj->adviser_semester;
    } 

    if ($output === false) {
        $_SESSION['status'] = 'invalid';
        $msg = "cURL Error: " . curl_error($ch);
    }
    else if ($decoded === null) {
        $_SESSION['status'] = 'invalid';
        echo "something went wrong.";
    }
    else {
        curl_close($ch);
        $ch = curl_init();
    
        $url = "http://icsdloa.online/API/Fetch/fetchAppform.php";
        
        $post_data = array (
        "section"=> $adviser_section,
        "course"=> $adviser_course,
        "year"=> $adviser_year,
        "semester"=> $adviser_semester
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
        curl_close($ch);
    }

    if (isset($_POST['view'])) {
        $_SESSION['verify_student_id'] = $_POST['stud_id'];
        echo '<script>window.location.href="adviserViewAppform.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify</title>
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

    <div class="container mt-4">
    
    <h1>Verify</h1>

        <div class="table-responsive-sm mt-3">
            <table class="table table-striped table-sm">
                <thead>
                <tr class="bg-success text-white">
                    <th scope="col" class="font-weight-normal">Student ID</th>
                    <th scope="col" class="font-weight-normal">First name</th>
                    <th scope="col" class="font-weight-normal">Middle name</th>
                    <th scope="col" class="font-weight-normal">Last name</th>
                    <th scope="col" class="font-weight-normal">section</th>
                    <th scope="col" class="font-weight-normal">course</th>
                    <th scope="col" class="font-weight-normal">year</th>
                    <th scope="col" class="font-weight-normal">semester</th>
                    <th scope="col" class="font-weight-normal">date</th>
                    <th scope="col" class="font-weight-normal">gpa</th>
                    <th scope="col" class="font-weight-normal">actions</th>
                </tr>
                </thead>
                <tbody>

                <?php if(isset($decoded)) {?>
                    <?php foreach ($decoded as $obj): ?>
                    <tr>
                        <th scope="row"><?php echo $obj->student_id;?></th>
                        <td><?php echo $obj->firstname;?></td>
                        <td><?php echo $obj->middlename;?></td>
                        <td><?php echo $obj->lastname;?></td>
                        <td><?php echo $obj->section;?></td>
                        <td><?php echo $obj->course;?></td>
                        <td><?php echo $obj->year;?></td>
                        <td><?php echo $obj->semester;?></td>
                        <td><?php echo $obj->date;?></td>
                        <td><?php echo $obj->gpa;?></td>
                        <td>
                            <form action="adviserVerify.php" method="POST">
                            <input type="hidden" name="stud_id" value="<?php echo $obj->student_id?>"> 
                            <input type="submit" name="view" value="View" class="btn btn-success">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php }?>

                </tbody>
            </table>
        </div>

    </div>
    
</body>
</html>