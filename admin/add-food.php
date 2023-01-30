<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>
        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:     </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description:  </td>
                    <td>
                        <textarea name="description"  cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:     </td>
                    <td>
                        <input type="number" name="price" >
                    </td>
                </tr>
                <tr>
                    <td>Select Image:   </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:    </td>
                    <td>
                        <select name="category" >

                            <?php
                            //display categories from db
                            //sql query to get all active categories from db
                            
                            $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                            $res=mysqli_query($conn,$sql);
                            //count rows to check if we have categories or not
                            $count=mysqli_num_rows($res);
                            //if count>0..we have categories
                            if($count>0)
                            {
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get details of category
                                    $id=$row['id'];
                                    $title=$row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //no category found
                                ?>
                                <option value="0">No Category Found.</option>
                                <?php
                            }
                            //display on dropdown
                            ?>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:   </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:   </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        //check whether the button is clicked or not
        if(isset($_POST['submit']))
        {
            //add the food in db
            //get the data from form
            $title=$_POST['title'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $category=$_POST['category'];
           
            //check radio button is checkted or not
            if(isset($_POST['featured']))
            {
                $featured=$_POST['featured'];
            }
            else
            {
                $featured="No";    //default
            }
             //check radio button is checkted or not
             if(isset($_POST['active']))
             {
                 $active=$_POST['active'];
             }
             else
             {
                 $active="No";    //default
             }
            //upload the image if selected
            //check whether the select image is clicked or not...upload if only selected
            if(isset($_FILES['image']['name']))
            {
                //get details of selected image
                $image_name=$_FILES['image']['name'];
                //check whether image is selected or not..
                if($image_name!="")
                {
                    //image selected
                    //now rename the image
                    $image_info = explode (".", $image_name);
                    $ext = end ($image_info);
                    //create new name 
                    $image_name="Food-name-".rand(0000,9999).".".$ext;
                   
                     //get source and dest path
                     $src=$_FILES['image']['tmp_name'];
                     $dst="../images/food/".$image_name;
                     //then upload img
                     $upload=move_uploaded_file($src,$dst);
                     //check whether img uploaded or not
                     if($upload==false)
                     {
                        //failed to upload img
                        //redirect to add food page
                        $_SESSION['upload']="<div class='error'>Failed to Upload Image.</div>";
                        header('location:'.SITEURL.'admin/add-food.php');   
                        die();
                     }
                }
            }
            else
            {
                $image_name="";
            }

            //insert to db
            //create sql query
            $sql2="INSERT INTO tbl_food SET 
            title='$title',
            description='$description',
            price=$price,
            image_name='$image_name',
            category_id=$category,
            featured='$featured',
            active='$active'
            ";

            //execute query
            $res2=mysqli_query($conn,$sql2);
            //redirect with msg to mange food page
            if($res2==true)
            {
                //data inserted successfully
                $_SESSION['add']= "<div class='success'>Food Added Successfully!</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                $_SESSION['add']= "<div class='error'>Failed to Add Food '</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }    

        }

        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>