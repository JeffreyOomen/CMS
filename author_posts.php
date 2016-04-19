<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>

    <!-- Navigation -->
    <?php include('includes/navigation.php'); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                    if(isset($_GET['author'])) {
                        $post_author = $_GET['author'];
                    
                
                    $query = "SELECT * FROM posts WHERE post_author = '$post_author'"; 
                    $query_result = mysqli_query($connection, $query);
                
                    while($row = mysqli_fetch_assoc($query_result)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];                
                ?>
                
                <h1 class="page-header">Page Heading<small>Secondary Text</small></h1>

                <!-- First Blog Post -->
                <h2><a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
                <p class="lead">Post By <?php echo $post_author ?></p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                
                <p><?php echo $post_content ?></p>
                <hr>
                
                <?php 
                    } 
                    /* Empty the resultset. */
                    mysqli_free_result($query_result);
                        }
                
                ?>
                
                <!-- Blog Comments -->
                <?php
                    if(isset($_POST['create_comment'])) {
                        
                        
                        $post_id = $_GET['p_id'];
                        
                        $comment_author= $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        
                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            $comment_query = "INSERT INTO comments (comment_post_id, comment_author, comment_email,                                                                             comment_content, comment_status, comment_date)";
                            $comment_query .= "VALUES($post_id, '$comment_author', '$comment_email', '$comment_content', 'Unapproved', now() )";

                            $comment_query_result = mysqli_query($connection, $comment_query);

                            if(!$comment_query_result) {
                                die("Error: " . mysqli_error($connection));
                            }

                            //Increment the comment coun for this post
                            $increment_query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $post_id";
                            $increment_query_result = mysqli_query($connection, $increment_query);

                            if(!$increment_query_result) {
                                die("Error: " . mysqli_error($connection));
                            }
                        } else {
                            echo "<script>alert('Fields cannot be empty.')</script>";
                        }
                    }   
                ?>
    
            </div><!-- /.col-md-8 -->
            
            <!-- Blog Sidebar Widgets Column -->
            <?php include('includes/sidebar.php'); ?>

        </div><!-- /.row -->

        <hr>

<?php include('includes/footer.php') ?>        