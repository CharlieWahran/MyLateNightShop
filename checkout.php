
<?php
REQUIRE('bdd.php');

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)) {
    header('location:login.php');
}

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $address = 'flat no. '. $_POST['flat'] .' '. $_POST['street'] .' '. $_POST['city'] .' '. $_POST['state'] .' '. $_POST['country'] .' - '. $_POST['pin_code'];
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = $pdo->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);

        
   if($cart_query->rowCount() > 0){
    while($cart_item = $cart_query->fetch()){
       $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].' )';
       $sub_total = ($cart_item['price'] * $cart_item['quantity']);
       $cart_total += $sub_total;
    };
};


    $total_products = implode(', ', $cart_products);

    $order_query = $pdo->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
    $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);
 
    if($cart_total == 0){
       $message[] = 'your cart is empty';
    }
    elseif($order_query->rowCount() > 0){
       $message[] = 'order placed already!';
    }
    else{
       $insert_order = $pdo->prepare("INSERT INTO `orders`(`user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`) VALUES(?,?,?,?,?,?,?,?,?)");
       $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);
       $delete_cart = $pdo->prepare("DELETE FROM `cart` WHERE user_id = ?");
       $delete_cart->execute([$user_id]);
       $message[] = 'order placed successfully!';
    }
 
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>


<?php
    REQUIRE('header.php');
?>

<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      $select_cart_items = $pdo->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart_items->execute([$user_id]);
      if($select_cart_items->rowCount() > 0){
         while($fetch_cart_items = $select_cart_items->fetch()){
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span>(<?= '$'.$fetch_cart_items['price'].'/- x '. $fetch_cart_items['quantity']; ?>)</span> </p>
   <?php
    }
   }else{
      echo '<p class="empty">Votre panier est vide!</p>';
   }
   ?>

   <div class="grand-total">Total : <span><?= $cart_grand_total; ?>€</span></div>


</section>

<section class="checkout-orders">

   <form action="" method="POST">

        <h3>Passez votre commande</h3>

    <div class="flex">

        <div class="inputBox">
            <span>Nom Prenom:</span>
            <input type="text" name="name" placeholder="Votre nom et prenom" class="box" required>
        </div>

        <div class="inputBox">
            <span>Numero tel :</span>
            <input type="number" name="number" placeholder="Votre numéro GSM" class="box" required>
        </div>

        <div class="inputBox">
            <span>Email:</span>
            <input type="email" name="email" placeholder="votre email" class="box" required>
        </div>

        <div class="inputBox">
            <span>Methode de paiement:</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Espèces à la livraison</option>
               <option value="credit card">Espèces à la livraison</option>
               <option value="paypal">Paypal</option>
            </select>
        </div>

        <div class="inputBox">
            <span>Adresse 01 :</span>
            <input type="text" name="flat" placeholder="e.g. 11 rue de la Madelaine" class="box" required>
        </div>

        <div class="inputBox">
            <span>Adresse 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box">
        </div>

        <div class="inputBox">
            <span>Ville :</span>
            <input type="text" name="city" placeholder="e.g. Paris" class="box" required>
        </div>

        <div class="inputBox">
            <span>Code postale :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 75000" class="box" required>
        </div>

        <div class="inputBox">
            <span>Pays:</span>
            <input type="text" name="country" placeholder="e.g. France" class="box" required>
        </div>   

    </div>

    <div id="smart-button-container">
      <div style="text-align: center;">
        <div id="paypal-button-container"></div>
      </div>
    </div>
  <script src="https://www.paypal.com/sdk/js?client-id=ATkCh380Jhq79CorIZSbsZmPvR-hwtwFHulTVxuqIm_nhdiW9_atWrxIobgd1DAVYR2-AqE7nIJtlB0S&currency=EUR" data-sdk-integration-source="button-factory"></script>
  <script>
    function initPayPalButton() {
      
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'paypal',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{ 
              "amount": {
                "currency_code": "EUR",
                "value": <?= $cart_grand_total; ?>
              }}]
            
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            
            // Full available details
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

            // Show a success message within this page, e.g.
            const element = document.getElementById('paypal-button-container');
            element.innerHTML = '';
            element.innerHTML = '<h3>Thank you for your payment!</h3>';

            // Or go to another URL:  actions.redirect('thank_you.html');
            
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
  </script>

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>






<?php
    REQUIRE('footer.php');
?>

<script src="js/script.js"></script>
</body>
</html>

