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
    <title>Admin page</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/admin_style.css"/>
</head>
<body>

    
<?php
REQUIRE('admin_header.php');
?>

<section class="dashboard">

    <h1 class="title">Tableau de bord</h1>

    <div class="box_container">

        <div class="box">
        <?php
            $total_pendings = 0;
            $select_pendings = $pdo->prepare("SELECT * FROM `orders` WHERE order_status = ?");
            $select_pendings->execute(['sent']);
            while($fetch_pendings = $select_pendings->fetch()){
                $total_pendings += $fetch_pendings['total_price'];
            };  
        ?>
        <h3>€<?= $total_pendings; ?></h3>
        <p>Tot. revenus €</p>
        <a href="admin_total_order.php" class="btn">Voir </a>
        </div>

        <div class="box">
        <?php
            $select_orders = $pdo->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount(); 
        ?>
        <h3><?= $number_of_orders; ?></h3>
        <p>Tot. commandes</p>
        <a href="admin_total_order.php" class="btn">Voir</a>
        </div>

        <div class="box">
        <?php
            $select_orders = $pdo->prepare("SELECT * FROM `orders` WHERE `order_status`='processing'");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount(); 
        ?>
        <h3><?= $number_of_orders; ?></h3>
        <p>Com. en cours</p>
        <a href="admin_orders.php" class="btn">Voir</a>
        </div>


        <div class="box">
        <?php
         $select_completed = $pdo->prepare("SELECT * FROM `orders` WHERE `order_status`='sent'");
         $select_completed->execute();
         $number_of_orders_c = $select_completed->rowCount();
      ?>
        <h3><?= $number_of_orders_c; ?></h3>
        <p>Com. envoyées</p>
        <a href="admin_orders_sent.php" class="btn">Voir</a>
        </div>


        <div class="box">
        <?php
            $select_products = $pdo->prepare("SELECT * FROM products");
            $select_products->execute();
            $number_of_products = $select_products->rowCount(); 
        ?>
        <h3><?= $number_of_products; ?></h3>
        <p>Tot. produits</p>
        <a href="admin_products.php" class="btn">Voir</a>
        </div>


        <div class="box">
        <?php
            $select_users = $pdo->prepare("SELECT * FROM users");
            $select_users->execute();
            $number_of_users = $select_users->rowCount(); 
        ?>
        <h3><?= $number_of_users; ?></h3>
        <p>Utilisateur(s)</p>
        <a href="admin_users.php" class="btn">Voir</a>
        </div>


        <div class="box">
        <?php
            $select_message = $pdo->prepare("SELECT * FROM message");
            $select_message->execute();
            $number_of_message = $select_message->rowCount(); 
        ?>
        <h3><?= $number_of_message; ?></h3>
        <p>Tot. Messages</p>
        <a href="admin_contacts.php" class="btn">Voir</a>
        </div>
        
        
    </div>

</section>


<script src="js/script.js"></script>

</body>
</html>