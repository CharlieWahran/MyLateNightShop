<?php
REQUIRE('bdd.php');


session_start();

$user_id = $_SESSION['user_id'];


if(!isset($user_id)) {
    header('location:login.php');
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

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_wishlist_item = $pdo->prepare("DELETE FROM `wishlist` WHERE id = ?");
    $delete_wishlist_item->execute([$delete_id]);
    header('location:wishlist.php');
}
 
if(isset($_GET['delete_all'])){
    $delete_wishlist_item = $pdo->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist_item->execute([$user_id]);
    header('location:wishlist.php');
}
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wishlist</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
    
<?php
    REQUIRE('header.php');
?>


<section class="wishlist">

   <h1 class="title">Produits ajouté</h1>

   <div class="box_container">

   <?php
      $grand_total = 0;
      $select_wishlist = $pdo->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
      $select_wishlist->execute([$user_id]);
      if($select_wishlist->rowCount() > 0){
        while($fetch_wishlist = $select_wishlist->fetch()){ 
   ?>
   
   <form action="" method="POST" class="box">
      <a href="wishlist.php?delete=<?= $fetch_wishlist['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from wishlist?');"></a>
      <a href="view_page.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_picture/<?= $fetch_wishlist['image']; ?>" alt="">
      <div class="name"><?= $fetch_wishlist['name']; ?></div>
      <div class="price">$<?= $fetch_wishlist['price']; ?>/-</div>
      <input type="number" min="1" value="1" class="qty" name="p_qty">
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_wishlist['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_wishlist['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_wishlist['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
   </form>

   <?php
       $grand_total += $fetch_wishlist['price'];
       }
    }else{
      echo '<p class="empty">your wishlist is empty</p>';
    }
   ?>
   </div>

   <div class="wishlist_total">
      <p>Total : <span><?= $grand_total; ?>€</span></p>
      <a href="products.php" class="option-btn">continuez votre shopping</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>">Tout supprimer</a>
     
   </div>

</section>







    
<?php
    REQUIRE('footer.php');
?>

<script src="js/script.js"></script>
</body>
</html>