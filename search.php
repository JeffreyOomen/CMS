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
                    //If the submit button is pressed. 
                    if(isset($_POST['submit_post'])) {
                        $search_post = mysqli_real_escape_string($connection, $_POST['search_post']);

                        $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search_post%'";
                        $query_result = mysqli_query($connection, $query);

                        $amountOfResults = mysqli_num_rows($query_result);
                        if(!$query_result) {
                            die("The Query Failed. " . mysqli_error($connection));
                        } else {
                            if($amountOfResults == 1) {
                                echo "There is $amountOfResults result found.";
                            } else {
                                echo "There are $amountOfResults results found.";
                            }
                        }

                        while($row = mysqli_fetch_assoc($query_result)) {
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = $row['post_content'];  
                        
                ?>
                
                <h1 class="page-header">Page Heading<small>Secondary Text</small></h1>

                <!-- First Blog Post -->
                <h2><a href="#"><?php echo $post_title; ?></a></h2>
                <p class="lead">by <a href="index.php"><?php echo $post_author ?></a></p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                
                <?php 
                        } # /.while-loop
                
                    /* Empty the resultset. */
                    mysqli_free_result($query_result);
                        
                    } # /.if-statement
                ?>
            </div><!-- /.col-md-8 -->
            
            <!-- Blog Sidebar Widgets Column -->
            <?php include('includes/sidebar.php'); ?>

        </div><!-- /.row -->

        <hr>

<?php include('includes/footer.php') ?>        