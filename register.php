<!-- register.php est la page d'inscription du site -->
<?php
// J'importe la connexion à la base de données
REQUIRE('bdd.php');



// Je sécurise les données
if(isset($_POST['submit'])) {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $cpassword = htmlspecialchars($_POST['cpassword']);
    $user_type = htmlspecialchars($_POST['user_type']);


    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_picture/'.$image;

    $select = $pdo->prepare("SELECT * FROM users WHERE email =: email");
    $select->execute([
        'email' => $email
    ]); 

    if($select->rowCount() > 0){
        $erreurs[] = "Email already exists";
    }
    else{
        // Si la confirmation du mot de passe et le mot de passe sont différents
        if($cpassword != $password) {
            $erreurs[] = "Passwords don't match";
        }
        elseif($user_type !== "admin" && $user_type !== "user") {
            $erreurs[] = "Type must be admin or user ";
        }
        else{ 
            $insert = $pdo->prepare("INSERT INTO `users`(`name`, `email`, `password`, `user_type`, `image`) VALUES(:name, :email, :password, :user_type, :image)");
            $insert->execute([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'user_type' => $user_type,
                'image' => $image 
            ]);
            
            if($insert){
                if($image_size >2000000){
                    $erreurs[] = "Image size is too large";
                }
                else{
                    move_uploaded_file($image_tmp_name,$image_folder);
                    $succes = "Successful register";
                    header('location:login.php');
                }
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
    <title>Inscription</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/components.css"/>

    
</head>
<body>
<?php
// Affichage des erreurs, s'il ya erreur un message s'affichera
        if(count($erreurs) > 0) {
            foreach($erreurs as $erreur){
                echo '<div class="erreur">
                <span>'.$erreur.'</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>';
        }
    }
        // else {
        //     echo '<div class="succes">
        //     <span>'.$succes.'</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        // </div>';
        // }
?>


    <!-- Une section est un bloc,on peux y mettre des div -->
    <section class="form_container">
        <!-- Creation du formulaire d'inscripiton -->
        <form action=""  enctype="multipart/form-data" method="POST" > <!-- Enctype permet de télécharger des éléménts dans le site -->
            <h3>Inscrivez-vous !</h3>
            <input type="text" placeholder="pseudo" class="box" name="name" required> <!-- Required participe à la sécurisation,champs requis -->
            <input type="email" placeholder="email" class="box" name="email" required>
            <input type="password" placeholder="Mot de passe" class="box" name="password" required>
            <input type="password" placeholder="Confirmez mot de passe" class="box" name="cpassword" required/>
            <input type="file" placeholder="Photo de profil" class="box" name="image" required accept="image/jpg, image/jpeg, image/png"/>
            <select name="user_type" class="box" required> 
                <option value=""></option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <input type="submit" value="register now" class="btn" name="submit">
            <p>Déjà un compte ? <a href="login.php">Connexion</a></p>
        </form>
    </section>


</body>
</html>