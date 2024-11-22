<?php
session_start();
if (isset($_SESSION['idUser'])) {
    //********************************
    //MODULO:AUTORIZAR INGRESOS DE  STOCK EN DISTRIBUIDORA 
    //USUARIO: ADMIN
    //OBJETIVO: AUTORIZAR LOS NUEVOS STOCK DE UNA TABLA TEMPORAL PARA IMPACTAR EN EL INVENTARIO, MOSTRAR LA LISTA A CONFIRMAR, ELIMINAR PRODUCTOS DE LA LISTA
    //ENTRADAS: BARCODE
    //SALIDAS: DATOS PRODUCTOS, MENSAJES
    //AUTOR: ING. AUSTRY CASTILLO
    //FECHA: JUNIO 2024
    //*************************** */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verdemas-SG</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
                <?php include_once("header.php"); ?>
                
            </div>
            <h1>Autorizar Stock por ingresar en la distribuidora</h1><br>

    <?php
    include "functions.php";
    //INVOCO A LA FUNCIÓN DE BORRAR PRODUCTO
    if(isset($_GET['oper'])&&($_GET['oper']=='del')){
        deleteProduct($_GET['barcode']);
    }elseif(isset($_GET['oper'])&&($_GET['oper']=='con9fi7rm8-')){//INVOCO A LA FUNCIÓN PARA CONFIRMAR EL INGRESO DE MERCADERÍA A AUTORIZAR
        authorizeOperationDistri();
    }
        
    ?>
           
            <div class="containerMenu">
              
        <table class="table">
            <thead>
                 <tr>
                     <th scope="col">Código de barra</th>
                     <th scope="col">Producto</th>
                     <th scope="col">Cantidad</th>
                     <th scope="col">Fecha y hora</th>
                     <th scope="col">Usuario de carga</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = searchProductsNoAuthorize();
                foreach ($data as $file) {   
                    $data2 = searchProduct($file['barcode']);
                    $data3 = searchNameUser($file['idUser']);
                ?>
                <tr>
                    <td><?=$file['barcode']?></td>
                    <td><?=$data2['description']?></td>
                    <td><?=$file['stock']?></td>
                    <td><?=$file['dateInfo']?></td>
                    <td><?=$data3['nameUser']?></td>
                <td><a href="#" onclick="if (confirm('¿Estás seguro de que desea borrar <?=$data2['description']?>?')) { window.location.href='authorizeEntriesDistri.php?oper=del&barcode=<?=$file['barcode']?>'; }">❌</a></td>
                </tr>
            </tbody>
            <?php } ?>
        </table> 
            <?php
              if($data){
              ?>
                   
                 <a href="#" onclick="if (confirm('¿Estás seguro/a de que desea autorizar el ingreso de mercadería en la Distribuidora?\n\n\t- Asegurate de haber revisado muy bien el stock a incluir ya que impacta el inventario')) { window.location.href='authorizeEntriesDistri.php?oper=con9fi7rm8-'; }">Autorizar ingreso de mercadería en la Distribuidora</a>
            <?php } ?>
            </div>
        </div>
    </main>

    <script src="js/index.js"></script>
</body>

</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>