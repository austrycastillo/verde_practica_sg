<?php
session_start();
if (isset($_SESSION['idUser'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verdemas-SG</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header>
        <a href="main.php"><img src="images/logo.jpg" alt="verdemas" class="logo"></a>
    </header>
    <main>
    <div class="login">
    <div class="containerMenu">
                <a href="main.php">Volver al menú principal</a><br>
            </div>
        <h1>Vas a agregar un nuevo usuario</h1><br>
         <form action="" class="loginForm2" method="POST">
                <label for="user">
                    <input type="text" name="nameUser" placeholder="Nombre del cliente / empresa">
                    <button name="agregar">Dar de alta</button>
                </label>
            </form>
            <?php
                if(isset($_POST['nameUser']) && isset($_POST['agregar'])){
                    echo "aqui agregamos al nuevo usuario...";
                }
               
                ?>
        </div>
    </main>
    
    <script src="js/index.js"></script>
</body>
</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>