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
    <script>
        //validamos el form
    function validarFormulario(event) {
        var input = document.forms["miFormulario"]["unid"].value;
        var mensajeError = document.getElementById("mensajeError");

        // Verificar si el campo está vacío
        if (input === "") {
            mensajeError.textContent = "El campo no puede estar vacío.";
            event.preventDefault();
            return false;
        }

        // Verificar si el valor es cero
        if (input == 0) {
            mensajeError.textContent = "El valor no puede ser cero.";
            event.preventDefault();
            return false;
        }

        // Verificar si el valor es un número válido
        if (!/^[1-9][0-9]*$/.test(input)) {
            mensajeError.textContent = "Solo se permiten números positivos.";
            event.preventDefault();
            return false;
        }

        // Verificar que no carguen excesivos productos
        if (input.length > 4) {
            mensajeError.textContent = "El valor no puede ser tan grande.";
            event.preventDefault();
            return false;
        }

        // Si pasa todas las validaciones, limpiar el mensaje de error
        mensajeError.textContent = "";
        return true;
    }
</script>
</head>

<body>
<?php 
    include_once("header.php"); 
    include "functions.php";
    $data = searchCustomerById($_POST['idCustomer']);
    //echo $_POST['barcode'];
    $data2 = searchProduct($_POST['barcode']);
    if($data){
?>
</div>
            <h1>Dar salida para ecommerce <?=$data['nameCustomer']?></h1><br>


            <form action="addProductCustomer-three.php" class="loginForm2" method="POST" name="miFormulario" onsubmit="return validarFormulario(event)">
                <label for="user">
                    <input type="text" placeholder="<?=$data2['description']?>" disabled>
                    <input type="text" name="unid" placeholder="ingresa las unidades" autofocus maxlength="10" required>
                    <input type="hidden" name="barcode" value="<?=$_POST['barcode'];?>">
                    <input type="hidden" name="idCustomer" value="<?=$_POST['idCustomer']?>">

                    <button name="ingresar" type="submit">Ingresar</button>
                </label>
            </form>
            <p id="mensajeError" class="error" style="color:red;text-align:center"></p> 
<?php
    }
?>
            
        </div>
    </main>

    <script src="js/index.js"></script>
</body>

</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>