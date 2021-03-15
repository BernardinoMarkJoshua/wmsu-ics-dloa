<?php 
    $counter = 0;
    $ch = curl_init();

    $url = "http://localhost/webacts/Cybersolution_Ver2/API/Fetch/fetchAchievers.php";

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
    <title>Achievers</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a href="#" class="navbar-brand">ICS-DLOA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a href="dashboard.html" class="nav-link">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a href="apply.html" class="nav-link">Apply</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="column">
                <h1>CURRENT ACHIEVERS</h1>
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
        <a href="dashboard.php">click here to go back</a>

    </div>

</body>
</html>