<?php  
    //Display the right user information
    if(isset($_GET['edit_user'])) {
        $user_id_edit = $_GET['edit_user'];
        
        $query = "SELECT * FROM users WHERE user_id = $user_id_edit"; 
        $query_result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($query_result)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
        }
    }

    //Update the user
    if(isset($_POST['edit_user'])) {
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        
       /* $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];*/
        
        $username = $_POST['username'];
        $user_email = $_POST['user_email']; 
        $user_password = $_POST['user_password']; 
        
        //Move image from temp location to wanted location
        /*move_uploaded_file($post_image_temp, "../images/$post_image");*/
        
        //Also need to hash the password here
        $query = "SELECT randSalt FROM users";
        $query_result = mysqli_query($connection, $query);

        if(!$query_result) {
            die("Query Failed." . mysqli_error($connection));
        }
        
        $row = mysqli_fetch_assoc($query_result);
        $randSalt = $row['randSalt'];
        $hashed_password = crypt($user_password, $randSalt);
        
        $query = "UPDATE users SET ";
        $query .= "user_firstname = '$user_firstname', ";
        $query .= "user_lastname = '$user_lastname', ";
        $query .= "user_role = '$user_role', ";
        $query .= "username = '$username', ";
        $query .= "user_email = '$user_email', ";
        $query .= "user_password = '$hashed_password' ";
        $query .= "WHERE user_id = $user_id_edit";
        
        $query_result = mysqli_query($connection, $query);
        
        //Check if query was success
        confirm_query($query_result); 
    }
?>
   
<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
    </div>
    
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname">
    </div>
    
    <div class="form-group">
        <select name="user_role" id="">
            <option value="<?php echo $user_role ?>"><?php echo $user_role; ?></option>
           <?php 
               if($user_role == 'Admin') {
                    echo "<option value='Subscriber'>Subscriber</option>"; 
               } else {
                    echo "<option value='Admin'>Admin</option>";
               }    
            ?>
        </select>
    </div>
    
    <!--<div class="form-group">
        <label for="post_image"></label>
        <input type="file" name="post_image" value="Choose File">
    </div>-->
    
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
    </div>
    
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email">
    </div>
    
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" value="<?php echo $user_password; ?>" class="form-control" name="user_password">
    </div>
    
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
    </div>
    
</form>