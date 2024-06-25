
<?php
session_start();
 
if( isset($_SESSION['role']) )
{
    header('location:./'.$_SESSION['role']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require 'layouts/header.php' ?>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="../img/login.jpg" style="height: 100%; width: 100%">
                            </div>
                            <div class="col-lg-6">
                                
                                <div class="mt-4">
                                <?php 
                                    if (isset($_GET['alert'])) {
                                    ?>
                                    <div class="col-md-12">
                                        <div class="alert-wrap2 shadow-reset wrap-alert-b">
                                        <div class="alert alert-danger">
                                            <strong>Gagal Masuk!</strong> Username atau password tidak ditemukan!
                                        </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="p-5 mt-4">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form method="POST" action="action/proses_login.php" class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="Username" name="username" aria-describedby="Username"
                                                placeholder="Masukan Username">
                                        </div>
                                        <div class="form-group mt-4">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" name="password" placeholder="Password">
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" name="login" value="Login">
                                    </form>
                                    <hr>

                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <?php require 'layouts/footer.php' ?>

</body>

</html>