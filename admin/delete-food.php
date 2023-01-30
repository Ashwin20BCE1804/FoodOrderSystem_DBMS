<?php
include('../config/constants.php');
if(isset($_GET['id']) && isset($_GET['image_name']))
{ 
    //echo "process to delete";
    //get image and id
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];

    //remove image if available
    if($image_name !="")
    {
        //has image and need to remove
        $path="../images/food/".$image_name;
        $remove=unlink($path); 
        //check image is removed
        if($remove==false)
        {
            $_SESSION['upload']="<div class='error'>Failed to remove image.</div>";
            header('location:'.SITEURL.'admin/manage-food.php'); 
            die();

        }
    }
    //delete food from db
    $sql="DELETE FROM tbl_food WHERE id=$id";
    $res=mysqli_query($conn,$sql);
    if($res==true)
    {
        $_SESSION['delete']="<div class='success'>Food deleted Successfully!</div>";
        header('location:'.SITEURL.'admin/manage-food.php'); 
    }
    else
    {
        $_SESSION['delete']="<div class='error'>Failed to delete food.</div>";
        header('location:'.SITEURL.'admin/manage-food.php'); 
    }


} 
else
{
    $_SESSION['unauthorize']="<div class='error'>Unauthorized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}
?>