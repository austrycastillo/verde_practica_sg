<?php
session_start();
if (isset($_SESSION['idUser'])) {
     //********************************
    //MODULO:INGRESAR STOCK EN DISTRIBUIDORA II
    //USUARIO: DEPÓSITO
    //OBJETIVO: BUSCA EL PRODUCTO POR CÓDIGO DE BARRA, MUESTRA LOS DATOS EN UN FORM, PARA CARGAR EL NUEVO STOCK
    //ENTRADAS: STOCK
    //SALIDAS: MENSAJES
    //AUTOR: AUSTRY CASTILLO
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
    <style>
        /*color para el mensaje de error */
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
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
<?php include_once("header.php"); ?>
            </div>
            <h1>Ingresar stock en distribuidora</h1><br>

    <?php
    include "functions.php";
    //echo $_POST['barcode'];
    $data = searchProduct($_POST['barcode']);
        
    ?>
            <form action="addProductDistri-three.php" class="loginForm2" method="POST" name="miFormulario" onsubmit="return validarFormulario(event)">
                <label for="user">
                    <input type="text" placeholder="<?=$data['description']?>" disabled>
                    <input type="text" name="unid" placeholder="ingresa las unidades" autofocus maxlength="10" required>
                    <input type="hidden" name="barcode" value="<?=$_POST['barcode'];?>">
                    <button name="ingresar" type="submit">Ingresar</button>
                </label>
                <p id="mensajeError" class="error"></p>
            </form>

    
           
        </div>
    </main>

    <script src="js/index.js"></script>
</body>

</html>
<?php } else{
    //si no está autorizado se envía el inicio
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>