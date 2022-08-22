<?php
REQUIRE('bdd.php');

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)) {
    header('location:login.php');
}

if(isset($_POST['add_product'])){

    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $category = htmlspecialchars($_POST['category']);
    $details = htmlspecialchars($_POST['details']);


    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_picture/'.$image;


    $select_products = $pdo->prepare("SELECT * FROM `products` WHERE name = ?" );
    $select_products->execute([$name]);

    if($select_products->rowCount() > 0){
        $erreurs[] = 'product name already exist';
    }
    else{
        $insert_products = $pdo->prepare("INSERT INTO products (name, category, details, price, image) VALUES (:name,:category,:details,:price,:image)");
        $insert_products->execute([
            'name' => $name,
            'category' => $category,
            'details' => $details,
            'price' => $price,
            'image' => $image
        ]);

        if($insert_products){
            if($image_size > 2000000){
                $erreurs[] = 'image size is too large';
            }
            else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $succes = 'new product added ';
            }
        }
    }
}



if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $select_delete_image = $pdo->prepare("SELECT image FROM `products` WHERE id = ?");
    $select_delete_image->execute([$delete_id]);
    $fetch_delete_image = $select_delete_image->fetch();
    unlink('uploaded_picture/'.$fetch_delete_image['image']);

    $delete_products = $pdo->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_products->execute([$delete_id]);

    $delete_wishlist = $pdo->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);

    $delete_cart = $pdo->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);


    header('location:admin_products.php');
 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/admin_style.css"/>
</head>
<body>
    
<?php
REQUIRE('admin_header.php');

?>



<section class="add_products">

<h1 class="title">Ajouter un produit</h1>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="flex">
        <div class="inputBox">
        <input type="text" name="name" class="box" required placeholder="Nom du produit">
        <select name="category" class="box" required>
            <option value="" selected disabled>categorie</option>
                <option value="gateaux">Gateaux</option>
                <option value="bonbon">Bonbons</option>
                <option value="boisson">Boisson</option>
                <option value="alcool">Alcool</option>
                <option value="aperitif">Apéritifs</option>
                <option value="autres">Autres</option>
        </select>
        </div>
        <div class="inputBox">
        <input type="number" min="0" step="0.01" name="price" class="box" required placeholder="prix produit">
        <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
        </div>
    </div>
    <textarea name="details" id="box" required placeholder="details produit" cols="30" row="10" class="box"></textarea>
    <input type="submit" class="btn" value="Ajouter" name="add_product">
</form> 

</section>

<section class="show_products">

    <h1 class="title">Nouveaux ajouts</h1>

    <div class="box_container">

    <?php
        $show_products = $pdo->prepare("SELECT * FROM `products`");
        $show_products->execute();
        if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch()){
    ?>

    <div class="box">
        <div class="price"><?= $fetch_products['price']; ?>€</div>
        <img src="uploaded_picture/<?= $fetch_products['image']; ?>" alt="">
        <div class="name"><?= $fetch_products['name']; ?></div>
        <div class="category"><?= $fetch_products['category']; ?></div>
        <div class="details"><?= $fetch_products['details']; ?></div>
        <div class="flex-btn">
            <a href="admin_update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Mettre à jour</a>
            <a href="admin_products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product ?');">Supprimer</a>
        </div>
    </div>

    <?php       
        }
    }
    else{
        echo '<p class="empty">now products added yet</p>';
    }
    ?>

    </div>

</section>

<script src="js/script.js"></script>

</body>
</html>