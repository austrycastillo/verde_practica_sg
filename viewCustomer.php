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
<?php include_once("header.php"); ?>
</div>
       
        <div class="login">
            
            <h1>Selecciona un ecommerce</h1><br>
            <!-- formulario -->
            <?php
                        include "functions.php";
                        $data = searchCustomers();
            ?>
            <form action="addProductCustomer-one.php" class="loginForm2" method="post">
                <select name="idCustomer" id="cliente" class="lista" autofocus>
                    <?php
                        foreach ($data as $file) {  
                            
                    ?>
                        <option value="<?=$file['idCustomer']?>"><?=$file['nameCustomer']?></option>
                       <?php } ?>
                    </select>
                    <input type="hidden" name="idCliente" value="2">
                    <button name="buscar" style="cursor: pointer;">Buscar</button>
                    
                </form>
               
        </div>
    </main>
    
    <script src="js/index.js"></script>
</body>
</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>