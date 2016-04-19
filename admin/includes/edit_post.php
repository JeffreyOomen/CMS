<?php   
    $message = "";
    if(isset($_GET['p_id'])) {
        $post_id_edit = $_GET['p_id'];
        
        $query = "SELECT * FROM posts WHERE post_id=$post_id_edit"; 
        $query_result = mysqli_query($connection, $query);
        confirm_query($query_result);
        
        while($row = mysqli_fetch_assoc($query_result)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_content = $row['post_content'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];
        }
    }

    if(isset($_POST['update_post'])) {
        $post_title = $_POST['post_title'];
        $post_author = $_POST['post_author'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        
        //This image is not in the <select> anymore
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];
        
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content']; 
        $post_comment_count = 4; 
        
        //Move image from temp location to wanted location
        move_uploaded_file($post_image_temp, "../images/$post_image");
    
        //Get the image again
        if(empty($post_image)) {
            $image_query = "SELECT * FROM posts WHERE post_id = $post_id_edit";
            $image_query_result = mysqli_query($connection, $image_query);
            
            while($row = mysqli_fetch_assoc($image_query_result)) {
                $post_image = $row['post_image'];
            }
        }
        
        $query = "UPDATE posts SET ";
        $query .= "post_title = '$post_title', ";
        $query .= "post_category_id = $post_category_id, ";
        $query .= "post_date = now(), ";
        $query .= "post_author = '$post_author', ";
        $query .= "post_status = '$post_status', ";
        $query .= "post_tags = '$post_tags', ";
        $query .= "post_content = '$post_content', ";
        $query .= "post_image = '$post_image' ";
        $query .= "WHERE post_id = $post_id_edit";
        
        $query_result = mysqli_query($connection, $query);
        confirm_query($query_result);
        
        $message = "<p class='alert alert-success'>Post Updated. <a href='../post.php?p_id=$post_id_edit'>View Post</a> or <a href='posts.php'>View all posts</a></p>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <?php echo $message; ?>
    </div>
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
    </div>
    
    <div class="form-group">
        <label for="post_category">Post Category</label>
        <select name="post_category" id="">
        <?php
            $query = "SELECT * FROM categories";
            $query_result = mysqli_query($connection, $query);   

            while($row = mysqli_fetch_assoc($query_result)) { 
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='$cat_id'>$cat_title</option>";
            }
        ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="title">Post Author</label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">
    </div>
    
    <div class="form-group">
    <select name="post_status" id="">
        <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
        
        <?php 
            if($post_status == "draft") {
                echo "<option value='published'>published</option>";
            } else {
                echo "<option value='draft'>draft</option>";
            }
        ?>
        
    </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image"><br />
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="post image">
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?>
        </textarea>
    </div>
    
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
    
</form>