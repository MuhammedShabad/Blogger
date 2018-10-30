<?php
session_start();
if(isset($_POST['submit']))
{
    include 'dbh.inc.php';
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
    if(empty($username) || empty($pwd)){
        header("Location: ../logsignup/login.php?login=empty");
        exit();
    }
    else{
        $sql = "SELECT * FROM blogger WHERE blog_username='$username'";
        $result = mysqli_query($conn,$sql);
        $resultcheck = mysqli_num_rows($result);
        if($resultcheck < 1){
            header("Location: ../logsignup/login.php?login=nosuchusername");
            exit();
        }else{
            if($row = mysqli_fetch_assoc($result)){
                echo password_hash($pwd,PASSWORD_DEFAULT);
                echo $row['blog_pwd'];
                $hashedpwdCheck = password_verify($pwd,$row['blog_pwd']);
                if($hashedpwdCheck == false){
                    //header("Location: ../logsignup/login.php?login=InvalidPassword");
                    exit(); 
                }
                else if($hashedpwdCheck == true){
                    $sqlactivate = "SELECT * FROM blogger WHERE blog_username='$username'";
                    $result = mysqli_query($conn,$sqlactivate);
                    if($row = mysqli_fetch_assoc($result)){
                            if($row['blog_verified'] != 1){
                                $_SESSION['msg'] = 'You have not yet verified your username.';
                                header("location: ../logsignup/login.php?sent");
                            }else{
                                $_SESSION['b_username'] = $row['blog_username'];
                                $_SESSION['b_first'] = $row['blog_first'];
                                $_SESSION['b_last'] = $row['blog_last'];
                                $_SESSION['b_phone'] = $row['blog_phone'];
                                $_SESSION['b_email'] = $row['blog_email'];
                                header("Location: ../loggedInUser.php?login=success");
                                exit();
                            }
                    }
                }
            }
        }
    }
}else{
    header("Location: ../login.php?login=error");
    
    exit();
}

