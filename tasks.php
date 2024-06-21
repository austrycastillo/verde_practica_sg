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
           <h1>Autorizar movimientos de mercadería</h1><br>
            <div class="containerMenu">
                <a href="tasks.php?action=1">Ver Ingresos de mercadería pendientes</a>
                <a href="tasks.php?action=0">Ver salidas  pendientes</a>
                <a href="main.php">Volver al menú principal</a>
                <br>
                <?php
                if(isset($_GET['action']) && $_GET['action'] == 1){
                    echo "aqui hacemos los ingresos...";
                }
                if(isset($_GET['action']) && $_GET['action'] == 0){
                    echo "aqui hacemos las salidas...";
                }
                ?>
            </div>

        </div>
    </main>

    <script src="js/index.js"></script>
</body>

</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>