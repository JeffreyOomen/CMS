<?php 
    include('db.php'); 
    session_start();
?>

<?php
    if(isset($_POST['login'])) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        
        $query = "SELECT * FROM users WHERE username = '$username'";
        $query_result = mysqli_query($connection, $query);
        
        if(!$query_result) {
            die("Query Failed." . mysqli_error($connection));
        }
        
        while($row = mysqli_fetch_assoc($query_result)) {
            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];
        }
        
        //$password = crypt($password, $db_password);

        if(password_verify($password, $db_password)) {
            $_SESSION['username'] = $db_username;
            $_SESSION['user_firstname'] = $db_user_firstname;
            $_SESSION['user_lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
            
            if($db_user_role == 'Admin') {
                header('Location: ../admin');
            } else {
                echo "<p class='alert alert-danger'>You're no admin! You will be redirected!</p>";
                header('Refresh: 3; ../index.php');
            }
            
        } else {
            header('Location: ../index.php');
        }
    }
?>