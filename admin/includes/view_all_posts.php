<?php
    if(isset($_POST['checkBoxArray'])) {
        $boxArray = $_POST['checkBoxArray'];
        
        foreach($boxArray as $checkBoxValue) {
            $bulk_options = $_POST['bulk_options'];
            
            if($bulk_options == 'published' || $bulk_options == 'draft') {
                $query = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = $checkBoxValue";
                $query_result = mysqli_query($connection, $query);
            } else if($bulk_options == 'delete') {
                $query = "DELETE FROM posts WHERE post_id = $checkBoxValue";
                $query_result = mysqli_query($connection, $query);
            } else if($bulk_options == 'clone') {
                $query = "SELECT * FROM posts WHERE post_id = $checkBoxValue";
                $query_result = mysqli_query($connection, $query);
                
                while($row = mysqli_fetch_assoc($query_result)) {
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_date = $row['post_date'];
                    $post_author = $row['post_author'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content']; 
                    $post_comment_count = 0;
                }
                
                 $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status)"; 
                 $query .= " VALUES($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', '$post_comment_count', '$post_status')";
        
                 $query_result = mysqli_query($connection, $query);
                
            }
        }   
    }
?>

<form action="" method="post">
<table class="table table-bordered table-hover">
   
    <div id="bulkOptionContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>   
    </div>
    
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
   
    <thead>
        <tr>
            <th><input type="checkbox" id="selectAllBoxes"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comment Count</th>
            <th>Date</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Viewed Count</th>
        </tr>
    </thead>
    <tbody>
    
<?php 
    $query = "SELECT * FROM posts ORDER BY post_id DESC"; 
    $query_result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($query_result)) {
        echo "<tr>";
        echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='{$row['post_id']}'></td>";
        echo "<td>{$row['post_id']}</td>";
        echo "<td>{$row['post_author']}</td>";
        echo "<td>{$row['post_title']}</td>";
        //Get the right category
        $category_query = "SELECT * FROM categories WHERE cat_id = {$row['post_category_id']}";
        $category_query_result = mysqli_query($connection, $category_query); 
        
        while($category_row = mysqli_fetch_assoc($category_query_result)) {
            $cat_id = $category_row['cat_id'];
            $cat_title = $category_row['cat_title'];
            
            echo "<td>$cat_title</td>";
        }
        
        echo "<td>{$row['post_status']}</td>";
        echo "<td><img width= '100' src='../images/{$row['post_image']}'></td>";
        echo "<td>{$row['post_tags']}</td>";
        
        //New comment count query
        $query_comment_count = "SELECT COUNT(comment_id) AS amountOfComments, comment_id FROM comments WHERE comment_post_id = {$row['post_id']}";
        $query_comment_count_result = mysqli_query($connection, $query_comment_count);
        $comment_count_row = mysqli_fetch_assoc($query_comment_count_result);
        
        echo "<td><a href='post_comments.php?id={$row['post_id']}'>{$comment_count_row['amountOfComments']}</a></td>";
        echo "<td>{$row['post_date']}</td>";
        echo "<td><a href='../post.php?p_id={$row['post_id']}'>View Post</a></td>";
        echo "<td><a href='posts.php?source=edit_post&p_id={$row['post_id']}'>Edit</a></td>";
        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?')\" href='posts.php?delete_post={$row['post_id']}'>Delete</a></td>";
        echo "<td><a href='posts.php?reset={$row['post_id']}'>{$row['post_views_count']}</a></td></tr>";
    }
?>
                      
    </tbody>
</table>
</form>

<?php 
    if(isset($_GET['delete_post'])) {
        $post_id_delete = $_GET['delete_post'];
        
        $query = "DELETE FROM posts WHERE post_id = $post_id_delete";
        $query_result = mysqli_query($connection, $query);
        
        confirm_query($query_result);
        header('Location: posts.php');
    }

if(isset($_GET['reset'])) {
        $post_id_reset = $_GET['reset'];
        
        $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $post_id_reset";
        $query_result = mysqli_query($connection, $query);
        
        confirm_query($query_result);
        header('Location: posts.php');
    }
?>