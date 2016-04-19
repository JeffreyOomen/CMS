<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <form action="search.php" method="post">
        <h4>Blog Search</h4>
        
        <div class="input-group">
            <input type="text" class="form-control" name="search_post">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit" name="submit_post">
                <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
        </div><!-- /.input-group -->
            
        </form> <!-- /.form --> 
    </div>
    
     <!-- Login -->
    <div class="well">
        <form action="includes/login.php" method="post">
        <h4>Login</h4>
        
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Enter username..."> 
        </div><!-- /.input-group -->
           
        <div class="input-group">
            <input type="password" class="form-control" name="password" placeholder="Enter password..."> 
            <span class="input-group-btn">
                <button class="btn btn-primary" name="login" type="submit">Submit</button>
            </span>
        </div><!-- /.input-group -->
            
        </form> <!-- /.form --> 
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        
        <div class="row">
            <?php 
                $query = "SELECT * FROM categories"; 
                $query_result = mysqli_query($connection, $query);
            ?>
            
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php 
                        while($row = mysqli_fetch_assoc($query_result)) {
                            echo "<li><a href='category.php?category={$row['cat_id']}'>{$row['cat_title']}</a></li>";
                        }
                
                        /* Empty the resultset. */
                        mysqli_free_result($query_result);
                    ?>
                </ul>
            </div> <!-- /.col-lg-6 -->
            
        </div><!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <div class="well">
        <h4>Side Widget Well</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium 
           odit aliquam repellat tempore quos aspernatur vero.</p>
    </div>

</div>