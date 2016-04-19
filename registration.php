<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
    
    <?php
        $message = "";
        if(isset($_POST['submit'])) {
            $username = mysqli_real_escape_string($connection, $_POST['username']);
            $email    = mysqli_real_escape_string($connection, $_POST['email']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            
            
            if(!empty($username) && !empty($email) && !empty($password)) {
            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
/*                $query = "SELECT randSalt FROM users";
                $query_result = mysqli_query($connection, $query);

                if(!$query_result) {
                    die("Query Failed." . mysqli_error($connection));
                }

                $row = mysqli_fetch_assoc($query_result);
                $randSalt = $row['randSalt'];
                $password = crypt($password, $randSalt);*/
                
                $query = "INSERT INTO users(username, user_email, user_password, user_role) ";
                $query .= "VALUES('$username', '$email', '$password', 'Subscriber')";
                $query_result = mysqli_query($connection, $query);
                
                if(!$query_result) {
                    die("Query Failed." . mysqli_error($connection));
                }
                
                $message = "<p class='alert alert-success'>User Created. <a href='admin/users.php'>View All Users</a>";
                
            } else {
                $message = "<p class='alert alert-danger'>Please fill in all fields!</p>";
            }
        } 
    ?>

    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
    
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                       <?php echo $message; ?>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

        <hr>

<?php include "includes/footer.php";?>
