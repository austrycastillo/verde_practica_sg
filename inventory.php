<?php
session_start();
if (isset($_SESSION['idUser'])) {
     //********************************
    //MODULO:LISTA DE INVENTARIO DE MERCADERIA EN DISTRIBUIDORA 
    //USUARIO: ADMIN
    //OBJETIVO: MOSTRAR UN LISTADO DE PRODUCTOS EN DISTRIBUIDORA- BUSCAR POR NOMBRE - BUSCAR SIN STOCK - BUSCAR CON POCO STOCK
    //ENTRADAS: DESCRIPTION, STOCK
    //SALIDAS: DATOS PRODUCTOS, MENSAJES
    //AUTOR: ING. AUSTRY CASTILLO
    //FECHA: JULIO 2024
    //*************************** */
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
    <?php include_once("header.php"); ?>
    </div>
            <h1>Lista de productos en inventario</h1>
            <div class="containerMenu">
                
                <a href="inventory.php">Ver todos los productos</a>
                <a href="inventory.php?poco=true">Ver productos con poco stock</a><br>
                <form action="inventory.php" class="loginForm2" method="POST" name="miFormulario">
                <label for="user">
                    <input type="text" name="texto" placeholder="Filtrar por ...(escribí algo, ej. magnesio)" autofocus>                    
                </label>
             </form><br>
         <p id="mensajeError" class="error" style="color:red;text-align:center"></p> 
                <table>
                    <tr class="td-title">
                        <td>Marca</td>
                        <td>Producto</td>
                        <td>Precio</td>
                        <td>Stock</td>
                    </tr>
                    <?php
                        include "functions.php";
                        if(isset($_POST['texto'])){
                           // echo $_POST['texto'];
                            $data = searchProductByText($_POST['texto']);
                            //var_dump($data);
                           
                        }else if(isset($_GET['poco']) && ($_GET['poco']=='true')){
                            $data = searchProductsShort();
                        }else{
                            $data = searchProducts();
                        }
                            foreach ($data as $file) {  
                            $data2 = searchBrand($file['idBrand']);
                    ?>
                    <tr>
                        <td><?=$data2['nameBrand']?></td>
                        <td><?=$file['description']?></td>
                        <td><?=$file['price']?></td>
                        <td><?=$file['stock']?></td>
                    </tr>
                  <?php }  ?>
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