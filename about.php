<?php
REQUIRE('bdd.php');


session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
    
<?php
    REQUIRE('header.php');
?>


<section class="about">

    <div class="row">

        <div class="box">
            <img src="uploaded_picture/website_pic/about.jpeg" alt="">
            <h3>Nos produits</h3>
            <p>Nous vous offrons les meilleurs produits pour vos envies de fin de soirée. Ce dont vous avez envie, nous l'avons probablement !
               Nos produits sont de qualité et sont conservé dans les meilleurs conditions pour le bonheur de nos clients
            </p>
            <a href="contact.php" class="btn">Nous contacter</a>
        </div>

        <div class="box">
            <img src="uploaded_picture/website_pic/services.jpeg" alt="">
            <h3>Nos services</h3>
            <p>Nous sommes ouverts toute la nuit pour vous satisfaire.
               Les livraisons sont assurées par notre équipe et sont bien prises en charge. Nous vous envoyons toutes les informations par SMS (confirmation, délai de livraison, etc.).</p>
            <a href="Home.php" class="btn">La boutique</a>
        </div>

    </div>

</section>

<section class="reviews">

<h1 class="title">Avis client</h1>

<div class="box_container">

   <div class="box">
      <img src="" alt="">
      <p>Simple , rapide et livraison rapide</p>
      <div class="stars">
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star-half-alt"></i>
      </div>
      <h3>John john</h3>
   </div>

   <div class="box">
      <img src="" alt="">
      <p> large choix de produits</p>
      <div class="stars">
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
   
      </div>
      <h3>Chips75</h3>
   </div>

   <div class="box">
      <img src="" alt="">
      <p>Equipe au top , toujours à l'écoute</p>
      <div class="stars">
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star"></i>
         <i class="fas fa-star-half-alt"></i>
      </div>
      <h3>Mimicat</h3>
   </div>



</div>








</section>
    
<?php
    REQUIRE('footer.php');
?>

<script src="js/script.js"></script>
</body>
</html>