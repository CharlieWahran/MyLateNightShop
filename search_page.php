<?php
REQUIRE('bdd.php');


session_start();

$user_id = $_SESSION['user_id'];

// NE PAS OUBLIER DE REMETTRE LOCATION LOGIN.PHP ET IF!ISSET()
if(!isset($user_id)) {
    header('location:login.php');
};


if(isset($_POST['add_to_wishlist'])){

   $pid = htmlspecialchars($_POST['pid']);
   $p_name = htmlspecialchars($_POST['p_name']);
   $p_price = htmlspecialchars($_POST['p_price']);
   $p_image = htmlspecialchars($_POST['p_image']);
 
   $check_wishlist_numbers= $pdo->prepare("SELECT * FROM `wishlist` WHERE `name` =:name AND `user_id`=:userid ");
   $check_wishlist_numbers->execute([
       'name'=>$p_name,
       'userid'=>$user_id
       ]);

   $check_cart_numbers= $pdo->prepare("SELECT * FROM `cart` WHERE `name` =:name AND `user_id`=:userid ");
   $check_cart_numbers->execute([
       'name'=>$p_name,
       'userid'=>$user_id
       ]);
   
       if($check_wishlist_numbers->rowCount() > 0){
           $message[]= 'aleady added to wishlist';
       }
       elseif($check_cart_numbers->rowCount() > 0){
           $message[] = 'aleady added to cart';
       }
       else{
           $insert_wishlist = $pdo->prepare("INSERT INTO `wishlist`(`user_id`, `pid`, `name`, `price`, `image`) VALUES(:userid, :pid, :name, :price, :image)");
           $insert_wishlist->execute([
               'userid' => $user_id,
               'pid'=>$pid ,
               'name'=>$p_name,
               'price'=>$p_price,
               'image'=>$p_image 
           ]);
           $message[] = 'added to wishlist';
       }
   
}

 if(isset($_POST['add_to_cart'])){

   $pid = htmlspecialchars($_POST['pid']);
   $p_name = htmlspecialchars($_POST['p_name']);
   $p_price = htmlspecialchars($_POST['p_price']);
   $p_image = htmlspecialchars($_POST['p_image']);
   $p_qty = htmlspecialchars($_POST['p_qty']);

   $check_cart_numbers  = $pdo->prepare("SELECT * FROM `cart` WHERE `name` =:name AND `user_id`=:userid");
   $check_cart_numbers->execute([
       'name'=>$p_name,
       'userid'=>$user_id
       ]);

   if($check_cart_numbers->rowCount() > 0){
       $message[] = 'aleady added to cart';
   }
   else{

       $check_wishlist_numbers= $pdo->prepare("SELECT * FROM `wishlist` WHERE `name` =:name AND `user_id`=:userid ");
       $check_wishlist_numbers->execute([
       'name'=>$p_name,
       'userid'=>$user_id
       ]);


       if($check_wishlist_numbers->rowCount() > 0){
           $delete_wishlist = $pdo->prepare("DELETE FROM `wishlist` WHERE `name` =:name AND `user_id`=:userid");
           $delete_wishlist->execute([
               'name'=>$p_name,
               'userid'=>$user_id
               ]);
   }

     $insert_cart = $pdo->prepare("INSERT INTO `cart`(`user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES (:userid, :pid, :name, :price, :quantity, :image)");
     $insert_cart->execute([
       'userid' => $user_id,
       'pid'=>$pid ,
       'name'=>$p_name,
       'price'=>$p_price,
       'quantity' => $p_qty,
       'image'=>$p_image
       
      
   ]);

   $message[]= 'added to cart!';

   }
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
    
<?php
    REQUIRE('header.php');
?>

<section class="search_form">

   <form action="" method="POST">
      <input type="text" class="box" name="search_box" placeholder="search products...">
      <input type="submit" name="search_btn" value="search" class="btn">
   </form>

</section>


<section class="products" style="padding-top: 0; min-height:100vh;">

<div class="box_container">

   <?php
      if(isset($_POST['search_btn'])){
      $search_box = $_POST['search_box'];
      $select_products = $pdo->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%'");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch()){ 
   ?>

   <form action="" class="box" method="POST">
      <div class="price">$<span><?= $fetch_products['price']; ?>€</span></div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_picture/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="Wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="Panier" class="btn" name="add_to_cart">
   </form>

   <?php
         }
      }else{
         echo '<p class="empty">no result found!</p>';
      }
      
   };
   ?>


</div>

</section>
  
<?php
    REQUIRE('footer.php');
?>

<script src="js/script.js"></script>
</body>
</html>