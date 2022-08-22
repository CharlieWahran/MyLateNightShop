<!-- LOGIN.PHP est la page permettant de se connecter -->

<?php
// J'importe la connexion à la base de données
REQUIRE('bdd.php');



// Session_start permet de se reconnecter apres un laps de temps
session_start();

// Est ce que le formilaire existe ?
if(isset($_POST['submit'])) {

    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    
    $select = $pdo->prepare("SELECT * FROM `users` WHERE email =:email AND password =:password");
    $select->execute([
        
        'email' => $email,
        'password' => $password
        
    ]);

    $row=$select->fetch();

    if($select->rowCount() > 0){

        if($row['user_type']== 'admin'){
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
        }
        elseif($row['user_type']== 'user'){
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
        }
        else{
            $erreurs[] = "No account found for this email";
        }
    }

    else{
        $erreurs[] = "Incorrect email or password";
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
            <h3>Connectez vous</h3>
            <input type="email" placeholder="Enter your email" class="box" name="email" required>
            <input type="password" placeholder="Enter your password" class="box" name="password" required>
            <input type="submit" value="log now" class="btn" name="submit">
            <p>Pas de compte ? <a href="register.php">Inscription</a></p>
        </form>

    </section>


</body>
</html>