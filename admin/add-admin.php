<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php
            if(isset($_SESSION['add']))  //checking whether session is set or not
            {
                echo $_SESSION['add'];   //display session msg 
                unset($_SESSION['add']);  //remove session message
            }
            
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>UserName: </td>
                    <td><input type="text" name="username" placeholder="Your Username"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
//processing form and save in db

//check whether submit is clicked or not
if(isset($_POST['submit']))
{
    //button clicked
    //echo "button clicked";
    //get data
    $full_name=$_POST['full_name'];
    $username=$_POST['username'];
    $password=md5($_POST['password']);

    //sql query to save into database
    $sql="INSERT INTO tbl_admin SET 
    full_name='$full_name',
    username='$username',
    password='$password'
    ";
    //execute query and saving to databse
 
    $res=mysqli_query($conn, $sql) or die(mysqli_error());

    //check whether the data is inserted
    if($res==TRUE)
    {
        //data inserted
        //echo "data inserted";
        //create a variable to display mesg
        $_SESSION['add']="<div class='success'>Admin Added Successfully. </div>";
        //redirect page to manage admin
        header("location: ".SITEURL.'admin/manage-admin.php');
    }
    else{
        //failed to insert data
        //echo "failed to insert data";

        //create a variable to display mesg
        $_SESSION['add']="<div class='error'>Failed To Add Admin. </div>";
        //redirect page to add admin
        header("location: ".SITEURL.'admin/manage-admin.php');
    }
}

?>