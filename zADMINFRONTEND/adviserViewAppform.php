<?php
    session_start();

    if($_SESSION['status'] == 'invalid' || empty($_SESSION['status'])) {
        echo "<script>window.location.href='login.php'</script>";
    } else if ($_SESSION['role'] == 'admin') {
        echo "<script>window.location.href='admin_landing.php'</script>";
    }

    $student_id = $_SESSION['verify_student_id'];

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
    $decoded = json_decode($output);
    curl_close($ch);

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
    $decoded2 = json_decode($output);

    curl_close($ch);
 
    if (isset($_POST['decline'])) {

        $ch = curl_init();
    
        $url = "http://icsdloa.online/API/Faculty/declineAppform.php";
        
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
        else {
            curl_close($ch);
            echo '<script>window.location.href="adviserVerify.php"</script>';
        }
    }
    else if (isset($_POST['print'])) {
        $ch = curl_init();
    
        $url = "http://icsdloa.online/API/Faculty/acceptAppform.php";
        
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
        else {
            curl_close($ch);
            echo '<script>window.location.href="print.php"</script>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appform</title>
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
                <a href="adviser_landing.php" class="nav-link">Home</a>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">

        <h1>Appform view</h1>  

        <?php
            if(isset($decoded2)) {
                foreach($decoded2 as $obj){
                    echo 'Name: '.$obj->firstname . ", " .$obj->middlename.  ", "  .$obj->lastname;
                    echo ' Section: '.$obj->section;
                    echo ' Course: '.$obj->course;
                    echo ' Year: '.$obj->year;
                }
            }
        ?>

        <div class="table-responsive-sm">
            <table class="table table-striped table-sm">
                <thead>
                    <tr class="bg-success text-white">
                        <th scope="col" class="font-weight-normal">subject code</th>
                        <th scope="col" class="font-weight-normal">subject name</th>
                        <th scope="col" class="font-weight-normal">grade</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($decoded as $obj): ?>
                        <tr>
                            <th scope="row"><?php echo $obj->subject_code;?></th>
                            <td><?php echo $obj->subject_name;?></td>
                            <td><?php echo $obj->grade;?></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <form action="adviserViewAppform.php" method="POST" class="float-right">
            <input type="submit" value="Print" name="print" class="btn btn-success">
            <input type="submit" value="Decline" name="decline" class="btn btn-danger">
           
        </form>

    </div>

</body>
</html>