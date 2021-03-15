<?php
    session_start();

    if ($_SESSION['status'] == 'invalid') {
        echo '<script>window.location.href="login.php"</script>';
    } else if ($_SESSION['role'] == 'ADMIN') {
        echo '<script>window.location.href="admin_landing.php"</script>';
    }

    if(isset($_POST['logout-btn'])) {
        unset($_SESSION['role']);
        unset($_SESSION['username']);
        unset($_SESSION['faculty_id']);
        $_SESSION['status'] = 'invalid';

        echo '<script>window.location.href="login.php"</script>';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adviser</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a href="#" class="navbar-brand">ICS-DLOA Faculty</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#modalid" data-toggle="modal" data-target="#modalid">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <span><?php echo '<strong>Hello </strong>'.$_SESSION['username'];?></span>
    <span><?php echo $_SESSION['role'];?></span>

    <!-- Modal -->
    <div class="modal fade" id="modalid" tabindex="-1" role="dialog" aria-labelledby="modal-title-id" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title-id">Confirm</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Are you sure you want to logout?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form action="admin_landing.php" method="POST">
                <input type="submit" value="logout" name="logout-btn" class="btn btn-danger">
            </form>
        </div>
        </div>
    </div>
    </div>

    <div class="container">
        
        <div class="row justify-content-center mt-3">
            <div class="card m-4" style="width: 15rem;">
            <img src="../zADMINFRONTEND/assets/gate.png" class="card-img-top" alt="gate">
                <div class="card-body">
                    <p class="card-text"><strong>Gate</strong> Allows you to approve the registration of a student from the one-time registration database.</p>
                    <a href="adviserGate.php"> Go </a>
                </div>
            </div>

            <div class="card m-4" style="width: 15rem;">
            <img src="../zADMINFRONTEND/assets/student.png" class="card-img-top" alt="gate">
                <div class="card-body">
                    <p class="card-text"><strong>Student</strong> View students who have been verified from the gate and are now eligible to apply for dean's list.</p>
                    <a href="adviserStudent.php"> Go </a>
                </div>
            </div>

            <div class="card m-4" style="width: 15rem;">
            <img src="../zADMINFRONTEND/assets/verif.png" class="card-img-top" alt="gate">
                <div class="card-body">
                    <p class="card-text"><strong>Verify</strong> Allows you to verify the application form of the student you can also deny the application forms.</p>
                    <a href="adviserVerify.php"> Go </a>
                </div>
            </div>
        </div>
    
    </div>
    
</body>
</html>