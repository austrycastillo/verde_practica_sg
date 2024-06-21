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
            <!--menu-->
            <div class="containerMenu">
                <a href="main.php">menú</a><br>
            </div>
            <h1>Selecciona un ecommerce</h1><br>
            <!-- formulario -->
            <form action="addProductCustomer.php" class="loginForm2" method="post">
                <select name="cliente" id="cliente" class="lista">
                        <option>verde+</option>
                        <option>kita</option>
                        <option>meval</option>
                    </select>
                    <input type="hidden" name="idCliente" value="2">
                    <button name="buscar">Buscar</button>
                    
                </form>
               
        </div>
    </main>
    
    <script src="js/index.js"></script>
</body>
</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>