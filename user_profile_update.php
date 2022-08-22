<?php
// MARCHE PAS
REQUIRE('bdd.php');

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)) {
    header('location:login.php');
}

if(isset($_POST['update_profile'])){

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    $update_profile = $pdo->prepare("UPDATE users SET name =:name, email =:email WHERE id =:id");
    $update_profile->execute([
        'name' => $name, 
        'email' => $email, 
        'user_id' => $user_id
    ]);

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_picture/'.$image;
    $old_image = $_POST['old_image'];

    if(!empty($image)){
        if($image_size > 2000000){
             $message[] = 'image size is too large';
        }
        else{
            $update_image = $pdo->prepare("UPDATE users SET image = :image WHERE id = :id");
            $update_image->execute([
                'image' => $image, 
                'id' => $user_id]);
            if($update_image){
                move_uploaded_file($image_tmp_name, $image_folder);
                unlink('uploaded_picture/' .$old_image);
                $message = 'image updated successfully!';
            };
           
        };
    };


$old_pass = htmlspecialchars($_POST['old_pass']);
$update_pass = htmlspecialchars($_POST['update_pass']);
$new_pass = htmlspecialchars($_POST['new_pass']);
$confirm_pass = htmlspecialchars($_POST['confirm_pass']);

if(!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass)){
    if($update_pass != $old_pass){
        $message[] = 'old password not matched';
    }
    elseif($new_pass != $confirm_pass){
        $message[] = 'confirm password not matched';
    }
    else{
        $update_pass_query = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update_pass_query->execute([$confirm_pass, $user_id]);
        $message[] = 'password updated messagesfully';
    }
}

};
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/components.css"/>
</head>
<body>
    
<?php
REQUIRE('header.php');
?>

<section class="update-profile">

    <h1 class="title">Mettre à jour les information</h1>  
       
    <form action="" method="POST" enctype="multipart/form-data">

        <img src="uploaded_picture/<?= $fetch_profile['image'];?>" alt="profile picture"/>

        <div class="flex">
            <div class="inputBox">
                <span>Pseudo:</span>
                <input type="text" name="name" value="<?= $fetch_profile['name'];?>" placeholder="username" required class="box">
                <span>email :</span>
                <input type="email" name="email" value="<?= $fetch_profile['email'];?>" placeholder="email" required class="box">
                <span>Photo :</span>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" required class="box">
                <input type="hidden" name="old_image" value="<?= $fetch_profile['image'];?>">
            </div>

            <div class="inputBox">
                <input type="hidden" name="old_pass" value="<?= $fetch_profile['password'];?>">
                <span>Mot de passe :</span>
                <input type="password" name="update_pass" placeholder="enter previous password" required class="box">
                <span>Nouveau Mot de passe :</span>
                <input type="password" name="new_pass" placeholder="enter new password"  class="box">
                <span>Confirmer nouveau mot de passe :</span>
                <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
            </div>
        </div>
    <div class="flex-btn">
        <input type="submit" class="btn" value="Mettre à jour" name="update_profile">
        <a href="home.php" class="option-btn">Retour</a>
    </div>
    
    </form>

<section>





<?php
    REQUIRE('footer.php');
?>


<script src="js/script.js"></script>

</body>
</html>