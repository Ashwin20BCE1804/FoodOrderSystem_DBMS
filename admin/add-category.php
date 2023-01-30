<?php include('partials/menu.php'); 
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php

        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }


        ?>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> 
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php 
        //check if submit is clicked or not
        if(isset($_POST['submit']))
        {
            //echo "clicked";
            //get the value from form
            $title=$_POST['title'];
            //for radio input,we need to select whether the btn is clicked or not
            if(isset($_POST['featured']))
            {
                //get the value from form
                $featured=$_POST['featured'];
            }
            else
            {
                //set the default value 
                $featured="No";
            }
            if(isset($_POST['active']))
            {
                $active=$_POST['active'];
            }
            else
            {
                $active="No";
            }

            //check whether image is selcted or not and set value for image name accordingly
            //print_r($_FILES['image']);
            //die();     //to break the code
            if(isset($_FILES['image']['name']))
            {
                //upload the image
                //to upload we need name,source and dest path
                $image_name=$_FILES['image']['name'];
                //upload image if image is selected
                if($image_name!="")
                {
                    //auto renaming image
                    $ext=end(explode('.',$image_name));
                    //rename the image
                    $image_name="Food_Category_".rand(000,999).'.'.$ext;


                    $source_path=$_FILES['image']['tmp_name'];
                    $destination_path="../images/category/".$image_name;
                    //uploading image
                    $upload=move_uploaded_file($source_path,$destination_path);
                    //check whether the img is uploaded or not
                    //if not ridirect to error msg
                    if($upload==false)
                    {
                        $_SESSION['upload']="<div class='error'>Failed to upload Image.</div>";
                        //redirect to add category page
                        header('location:'.SITEURL.'admin/add-category.php');
                        die();

                    }
                }
            }
            else
            {
                //dont upload and set the image name value as blank
                $image_name="";
            }


            //create sql query to insert to db
            $sql="INSERT INTO tbl_category SET 
            title='$title',
            image_name='$image_name',
            featured='$featured',
            active='$active'
            ";
            //execute and save in db

            $res=mysqli_query($conn,$sql);
            //check whether query is executed or not
            if($res==TRUE)
            {
                //query executed ,category added
                $_SESSION['add']="<div class='success'>Category Added successfully.</div>";
                //redirect to manage cat page
                header('location:'.SITEURL.'admin/manage-category.php'); 
            }
            else
            {
                //failed to add category 
                $_SESSION['add']="<div class='error'>Failed to Add Category</div>";
                //redirect to manage cat page
                header('location:'.SITEURL.'admin/add-category.php'); 
            }

        }

         ?>



    </div>
</div>




<?php include('partials/footer.php'); 
?>