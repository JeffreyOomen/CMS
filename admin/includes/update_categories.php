<?php 
    if(isset($_POST['edit_category'])) {
        $category_title = mysqli_real_escape_string($connection, $_POST['cat_title']);
        
        if(isset($category_title)) {
            $query = "UPDATE categories SET cat_title= '$category_title' WHERE cat_id = $cat_id"; 
            $query_result = mysqli_query($connection, $query);
        }
    }
?>
    
<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>
        <?php
            $edit_category_id = mysqli_real_escape_string($connection, $_GET['edit']);

            $query = "SELECT * FROM categories WHERE cat_id = $edit_category_id";
            $query_result = mysqli_query($connection, $query);   

            while($row = mysqli_fetch_assoc($query_result)) { 
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];    
        ?>
        <input value="<?php if(isset($cat_title)) echo $cat_title; ?>" class="form-control" type="text" name="cat_title" />
        <?php } ?>
     </div>

     <div class="form-group">
         <input class="btn btn-primary" type="submit" name="edit_category" value="Edit Category">
     </div>   
</form>