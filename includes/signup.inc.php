<?php

    session_start();
    if(isset($_POST['submit'])){    
        include_once 'dbh.inc.php';
        $fname=mysqli_real_escape_string($conn,$_POST['fname']);
        $_SESSION['fname']=$fname;
        $lname=mysqli_real_escape_string($conn,$_POST['lname']);
        $phone=mysqli_real_escape_string($conn,$_POST['phone']);
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $pwd=mysqli_real_escape_string($conn,$_POST['pwd']);
        $ans=mysqli_real_escape_string($conn,$_POST['ans']);
        $hash = md5( rand(0,1000) );
        if(preg_match("/[^0-9]/", $phone)){
            header("location: ../logsignup/signup.php?signup=onlynumberallowed&lname=$lname&email=$email&phone=$phone&fname=$fname");
            exit();
        }
        else{
            
            //check for correct firstname or lastname
            if(!preg_match("/^[a-zA-Z]*$/", $fname) || !preg_match("/^[a-zA-Z]*$/", $lname))
            {
                $fnameerror="Invalid format";
                header("location: ../logsignup/signup.php?signup=invalidName");
                exit();
            }
            else{
                // check for valid Email
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    header("location: ../logsignup/signup.php?signup=email&fname=$fname&lname=$lname&phone=$phone");
                    exit();
                }
                else{
                    // check for blogname
                    $sql = "SELECT * FROM blogger WHERE blog_email='$email'";
                    $result = mysqli_query($conn, $sql);
                    $resultcheck = mysqli_num_rows($result);
                    if($resultcheck > 0){
                       header("location: ../logsignup/signup.php?signup=Emailtaken");
                        
                        exit();
                    }
                        else{
                        $answer=$_SESSION["answer"];
                        $blog_answer=$_POST['ans'];
                        if($answer != $blog_answer){   
                            header("location: ../logsignup/signup.php?signup=invalidsecuritycode");
                        exit();
                        }
                        else{
                        $hashpwd = password_hash($pwd,PASSWORD_DEFAULT);
                        $sql = "INSERT INTO blogger(blog_first,blog_last,blog_email,blog_phone,blog_pwd,blog_verified,blog_hash) VALUES ('$fname','$lname','$email','$phone','$hashpwd','false','$hash');";
                        
                        mysqli_query($conn, $sql);
                        $_SESSION['success']=1;
                        $_SESSION['email']=$email;
                        $_SESSION['pwd']=$pwd;
                        $_SESSION['hash']=$hash;
                        header("location: ../logsignup/email_verification.php");
                        exit();
                    }        
                }
             
            }
        }
    }
}else{
        header("location: ../logsignup/signup.php");
        exit();
    }
?>