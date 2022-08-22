<?php
REQUIRE('bdd.php');


session_start();

$user_id = $_SESSION['user_id'];

// NE PAS OUBLIER DE REMETTRE LOCATION LOGIN.PHP ET IF!ISSET()
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
    <title>Commandes</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
    
<?php
    REQUIRE('header.php');
?>


<section class="placed-orders">

   <h1 class="title">Commandes passées</h1>

   <div class="box-container">

   <?php
      $select_orders = $pdo->prepare("SELECT * FROM `orders` WHERE `user_id`=:userId");
      $select_orders->execute([
         'userId' => $user_id
      ]);
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch()){ 
   ?>

   <div class="box">
      <p> Commande passé le : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Nom : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> Tel : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> Email : <span><?= $fetch_orders['email']; ?></span> </p>
      <p> Adresse : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Paiement : <span><?= $fetch_orders['method']; ?></span> </p>
      <p> Commande : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Total : <span><?= $fetch_orders['total_price']; ?>€</span> </p>
      <p> Status commande : <span style="color:<?php if($fetch_orders['payement_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['order_status']; ?></span> </p>
   </div>

   <?php
      }
   }else{
      echo '<p class="empty">Pas de commandes passés!</p>';
   }
   ?>

   </div>

</section>


    
<?php
    REQUIRE('footer.php');
?>

<script src="js/script.js"></script>
</body>
</html>