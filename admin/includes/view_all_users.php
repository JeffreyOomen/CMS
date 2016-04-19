<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
            <th>Change Role</th>
            <th>Change Role</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    
<?php 
    $query = "SELECT * FROM users"; 
    $query_result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($query_result)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        
        echo "<tr><td>$user_id</td>";
        echo "<td>$username</td>";
        echo "<td>$user_firstname</td>";
        echo "<td>$user_lastname</td>";
        echo "<td>$user_email</td>";
        echo "<td>$user_role</td>";
        
        /*$get_post_query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
        $get_post_query_result = mysqli_query($connection, $get_post_query);
        
        while($row = mysqli_fetch_assoc($get_post_query_result)) {
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        }*/
        
        echo "<td><a href='users.php?change_to_admin=$user_id'>Admin</a></td>";
        echo "<td><a href='users.php?change_to_sub=$user_id'>Subscriber</a></td>";
        echo "<td><a href='users.php?source=edit_user&edit_user=$user_id'>Edit</a></td>";
        echo "<td><a href='users.php?delete=$user_id'>Delete</a></td></tr>";
    }      
?>                     
    </tbody>
</table>

<?php 
    if(isset($_GET['change_to_admin'])) {
        $user_id = $_GET['change_to_admin'];

        $query = "UPDATE users SET user_role = 'Admin' WHERE user_id = $user_id";
        $query_result = mysqli_query($connection, $query);

        confirm_query($query_result);
        header('Location: users.php');
    }

     if(isset($_GET['change_to_sub'])) {
        $user_id = $_GET['change_to_sub'];

        $query = "UPDATE users SET user_role = 'Subscriber' WHERE user_id = $user_id";
        $query_result = mysqli_query($connection, $query);

        confirm_query($query_result);
        header('Location: users.php');
    }

    if(isset($_GET['delete'])) {
        $user_id_delete = $_GET['delete'];
        
        $query = "DELETE FROM users WHERE user_id = $user_id_delete";
        $query_result = mysqli_query($connection, $query);
        
        confirm_query($query_result);
        header('Location: users.php');
    }
?>