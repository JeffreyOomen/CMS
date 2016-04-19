<!-- Include the footer --> 
<?php include('includes/admin_header.php'); ?>

    <!-- Navigation -->
    <?php include('includes/admin_navigation.php'); ?>

     <div id="page-wrapper">

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Welcome to admin
                    <small><?php echo $_SESSION['user_firstname']; ?></small></h1>
                </div>
            </div><!-- /.row -->
            
            <!-- The Dashboard Widgets -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php
                                    $query = "SELECT count(post_id) AS amountOfPosts FROM posts"; 
                                    $query_result = mysqli_query($connection, $query); 
                                    while($row = mysqli_fetch_assoc($query_result)) {
                                        $amountOfPosts = $row['amountOfPosts'];    
                                    }
                                    echo "<div class='huge'>$amountOfPosts</div>";
                                ?>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                 <?php
                                    $query = "SELECT count(comment_id) AS amountOfComments FROM comments"; 
                                    $query_result = mysqli_query($connection, $query); 
                                    while($row = mysqli_fetch_assoc($query_result)) {
                                        $amountOfComments = $row['amountOfComments'];    
                                    }
                                    echo "<div class='huge'>$amountOfComments</div>";
                                ?>
                                  <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php
                                    $query = "SELECT count(user_id) AS amountOfUsers FROM users"; 
                                    $query_result = mysqli_query($connection, $query); 
                                    while($row = mysqli_fetch_assoc($query_result)) {
                                        $amountOfUsers = $row['amountOfUsers'];    
                                    }
                                    echo "<div class='huge'>$amountOfUsers</div>";
                                ?>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT count(cat_id) AS amountOfCategories FROM categories"; 
                                    $query_result = mysqli_query($connection, $query); 
                                    while($row = mysqli_fetch_assoc($query_result)) {
                                        $amountOfCategories = $row['amountOfCategories'];    
                                    }
                                    echo "<div class='huge'>$amountOfCategories</div>";
                                ?>
                                     <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div><!-- /.row -->
            
            <?php
                $query_drafts = "SELECT count(post_id) AS amountOfDrafts FROM posts WHERE post_status = 'draft'"; 
                $query_result_drafts = mysqli_query($connection, $query_drafts);
                while($row = mysqli_fetch_assoc($query_result_drafts)) {
                    $amountOfDrafts = $row['amountOfDrafts'];
                }
            
                $query_unapproves = "SELECT count(comment_id) AS amountOfUnapproves FROM comments WHERE comment_status = 'Unapproved'"; 
                $query_result_unapproves = mysqli_query($connection, $query_unapproves);
                    while($row = mysqli_fetch_assoc($query_result_unapproves)) {
                        $amountOfUnapproves = $row['amountOfUnapproves'];
                    }

                $query_subscribers = "SELECT count(user_id) AS amountOfSubscribers FROM users WHERE user_role = 'Subscriber'"; 
                $query_result_subscribers = mysqli_query($connection, $query_subscribers);
                    while($row = mysqli_fetch_assoc($query_result_subscribers)) {
                        $amountOfSubscribers = $row['amountOfSubscribers'];
                    }
            ?>
            
            <div class="row">
                <script type="text/javascript">
                  google.load("visualization", "1.1", {packages:["bar"]});
                  google.setOnLoadCallback(drawChart);
                  function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                      ['Date', 'Total Count'],
                        
                        <?php
                            $element_text = ['Active Posts', 'Pending Posts', 'Active Comments', 'Pending Comments', 'Admin Users', 'Subscriber Users', 'Categories'];
                            $element_count = [$amountOfPosts, $amountOfDrafts, $amountOfComments, $amountOfUnapproves, $amountOfUsers, $amountOfSubscribers, $amountOfCategories];
                            for($i = 0; $i < 7; $i++) {
                                echo "['{$element_text[$i]}'" . ", " . "{$element_count[$i]}],";
                            }
                        
                        ?>
                    ]);

                    var options = {
                      chart: {
                        title: '',
                        subtitle: '',
                      }
                    };

                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                    chart.draw(data, options);
                  }
                </script>
                
                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div><!-- /.row -->
    
        </div><!-- /.container-fluid -->

    </div><!-- /#page-wrapper -->
    
<!-- Include the footer --> 
<?php include('includes/admin_footer.php'); ?>