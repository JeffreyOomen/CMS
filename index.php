<?php include('includes/header.php'); ?>
<?php include('includes/db.php'); ?>

<?php $active = "dashboard"; ?>

    <!-- Navigation -->
    <?php include('includes/navigation.php'); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                    if(isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = "";
                    }
                
                    if($page == "" || $page == 1) {
                        $page_1 = 0;
                    } else {
                        $page_1 = ($page * 5) - 5;
                    }
                
                    $query_count = "SELECT COUNT(post_id) AS count FROM posts WHERE post_status = 'published'";
                    $query_count_result = mysqli_query($connection, $query_count);
                    
                    $count = mysqli_fetch_assoc($query_count_result)['count'];
                    $count = ceil($count / 5);
                
                    $query = "SELECT * FROM posts LIMIT $page_1, 5"; 
                    $query_result = mysqli_query($connection, $query);
                
                    while($row = mysqli_fetch_assoc($query_result)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        //Just show a bit of content
                        $post_content = substr($row['post_content'], 0, 200); 
                ?>
                
                <h1 class="page-header">Page Heading<small>Secondary Text</small></h1>

                <!-- First Blog Post -->
                <h2><a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
                <p class="lead">by <a href="author_posts.php?author=<?php echo $post_author; ?>"><?php echo $post_author ?></a></p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                <hr>
                
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                
                <?php 
                    }
                
                    /* Empty the resultset. */
                    mysqli_free_result($query_result);
                ?>
            </div><!-- /.col-md-8 -->
            
            <!-- Blog Sidebar Widgets Column -->
            <?php include('includes/sidebar.php'); ?>

        </div><!-- /.row -->

        <hr>

        <ul class="pager">
            
            <?php 
                for($i = 1; $i <= $count ; $i++) {
                    
                    if($i == $page) {
                        echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
                    } else {
                        echo "<li><a href='index.php?page=$i'>$i</a></li>";
                    }
                    
                }
            ?>
            
        </ul>
        

<?php include('includes/footer.php') ?>        