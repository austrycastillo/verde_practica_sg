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
    <style>
        /*TABLA DE INVENTARIO*/
table{
    border-collapse: collapse;
}
table,tr,td{
    border: 1px solid black; /* Define el borde para las celdas */
    padding: 8px; /* Añade espacio dentro de las celdas */
    text-align: left; /* Alinea el texto a la izquierda */
}
.td-title{
    font-weight: bold;
}
    </style>
</head>

<body>
    <header>
        <a href="main.php"><img src="images/logo.jpg" alt="verdemas" class="logo"></a>
    </header>
    <main>
        <div class="login">
            <h1>Lista de productos en inventario</h1>
            <div class="containerMenu">
                <a href="main.php">Volver al menú principal</a><br>
                <table>
                    <tr class="td-title">
                        <td>Marca</td>
                        <td>Producto</td>
                        <td>stock</td>
                    </tr>
                    <tr>
                        <td>Natier</td>
                        <td>Magnesio</td>
                        <td>200</td>
                    </tr>
                    <tr>
                        <td>Natier</td>
                        <td>Vitamina d3</td>
                        <td>24</td>
                    </tr>
                    <tr>
                        <td>Frenzzi</td>
                        <td>Shampoo sin sal</td>
                        <td>115</td>
                    </tr>
                    
                </table>
                               
            </div>
            
        </div>
    </main>

    <script src="js/index.js"></script>
</body>

</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>