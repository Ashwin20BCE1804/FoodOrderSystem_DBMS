<?php
include('partials/menu.php');
 ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }
        ?>
        <form action="" method="POST">
        <table class="tbl-30">
            <tr>
                <td>Current Password: </td>
                <td>
                    <input type="password" name="current_password" placeholder="Current Password">
                </td>
            </tr>
            <tr>
                <td>New Password: </td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password" >
                </td>
            </tr>
            <tr>
                <td>Confirm Password: </td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                </td>
            </tr>

        </table>
        </form>
    </div>
</div>

<?php
//check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //echo "button"; 
    //get data from form
    $id=$_POST['id'];
    $current_password=md5($_POST['current_password']);
    $new_password=md5($_POST['new_password']);
    $confirm_password=md5($_POST['confirm_password']);

    //check whether current user and password exits
    $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
    //execute
    $res=mysqli_query($conn,$sql);
    if($res==TRUE)
    {
        //check if data is available
        $count=mysqli_num_rows($res); 
        if($count==1)
        {
            //user exists and password can be changed
            //echo "User Found";
            //check if new password and confirmpassword matches or not
            if($new_password==$confirm_password)
            {
                //echo "password matched";
                //update password
                $sql2="UPDATE tbl_admin SET
                password='$new_password'
                WHERE id='$id'
                ";
                //execute
                $res2=mysqli_query($conn,$sql2);
                //check whether is executed or not

                if($res2==TRUE)
                {
                    //success msg
                    //redirect to manage admin with success msg
                    $_SESSION['change-pwd']="<div class='success'>Password Changed Successfully !</div>";
                    //redirect user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
                else{
                    //error msg
                    //redirect to manage admin with error msg
                    $_SESSION['change-pwd']="<div class='success'>Failed To Change Password !</div>";
                    //redirect user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }

            }
            else{
            //redirect to manage admin with error msg
            $_SESSION['pwd-not-match']="<div class='error'>Password Did Not Match!.</div>";
            //redirect user
            header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        else{
            //user doesnt exists
            $_SESSION['user-not-found']="<div class='error'>User Not Found.</div>";
            //redirect user
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
    //check whether new password and confrim password matches or not
    //change password if all are true
}
?>

<?php
include('partials/footer.php');
 ?>