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
                    <a href="viewCustomer.php" selected>Salida de mercadería para ecommerce</a>
                    <a href="addProductDistri-one.php">Ingresar nuevo stock a distribuidora</a>
                    <a href="addProductDistri-three.php">Confirmar / Eliminar nuevo stock a distribuidora</a>
                    <a href="addSaleShowroom.php" style="pointer-events: none; color: grey;">Registrar venta en tienda</a>
                <!-- menú admin -->
                <?php
                }
                else if($_SESSION['level']==1){
                ?>
                    <a href="authorizeExitCustomer.php">Autorizar salidas de mercadería para Ecommerce</a>
                    <a href="authorizeEntriesDistri.php">Autorizar entradas de mercadería en Distribuidora</a>
                    <a href="inventory.php">Ver inventario de productos</a>
                    <a href="panelCustomer.php" style="pointer-events: none; color: grey;">Ir al panel de Clientes</a>
                    <a href="panelUser.php" style="pointer-events: none; color: grey;">Controlar usuarios</a>
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