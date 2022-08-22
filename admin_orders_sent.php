<?php
REQUIRE('bdd.php');

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)) {
    header('location:login.php');
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/admin_style.css"/>
</head>
<body>
    
<?php
REQUIRE('admin_header.php');
?>

<div class="container">
    <h2>Commandes traitées</h2>
      <ul class="responsive-table">
        <li class="table-header">
          <div class="col col-1">Id</div>
          <div class="col col-2">Nom</div>
          <div class="col col-3">Numéro</div>
          <div class="col col-4">Email</div>
          <div class="col col-5">Methode Paiement</div>
          <div class="col col-6">Adresse</div>
          <div class="col col-7">Produits</div>
          <div class="col col-8">Prix</div>
          <div class="col col-9">Date commande</div>
        </li>
  <?php

        $requete = $pdo->query("SELECT * FROM `orders` WHERE `order_status`='sent'");
        while($donnees = $requete->fetch()) {
    ?>

<li class="table-row">
      <div class="col col-1" data-label="Id"><?= $donnees['id'];?></div>
      <div class="col col-2" data-label="Nom"><?= $donnees['name'];?></div>
      <div class="col col-3" data-label="Email"><?= $donnees['number'];?></div>
      <div class="col col-4" data-label="Numero"><?= $donnees['email'];?></div>
      <div class="col col-5" data-label="Numero"><?= $donnees['method'];?></div>
      <div class="col col-6" data-label="Numero"><?= $donnees['address'];?></div>
      <div class="col col-7" data-label="Numero"><?= $donnees['total_products'];?></div>
      <div class="col col-7" data-label="Numero"><?= $donnees['total_price'];?></div>
      <div class="col col-7" data-label="Numero"><?= $donnees['placed_on'];?></div>
    </li>
    <?php } ?>
    </ul>
</div> 
<script src="js/script.js"></script>

</body>
</html> 