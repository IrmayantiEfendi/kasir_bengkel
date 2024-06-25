<?php
require '../config/koneksi.php';
session_start();
    if (isset($_SESSION['username'])) header("location:../../index.php");

    if (isset($_POST['login'])) {
        $username = stripcslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($conn, $username);
        $password = stripcslashes(md5($_REQUEST['password']));
        $password = mysqli_real_escape_string($conn, $password);

        $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$username' AND password='$password' LIMIT 1");
        $count = mysqli_num_rows($query);
        if ($count > 0) {//jika ussername dan password yg diinput ada di dalam tabel user
            $data = mysqli_fetch_array($query);
            $rows = mysqli_num_rows($query);
            if ($rows==1) {
                $_SESSION['id_user']    = $data['id_user'];
                $_SESSION['username']   = $data['username'];
                $_SESSION['password']   = $data['password'];
                $_SESSION['role']       = $data['role'];

                if ($rows==1) {
                    
                    if ($data['role']=='admin' OR $data['role']=='super admin') {
                        header("Location: ../dashboard.php");
                    }
                }
            }
        }else{
            header("Location:../login.php?alert=failed");
        }
    }else{
        header("Location:../login.php?alert=failed");
    }
?>