<?php
// Affichage des erreurs, s'il ya erreur un message s'affichera
        if(count($message) > 0) {
            foreach($message as $message){
                echo '
                <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>';
        }
    }

?>


<header class="header">

    <div class="flex">

        <a href="home.php" class="logo">MyNight<span>Shop</span></a>

        <nav class="navbar">
            <a href="home.php">Accueil</a>
            <a href="products.php">Produits</a>
            <a href="orders.php">Commandes</a>
            <a href="about.php">A propos</a>
            <a href="contact.php">Contact</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div> 
            <a href="search_page.php" class="fas fa-search"></a>
            <?php
                $count_cart_items = $pdo->prepare("SELECT * FROM `cart`  WHERE `user_id` = ?");
                $count_cart_items->execute([$user_id]);
                $count_wishlist_items = $pdo->prepare("SELECT * FROM `wishlist` WHERE `user_id` = ?");
                $count_wishlist_items->execute([$user_id]);
            ?>

            <a href="wishlist.php"><i class="fas fa-heart"></i></span>(<?= $count_wishlist_items->rowCount(); ?>)</span></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i></span>(<?= $count_cart_items->rowCount(); ?>)</span></a>
            
        </div>

        <div class="profile">
            <?php
            $select_profile = $pdo->prepare("SELECT * FROM `users` WHERE `id`= ?");
            $select_profile->execute([$user_id]);
            $fetch_profile = $select_profile->fetch();
            ?>

            <img src="uploaded_picture/<?= $fetch_profile['image'];?>" alt="profile picture"/>
            <p><?= $fetch_profile['name'];?></p>
            <a href="user_profile_update.php" class="btn">Update profile</a>
            <a href="logout.php" class="delete-btn">logout</a>
            

        </div>

    </div>

</header>