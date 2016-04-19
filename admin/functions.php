<?php
    function users_online() {
        global $connection;
        
        $session = session_id();
        $time = time(); //current time
        $time_out_in_seconds = 60; 
        $time_out = $time - $time_out_in_seconds; 

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $query_result = mysqli_query($connection, $query);
        $count = mysqli_num_rows($query_result);

        if($count == 0) {
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");    
        } else {
            mysqli_query($connection, "UPDATE  users_online SET time= '$time' WHERE session = '$session'");
        }

    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
    return $count_user = mysqli_num_rows($users_online_query);
    }

    //Check if the query was success
    function confirm_query($query_result) {
        global $connection; 
        
        if(!$query_result) {
            die("Query Failed. " . mysqli_error($connection));
        }
    }
    
    //Insert new category into the database
    function insert_categories() {
        global $connection;
        
        if(isset($_POST['submit'])) {
            $new_category = mysqli_real_escape_string($connection, $_POST['cat_title']);

            if(!empty($new_category)) {
                $query = "INSERT INTO categories (cat_title) VALUES('$new_category')";
                $query_result = mysqli_query($connection, $query);
            } else {
                echo "This field should not be empty.";
            }
        }                 
    }
    
    //Find and display all categories
    function find_categories() {
        global $connection;
        
        $query = "SELECT * FROM categories"; 
        $query_result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($query_result)) {
            echo "<tr><td>{$row['cat_id']}</td>";
            echo "<td>{$row['cat_title']}</td>";
            echo "<td><a href='categories.php?delete={$row['cat_id']}'>Delete</a></td>";
            echo "<td><a href='categories.php?edit={$row['cat_id']}'>Edit</a></td></tr>";
        }

        /* Empty the resultset. */
        mysqli_free_result($query_result);
    }

    //Delete a specific category
    function delete_categories() {
        global $connection;
        
        if(isset($_GET['delete'])) {
            $delete_category = mysqli_real_escape_string($connection, $_GET['delete']);

            $query = "DELETE FROM categories WHERE cat_id = $delete_category"; 
            $query_result = mysqli_query($connection, $query);
            header('Location: categories.php');
        }
    }

?>