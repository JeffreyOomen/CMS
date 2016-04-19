<!-- Include the header --> 
<?php include('includes/admin_header.php'); ?>

    <!-- Navigation -->
    <?php include('includes/admin_navigation.php'); ?>

     <div id="page-wrapper">

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Welcome Admin<small>Author</small></h1>  
                </div>
   <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response To</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    
<?php 
    $query = "SELECT * FROM comments WHERE comment_post_id = " . mysqli_real_escape_string($connection, $_GET['id']).";"; 
    $query_result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($query_result)) {
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row['comment_email'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];
        
        echo "<tr><td>$comment_id</td>";
        echo "<td>$comment_author</td>";
        echo "<td>$comment_content</td>";
        echo "<td>$comment_email</td>";
        echo "<td>$comment_status</td>";
        
        $get_post_query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
        $get_post_query_result = mysqli_query($connection, $get_post_query);
        
        while($row = mysqli_fetch_assoc($get_post_query_result)) {
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        }
        
        
        echo "<td>$comment_date</td>";
        echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
        echo "<td><a href='comments.php?unapprove=$comment_id'>Disapprove</a></td>";
        echo "<td><a href='post_comments.php?delete=$comment_id&id={$_GET['id']}'>Delete</a></td></tr>";
    }      
?>                     
    </tbody>
</table>

<?php 
    if(isset($_GET['approve'])) {
        $comment_id_edit = $_GET['approve'];

        $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $comment_id_edit";
        $query_result = mysqli_query($connection, $query);

        confirm_query($query_result);
        header('Location: comments.php');
    }

     if(isset($_GET['unapprove'])) {
        $comment_id_edit = $_GET['unapprove'];

        $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = $comment_id_edit";
        $query_result = mysqli_query($connection, $query);

        confirm_query($query_result);
        header('Location: comments.php');
    }

    if(isset($_GET['delete'])) {
        $comment_id_delete = $_GET['delete'];
        
        $query = "DELETE FROM comments WHERE comment_id = $comment_id_delete";
        $query_result = mysqli_query($connection, $query);
        
        confirm_query($query_result);
        header("Location: post_comments.php?id={$_GET['id']}");
    }
?>


</div><!-- /.row -->
        </div><!-- /.container-fluid -->

    </div><!-- /#page-wrapper -->
    
<!-- Include the footer --> 
<?php include('includes/admin_footer.php'); ?>