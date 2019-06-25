<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()){redirect("login.php");} ?>

<?php 

if(!empty($_GET['id']) && is_numeric($_GET['id'])){

    if(($photo = Photo::find_by_id($_GET['id'])) && $photo->delete_photo()){


        $session->message("The photo with id {$_GET['id']} was removed");

        redirect("../photos.php");

    }else{

        redirect("../photos.php");

    }



}else{

    redirect("../photos.php");

}

?>