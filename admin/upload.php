<?php include("includes/header.php"); ?>


<?php if(!$session->is_signed_in()){redirect("login.php");} ?>

<?php 
if(isset($_POST['submit'])){

// echo "<pre>";

// print_r($_FILES['file_upload']);

// echo "<pre>";    

$photo = new Photo();

$photo->title = $_POST['title'];
$photo->set_file($_FILES['file_upload']);


if($photo->save_photo()){

    $message = "Photo uploaded succesfully";
} else{

    $message = join("<br>", $photo->errors);
}



}else{
    $message = "";
}


?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            <!--TOP MENU-->

            <?php include("includes/admin_top_nav.php"); ?>


            <!-- ADMIN SIDE NAV-->
        <?php include("includes/admin_side_nav.php"); ?>
           
        </nav>

        <div id="page-wrapper">

            <!-- ADMIN CONTENT AREA - DASHBOARD-->
             <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Upload
                            <small>Subheading</small>
                        </h1>
                        <div class="col-md-6">
                            <?php if(!empty($message)){ ?>

                                <div class="alert alert-warning"><?php echo $message; ?></div>

                            <?php } ?>    
                            <form action="upload.php" enctype="multipart/form-data" method="post">
                                
                                <div class="form-group">
                                    
                                    <input type="text" name="title" class="form-control">

                                </div>

                                 <div class="form-group">
                                    
                                    <input type="file" name="file_upload" class="form-control">
                                    
                                </div>

                                <div class="form-group">
                                    
                                    <input type="submit" name="submit" class="btn btn-primary">
                                    
                                </div>
                            </form>
                        </div>  
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

            <!-- /.navbar-collapse -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>