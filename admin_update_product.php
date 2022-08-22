<?php
REQUIRE('bdd.php');

session_start();

// Affichage tableau d'erreurs
$erreurs = [];
// Affichage succès avec un string
$succes = "";


$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)) {
    header('location:login.php');
};

if(isset($_POST['update_product'])){
 
    $pid = $_POST['pid'];
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $category = htmlspecialchars($_POST['category']);
    $details = htmlspecialchars($_POST['details']);

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_picture/'.$image;
    $old_image = $_POST['old_image'];
    
    $update_product = $pdo->prepare("UPDATE `products` SET `name` =:name, `category`=:category, `details` =:details, `price` =:price WHERE `id`=:pid");
    $update_product->execute([
        'name' => $name, 
        'category' => $category, 
        'details' => $details, 
        'price' => $price, 
        'pid' => $pid
    ]);


    $succes = 'image updated succesfully';

    if(!empty($image)){

        if($image_size > 2000000){ 
            $erreurs[] = 'image size is too large';
        }
        else{
            $update_image = $pdo->prepare("UPDATE `products` SET image =:image WHERE id =:pid ");
            $update_image->execute([
                'image' => $image,
                'pid' => $pid
            ]);

        if($update_image){
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('uploaded_picture/'.$old_image);
            $succes = 'image updated succesfully';
            }
        }
    }
}



?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAJ produit</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/admin_style.css"/>
</head>
<body>
    
<?php
REQUIRE('admin_header.php');
?>

<section class="update_product">

    <h1 class="title">Mise à jour produit</h1>

    <?php
        $update_id = $_GET['update'];
        $select_products = $pdo->prepare("SELECT * FROM `products` WHERE id = ?");
        $select_products->execute([$update_id]);
        if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch()){
    ?>
    <form action="" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">

        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">

        <img src="uploaded_picture/<?= $fetch_products['image']; ?>" alt="">

        <input type="text" name="name" placeholder="Nom produit" required class="box" value="<?= $fetch_products['name']; ?>">

        <input type="number" name="price" min="0" placeholder="Prix produit" required class="box" value="<?= $fetch_products['price']; ?>">

        <select name="category" class="box" required>
            <option selected><?= $fetch_products['category']; ?></option>
                <<option value="gateaux">Gateaux</option>
                <option value="bonbon">Bonbons</option>
                <option value="boisson">Boisson</option>
                <option value="alcool">Alcool</option>
                <option value="aperitif">Apéritifs</option>
                <option value="autres">Autres</option>
        </select>
        
        <textarea name="details" required placeholder="details produit " class="box" cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
        <input type="file" name="image" class="box" accepte="image/jpg, image/jpeg, image/png">
        
        <div class="flex-btn">
            <input type="submit" class="btn" value="Mettre à jour" name="update_product">
            <a href="admin_products.php" class="option-btn">retour</a>
        </div>
        
    </form>
    <?php
            }
        }
        else{
            echo'<p class="empty">Aucun produits</p>';
        }
    ?>

    </section>


<script src="js/script.js"></script>

</body>
</html>