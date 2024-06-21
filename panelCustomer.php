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
            <h1>Lista de clientes</h1>
            <div class="containerMenu">
                <a href="addCustomer.php">Agregar nuevo cliente</a>
                <a href="main.php">Volver al menú principal</a><br>
                <p>verdemás</p>
                <p>kita</p>
                <p>meval</p>                
            </div>
            
        </div>
    </main>

    <script src="js/index.js"></script>
</body>

</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>