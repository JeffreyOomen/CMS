<?php   

    if(isset($_POST['create_post'])) {
        $post_title = $_POST['post_title'];
        $post_author = $_POST['post_author'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];
        
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content']; 
        $post_comment_count = 0; 
        
        //Move image from temp location to wanted location
        move_uploaded_file($post_image_temp, "../images/$post_image");
        
        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status)"; 
        $query .= " VALUES($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', '$post_comment_count', '$post_status')";
        
        $query_result = mysqli_query($connection, $query);
        
        //Check if query was success
        confirm_query($query_result); 
        
        //Get the last id
        $post_id_add = mysqli_insert_id($connection);
        
        echo "<p class='alert alert-success'>Post Created. <a href='../post.php?p_id=$post_id_add'>View Post</a> or <a href=''>Add More Posts</a></p>";
    }

?>
   
<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
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
        <input type="text" class="form-control" name="post_author">
    </div>
    
    <div class="form-group">
        <select name="post_status" id="">
            <option value="">Post Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image" value="Choose File">
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
    </div>
    
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
    
</form>