<!-- Include the header --> 
<?php include('includes/admin_header.php'); ?>

<?php $active = "posts"; ?>

    <!-- Navigation -->
    <?php include('includes/admin_navigation.php'); ?>

     <div id="page-wrapper">

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Welcome Admin<small>Author</small></h1>  
                </div>
            </div><!-- /.row -->
                
                <?php         
                    if(isset($_GET['source'])) {
                        $source = $_GET['source'];
                    } else {
                        $source = '';
                    }
                
                    switch($source) {
                        case 'add_post':
                        include('includes/add_post.php');
                        break; 
                            
                        case 'edit_post':
                        include('includes/edit_post.php');
                        break; 
                            
                        default:
                        include('includes/view_all_posts.php');
                        break; 
                    }
                ?>
                
        </div><!-- /.container-fluid -->

    </div><!-- /#page-wrapper -->
    
<!-- Include the footer --> 
<?php include('includes/admin_footer.php'); ?>