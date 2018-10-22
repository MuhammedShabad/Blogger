<?php
session_start();
if(isset($_POST['submit']))
{
    include 'dbh.inc.php';
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
    if(empty($email) || empty($pwd)){
        header("Location: ../logsignup/login.php?login=empty");
        exit();
    }
    else{
        $sql = "SELECT * FROM blogger WHERE blog_email='$email'";
        $result = mysqli_query($conn,$sql);
        $resultcheck = mysqli_num_rows($result);
        if($resultcheck < 1){
            header("Location: ../logsignup/login.php?login=nosuchemail");
            exit();
        }else{
            if($row = mysqli_fetch_assoc($result)){
                $hashedpwdCheck = password_verify($pwd,$row['user_pwd']);
                if(hashedpwdCheck == false){
                    header("Location: ../logsignup/login.php?login=Invalid Password");
                    exit(); 
                }
                else if(hashedpwdCheck == true){
                    $sqlactivate = "SELECT * FROM blogger WHERE blog_email='$email'";
                    $result = mysqli_query($conn,$sqlactivate);
                    if($row = mysqli_fetch_assoc($result)){
                            if($row['blog_verified'] != 1){
                                $_SESSION['msg'] = 'You have not yet verified your Email.';
                                header("location: ../logsignup/login.php?sent");
                            }else{
                                $_SESSION['b_email'] = $row['blog_email'];
                                $_SESSION['b_first'] = $row['blog_first'];
                                $_SESSION['b_last'] = $row['blog_last'];
                                header("Location: ../loggedInUser.php?login=success");
                                exit();
                            }
                    }
                }
            }
        }
    }
}else{
    header("Location: ../loginpage.php?login=error");
    
    exit();
}