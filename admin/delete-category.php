<?php 
include('../config/constants.php');
//echo "delete";
//check whether id and image name is set or not
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    //get value and delete
    //echo "get vale";
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];

    //remove the physical image file if available
    if($image_name!="")
    {
        //image is available
        $path="../images/category/".$image_name;
        //remove image
        $remove=unlink($path);  //to remove file
        if($remove==false)
        {
            //set the session msg
            $_SESSION['remove']="<div class='error'>Failed to Remvove Category Image.</div>";
            //redirect to manage cat page
            header('location:'.SITEURL.'admin/manage-category.php');
            //stop
            die();
        }
    }
    // then dete from db 
    $sql="DELETE FROM tbl_category WHERE id=$id";
    //execute query
    $res=mysqli_query($conn,$sql);
    //check if data is deleted
    if($res==True)
    {
        //success and redirect
        $_SESSION['delete']="<div class='success'>Category Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
            //fail and redirect
        $_SESSION['delete']="<div class='error'>Failed to delete category!.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');

    }
}
else
{
    //redirect to manage cat page
    header('location:'.SITEURL.'admin/manage-category.php');
    
}

?>