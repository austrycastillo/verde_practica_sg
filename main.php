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
        <img src="images/logo.jpg" alt="verdemas" class="logo">
    </header>
    <main>
        <div class="login">
            <h1>Austry ¿Qué quieres hacer hoy? 😎</h1>
            <div class="containerMenu">
                <!-- menú depo -->
                <?php
                if($_SESSION['level']==0){
                ?>
                    <a href="addProduct.php">Ingresar nuevo stock a distribuidora</a>
                    <a href="viewCustomer.php">Dar salida de mercadería ecommerce</a>
                    <a href="addSaleShowroom.php">Registrar venta en tienda</a>
                <!-- menú admin -->
                <?php
                }
                else if($_SESSION['level']==1){
                ?>
                    <a href="tasks.php">Autorizar movimientos de mercadería</a>
                    <a href="inventory.php">Ver inventario de productos</a>
                    <a href="panelCustomer.php">Ir al panel de Clientes</a>
                    <a href="panelUser.php">Controlar usuarios</a>
                <?php
                }
                ?>
                <a href="index.php?logout=true">🔒Salir del sistema</a>
            </div>
            
        </div>
    </main>

    <script src="js/index.js"></script>
</body>

</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>