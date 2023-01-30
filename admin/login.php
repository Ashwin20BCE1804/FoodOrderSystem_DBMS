
<?php include('../config/constants.php'); ?>
<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../CSS/admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">Login Here</h1><br><br>
            <h3 class="text-center">Description(Read the above and login the form)</h3><br>
            <p class="text">Customers can make different cuisine choices from the comfort of their home.
                 Most of the apps even offer great deals from your favourite restaurants that help you save some pennies while enjoying the tasty feast.
With new norms of social distancing, more and more people are preferring to dine in safely at home and that is another reason why 
food delivery apps are on demand than ever before. Understanding 
the user preferences and their safety, most of the apps have added contactless delivery features.</p><br><br><br><br>

<?php
if(isset($_SESSION['login']))
{
    echo $_SESSION['login'];
    unset($_SESSION['login']);
}

if(isset($_SESSION['no-login-message']))
{
    echo $_SESSION['no-login-message'];
    unset($_SESSION['no-login-message']);
}
 ?>
 <br><br>

            <form action="" method="POST" class="text-center">
                Username:
                <br>
                <input type="text" name="username" placeholder="Enter Username">
                <br><br>
                Password:
                <br>
                <input type="password" name="password" placeholder="Enter Password">
                <br><br>
                <input type="submit" name="submit" value="Login" class="btn-primary">
            </form><br><br>

            
            <p class="text-center">Created by <a href="www.ashwin.com">Ashwin sivasankar.</a></p>
    
        </div>
    </body>
</html>

<?php
//check if submit is clicked or not
if(isset($_POST['submit']))
{
    //process for login
    //get data from loginform
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $raw_password=md5($_POST['password']);
    $password=mysqli_real_escape_string($conn,$raw_password);

    //query to check whether the username and password exist or not
    $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    //execute the query
    $res=mysqli_query($conn,$sql);
    //count rows to check if user exists or not
    $count=mysqli_num_rows($res);
    if($count==1)
    {
        //login success
        $_SESSION['login']="<div class='success'>Login Successful.</div>";
        $_SESSION['user']=$username;
        //redirect to home page
        header('location:'.SITEURL.'admin/');
    }
    else
    {
        $_SESSION['login']="<div class='error text-center'>Username and password did not match!</div>";
        //redirect to home page
        header('location:'.SITEURL.'admin/login.php');
    }
}
?>