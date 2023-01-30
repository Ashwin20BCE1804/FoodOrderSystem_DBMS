<?php 
include('partials/menu.php');
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
        //get the id of selected admin
        $id=$_GET['id'];
        //create sql query to get details
        $sql="SELECT * FROM tbl_admin WHERE id=$id";
        //execute query
        $res=mysqli_query($conn,$sql);
        //check if query is executed or not
        if($res==TRUE)
        {
            //check if data is available
            $count=mysqli_num_rows($res);
            //check whether we have admin data or not
            if($count==1)
            {
                //get details
                //echo "Admin available";
                $row=mysqli_fetch_assoc($res);

                $full_name=$row['full_name'];
                $username=$row['username'];
            }
            else
            {
                //redirect to manage admin page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }

         ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value=" <?php echo $id; ?>">
                        <input type="submit" name="submit" value="update Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php 
//check whether submit button is clicked or not
if(isset($_POST['submit']))
{
    //echo "button clicked";
    //get all the values from form
     $id=$_POST['id'];
     $full_name=$_POST['full_name'];
     $username=$_POST['username'];
     //create sql query to update admin
     $sql="UPDATE tbl_admin SET 
     full_name='$full_name',
     username='$username'
     WHERE id='$id'
     ";
     

     
     //execute query
     $res=mysqli_query($conn,$sql);
     //check if query executed uccessfuly or not
     if($res==TRUE)
     {
        //query executed and admin updated
        $_SESSION['update']=" <div class='success'>Admin Updated Successfully.</div>";
        //redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
     }
     else{
        //failed to update admin
        $_SESSION['update']=" <div class='error'>Failed To Update Admin</div>";
        //redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
     }

}
?>

<?php 
include('partials/footer.php');
?>