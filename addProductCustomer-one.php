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
        var input = document.forms["miFormulario"]["barcode"].value;
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

        // Verificar que el barcode no sea tan corto
        if (input.length < 3) {
            mensajeError.textContent = "El código de barra no puede ser tan corto, por favor verifique.";
            event.preventDefault();
            return false;
        }

        // Si pasa todas las validaciones, limpiar el mensaje de error
        mensajeError.textContent = "";
        return true;
    }
        // Esta función se llama cuando se ingresa el código de barras
        // function enviarFormulario(event) {
        //     if (event.key === 'Enter') {
        //         event.preventDefault(); // Evitar que se envíe el formulario de forma estándar
        //         document.querySelector('.loginForm2').submit(); // Enviar el formulario automáticamente
        //     }
        // }

        window.onload = function() {
            // const codeBarInput = document.querySelector('input[name="barcode"]');
            // codeBarInput.addEventListener('keypress', validarFormulario);
            codeBarInput.focus(); // Asegurar que el campo esté enfocado al cargar la página
        };
    </script>
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
    
?>
<a href="addProductCustomer-three.php?idCustomer=<?=(isset($_POST['idCustomer'])) ? $_POST['idCustomer'] : $_GET['idCustomer']?>">Confirmar / Eliminar salida de mercadería para ecommerce</a>
</div>
        <h1>Dar salida para ecommerce <?=$data['nameCustomer']?></h1><br>
      
       
         <form action="addProductCustomer-two.php" class="loginForm2" method="POST" name="miFormulario" onsubmit="return validarFormulario(event)">
                <label for="user">
                    <input type="text" name="barcode" placeholder="Usa el lector de código de barra" autofocus>
                    <input type="hidden" name="idCustomer" value="<?=$data['idCustomer']?>">
                    <button name="buscar" style="cursor: pointer;">Buscar Producto</button>
                </label>
         </form>
         <p id="mensajeError" class="error" style="color:red;text-align:center"></p> 
        </div>
    </main>
    
    
</body>
</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>