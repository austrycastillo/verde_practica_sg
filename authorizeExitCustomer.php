<?php
session_start();
if (isset($_SESSION['idUser'])) {
    //********************************
    //MODULO:AUTORIZAR SALIDAS DE  STOCK PARA ECOMMERCE 
    //USUARIO: ADMIN
    //OBJETIVO: AUTORIZAR LOS NUEVOS STOCK DE UNA TABLA TEMPORAL PARA IMPACTAR EN EL INVENTARIO, MOSTRAR LA LISTA A CONFIRMAR, ELIMINAR PRODUCTOS DE LA LISTA
    //ENTRADAS: BARCODE
    //SALIDAS: DATOS PRODUCTOS, MENSAJES
    //AUTOR: ING. AUSTRY CASTILLO
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
                <?php include_once("header.php");
                include "functions.php"; 
                if(isset($_GET['idCustomer'])){
                    $data = searchCustomerById($_GET['idCustomer']);
                    echo ' <h1>Cliente '.$data['nameCustomer'].'</h1><br>';
                ?>
                <a href="authorizeExitCustomer.php">Buscar otro Ecommerce</a>
                <?php } ?>
            </div>
            <h1>Autorizar Stock por salida para Ecommerce</h1><br>
            

    <?php
    
    //INVOCO A LA FUNCIÓN DE BORRAR PRODUCTO
    if(isset($_GET['oper'])&&($_GET['oper']=='del')&&isset($_GET['idCustomer'])){
        deleteProductEcommerceByAdmin($_GET['barcode'],$_GET['idCustomer']);       
            
        
    }elseif(isset($_GET['oper'])&&($_GET['oper']=='con9fi7rm8-')){//INVOCO A LA FUNCIÓN PARA CONFIRMAR EL INGRESO DE MERCADERÍA A AUTORIZAR
        authorizeOperationEcommerce($_GET['idCustomer']);
    }elseif(isset($_GET['oper'])&&isset($_GET['idCustomer'])){
        $dataC = searchProductsNoAuthorizeCustomer($_GET['idCustomer']);
    
        
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
                     $dataC = searchProductsNoAuthorizeCustomer($_GET['idCustomer']);
                      foreach ($dataC as $file) {  
                          $data = searchProduct($file['barcode']);
                          $data2 = searchNameUser($file['idUser']);
                      
                      ?>
 <tr>
                    <td><?=$file['barcode']?></td>
                    <td><?=$data['description']?></td>
                    <td><?=$file['stock']?></td>
                    <td><?=$file['dateInfo']?></td>
                    <td><?=$data2['nameUser']?></td>
                <td><a href="#" onclick="if (confirm('¿Estás seguro de que desea borrar <?=$data['description']?>?')) { window.location.href='authorizeExitCustomer.php?oper=del&barcode=<?=$file['barcode']?>&idCustomer=<?=$_GET['idCustomer']?>'; }">❌</a></td>
                </tr>

                  </tbody>
                 <?php } ?> 
              </table> 
           <?php }else{ ?>      
           <div class="login">
            
            <h1>Selecciona:</h1><br>
            <!-- formulario -->
            <?php
                       
                        $data = searchCustomers();
            ?>
            <form action="authorizeExitCustomer.php" class="loginForm2" method="get">
                <select name="idCustomer" id="cliente" class="lista" autofocus>
                    <?php
                        foreach ($data as $file) {  
                            
                    ?>
                        <option value="<?=$file['idCustomer']?>"><?=$file['nameCustomer']?></option>
                       <?php } ?>
                       <input type="hidden" name="oper" value="search">
                       
                    </select>
                    <button name="buscar" style="cursor: pointer;">Buscar</button>
                    
                </form>
               
      <?php } ?>
            <!--BOTON PARA AUTORIZAR LA SALIDA DE MERCADERIA DE DISTRI A ECOMMERCE-->
            <?php
              if(isset($data) && isset($_GET['idCustomer'])){
              ?>
                   
                 <a href="#" onclick="if (confirm('¿Estás seguro/a de que desea autorizar la salida de mercadería para Ecommerce?\n\n\t- Asegurate de haber revisado muy bien el stock ya que impacta el inventario')) { window.location.href='authorizeExitCustomer.php?oper=con9fi7rm8-&idCustomer=<?=$_GET['idCustomer']?>'; }">Autorizar salida de mercadería para Ecommerce</a>
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