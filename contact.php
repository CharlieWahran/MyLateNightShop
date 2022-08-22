<?php
REQUIRE('bdd.php');

// Affichage tableau d'erreurs
$message=[];

session_start();

$user_id = $_SESSION['user_id'];


if(!isset($user_id)) {
    header('location:login.php');
};


if(isset($_POST['send'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $msg = $_POST['msg'];
    
 
    $select_message = $pdo->prepare("SELECT * FROM `message` WHERE name =:name AND email =:email AND number =:number AND message =:message");
    $select_message->execute([

        'name' => $name, 
        'email' => $email, 
        'number' => $number, 
        'message' => $msg
        
    ]);
 
    if($select_message->rowCount() > 0){
        $message[] = 'already sent message!';
    }
    else{
 
       $insert_message = $pdo->prepare("INSERT INTO `message`(`user_id`, `name`, `email`, `number`, `message`) VALUES(:user_id, :name, :email, :number, :message)");
       $insert_message->execute([
           
        'user_id' => $user_id, 
        'name' => $name,
        'email' => $email,
        'number' => $number,
        'message' => $msg

    ]);
 
    $message[] = 'sent message successfully!';
 
    }
 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
    
<?php
    REQUIRE('header.php');
?>


<section class="contact">

   <h1 class="title">Contacter nous !</h1>

   <form action="" method="POST">
      <input type="text" name="name" class="box" required placeholder="Nom">
      <input type="email" name="email" class="box" required placeholder="Email">
      <input type="number" name="number" min="0" class="box" required placeholder="Telephone">
      <textarea name="msg" class="box" required placeholder="Votre message" cols="30" rows="10"></textarea>
      <input type="submit" value="Envoyer" class="btn" name="send">
   </form>

</section>

<?php
    REQUIRE('footer.php');
?>

<script src="js/script.js"></script>
</body>
</html>