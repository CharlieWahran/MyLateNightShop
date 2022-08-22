<?php
REQUIRE('bdd.php');

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)) {
    header('location:login.php');
}



if(isset($_GET['delete'])){

  $delete_id = $_GET['delete'];
  $select = $pdo->prepare("DELETE FROM `message` WHERE id = ?");
  $select->execute([$delete_id]);
  header('location:admin_contacts.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>
    <!-- Ici on importe les font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/admin_style.css"/>
</head>
<body>
    
<?php
REQUIRE('admin_header.php');
?>

  <div class="container">
    <h2>Messages reçus</h2>
      <ul class="responsive-table">
        <li class="table-header">
          <div class="col col-1">Id</div>
          <div class="col col-2">Nom</div>
          <div class="col col-3">Email</div>
          <div class="col col-4">Message</div>
          <div class="col col-5">Action</div>
        </li>
  <?php
            $requete=$pdo->query('SELECT * FROM message '); 
            while($donnees = $requete->fetch()) {
  ?>
    <li class="table-row">
      <div class="col col-1" data-label="Id"><?= $donnees['id'];?></div>
      <div class="col col-2" data-label="Nom"><?= $donnees['name'];?></div>
      <div class="col col-3" data-label="Email"><?= $donnees['email'];?></div>
      <div class="col col-4" data-label="Numero"><?= $donnees['number'];?></div>
      <div class="col col-5" data-label="action"><a href="admin_contacts.php?delete=<?= $donnees['id']; ?>" class="delete-btn2" onclick="return confirm('Delete this message ?');">Supprimer</a></div>
    </li>
    <?php } ?>
    </ul>
</div> 

 
<script src="js/script.js"></script>

</body>
</html>
