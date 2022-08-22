<?php
// Affichage des erreurs, s'il ya erreur un message s'affichera
        if(count($message) > 0) {
            foreach($message as $message){
                echo '
                <div class="erreur">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>';
        }
    }

?>


<header class="header">

    <div class="flex">

        <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

        <nav class="navbar">
            <a href="admin_page.php">home</a>
            <a href="admin_products.php">products</a>
            <a href="admin_orders.php">orders</a>
            <a href="admin_users.php">users</a>
            <a href="admin_contacts.php">contact</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div> 
        </div>

        <div class="profile">
            <?php
            $select_profile = $pdo->prepare("SELECT * FROM `users` WHERE `id`= ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch();
            ?>

            <img src="uploaded_picture/<?= $fetch_profile['image'];?>" alt="profile picture"/>
            <p><?= $fetch_profile['name'];?></p>
            <a href="admin_update_profile.php" class="btn">Update profile</a>
            <a href="logout.php" class="delete-btn">logout</a>
            

        </div>

    </div>

</header>