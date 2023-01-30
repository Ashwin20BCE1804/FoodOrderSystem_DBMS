<?php 
//include constants.php file
include('../config/constants.php');
//get the id of the admin to be deleted
 $id=$_GET['id'];
//create sql query to delete that admin
$sql="DELETE FROM tbl_admin WHERE id=$id";
//execute the query
$res=mysqli_query($conn,$sql);
//check whether the querry executed successfully or not
if($res==TRUE)
{
    //query executed successfull and admin deleted
    //echo " Admin deleted!";
    //create session var to display msg
    $_SESSION['delete']="<div class='success'>Admin Deleted Successfully.</div>";
    //redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else
{
    //failed to delete admin
    //echo "Failed to delete admin";
    $_SESSION['delete']=" <div class='error'>Failed To Delete Admin..Try Again Later.</div>";
    //redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
//redirect to manage admin page with msg-success/error
?>