<?php 
    $counter = 0;
    $ch = curl_init();

    $url = "http://icsdloa.online/API/Fetch/fetchTopAchievers.php";

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
    <title>ICS-DLOA | HOME</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark ">
        <div class="container text-white d-flex justify-content-center">
           <div class="text-center">
                <h6>Western Mindanao State University</h6>
                <h5>Institute of Computer Studies</h5>
           </div>
        </div>
    </nav>

    <div class="container d-lg-flex mt-5">

        <div class="container-sm mt-5 w-75-lg w-100-sm card d-lg-flex">
            <div class="container mt-2">

                <span>
                    <strong style="font-size: 25px;">Director's List Online Application</strong>
                    is an online application system that caters ICS application for Director's List. 
                    the aim of this system is to reduce the over-all paper works and for a better archiving documentation.
                </span>
            </div>
            
            <div class="card-body">
                <div class="mt-2">
                    <span>Apply for Dean's List here</span>
                    <a href="zFRONTEND/apply.php" class="btn btn-success">Apply</a>
                </div>

                <div class="mt-3">
                    <span>Here as required by your adviser?</span>
                    <a href="zFRONTEND/registerfromindex.php">Register now</a>
                </div>
            </div>

        </div>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="column">
                    <h1>TOP ACHIEVERS</h1>
                    <span>Congratulations to the top 10 achievers!</span>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="container">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr class="bg-success text-white">
                        <th scope="col" class="font-weight-normal">Rank</th>
                        <th scope="col" class="font-weight-normal">First name</th>
                        <th scope="col" class="font-weight-normal">Middle name</th>
                        <th scope="col" class="font-weight-normal">Last name</th>
                        <th scope="col" class="font-weight-normal">GPA</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    <?php foreach ($decoded as $obj): ?>
                    <tr>
                        <th scope="row"><?php echo $counter+=1;?></th>
                        <td><?php echo $obj->firstname;?></td>
                        <td><?php echo $obj->middlename;?></td>
                        <td><?php echo $obj->lastname;?></td>
                        <td><?php echo $obj->gpa;?></td>
                    </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
                </div>
            </div>
            <a href="zFRONTEND/currentAchievers.php">View all achievers</a>
        </div>    
    </div>

</body>
</html>