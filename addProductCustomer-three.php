<?php
session_start();
if (isset($_SESSION['idUser'])) {
    //********************************
    //MODULO:INGRESAR STOCK EN ECOMMERCE
    //USUARIO: DEPÓSITO
    //OBJETIVO: INGRESAR LOS PRODUCTOS QUE ESTAN SALIENDO DE LA DISTRIBUIDORA PARA AGREGARSE A UN ECOMMERCE, A UNA TABLA TEMPORAL EN STATUS PENDIENTE DE CONFIRMAR, MOSTRAR LA LISTA A CONFIRMAR, ELIMINAR PRODUCTOS DE LA LISTA
    //ENTRADAS: BARCODE
    //SALIDAS: DATOS PRODUCTOS, MENSAJES
    //AUTOR: AUSTRY CASTILLO
    //FECHA: SEPTIEMBRE 2024
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
<?php 
    include_once("header.php"); 
    include "functions.php";
    if(isset($_POST['idCustomer'])){
        $data = searchCustomerById($_POST['idCustomer']);
    }else if(isset($_GET['idCustomer'])){
        $data = searchCustomerById($_GET['idCustomer']);
    }

    if(isset($data)){
?>
                <a href="addProductCustomer-one.php?idCustomer=<?=(isset($_POST['idCustomer'])) ? $_POST['idCustomer'] : $_GET['idCustomer']?>" autofocus>Dar salida a otro producto</a>
            </div>
            <h1>Stock por confirmar en ecommerce <?=$data['nameCustomer']?></h1><br>

    <?php
    }
    //INVOCO A LA FUNCIÓN DE BORRAR PRODUCTO
    if(isset($_GET['oper'])&&($_GET['oper']=='del')){
        deleteProductEcommerce($_GET['barcode'],$_GET['idCustomer']);
    }elseif(isset($_GET['oper'])&&($_GET['oper']=='con9fi7rm8-')){//INVOCO A LA FUNCIÓN PARA CONFIRMAR LA SALIDA DE MERCADERÍA A AUTORIZAR A ECOMMERCE
        confirmOperationEcommerce($_GET['idCustomer']);
    }elseif(isset($_POST['barcode'])){//INVOCO FUNCIONES PARA MOSTRAR PRODUCTOS POR CONFIRMAR E INSERTO SI ES EL CASO
        
        $data = searchProductOperationNotConfirmEcommerce($_POST['barcode'],$_POST['idCustomer']);
        if($data!=null){
            $stock =$data['stock'] + $_POST['unid'];
            editProductOperationNotConfirmEcommerce($stock,$_POST['barcode'],$_POST['idCustomer'],date('Y-m-d H:i:s'));
        }else{
            if(($_POST['unid'] == "") || ($_POST['unid'] == 0) || (strlen($_POST['unid']) > 4) ){
                echo "error, debe revisar el valor que intenta ingresar";
            }else{
                $datos = array($_SESSION['idUser'],$_POST['idCustomer'],$_POST['barcode'],date('Y-m-d H:i:s'),$_POST['unid']);
                insertProductEcommerce($datos);
            }
        }
        
    }
    
        
    ?>
           
            <div class="containerMenu">
              
        <table class="table">
            <thead>
                 <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Código de barra</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($_POST['idCustomer'])){
                $data = searchProductsNoConfirmEcommerce($_POST['idCustomer']);
            }else if(isset($_GET['idCustomer'])){
                $data = searchProductsNoConfirmEcommerce($_GET['idCustomer']);
            }
                foreach ($data as $file) {  
                    $data2 = searchProduct($file['barcode']);
                ?>
                <tr>
                <td><?=$file['dateInfo']?></td>
                <td><?=$file['barcode']?></td>
                <td><?=$data2['description']?></td>
                <td><?=$file['stock']?></td>
                <td><a href="#" onclick="if (confirm('¿Estás seguro de que desea borrar <?=$data2['description']?>?')) { window.location.href='addProductCustomer-three.php?oper=del&barcode=<?=$file['barcode']?>&idCustomer=<?=(isset($_POST['idCustomer'])) ? $_POST['idCustomer'] : $_GET['idCustomer']?>'; }">❌</a></td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
              <?php
              if($data){
              ?>
                <a href="#" onclick="if (confirm('¿Estás seguro/a de que desea confirmar el salida de mercadería de la Distribuidora para un ecommerce?\n\n\t- Asegurate de haber revisado muy bien el stock a incluir')) { window.location.href='addProductCustomer-three.php?oper=con9fi7rm8-&idCustomer=<?=(isset($_POST['idCustomer'])) ? $_POST['idCustomer'] : $_GET['idCustomer']?>'; }">Confirmar salida de mercadería para Ecommerce</a>
             <?php } ?>
            </div>
        </div>
    </main>

    
</body>

</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>