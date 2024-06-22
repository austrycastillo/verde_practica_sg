<?php
session_start();
if (isset($_SESSION['idUser'])) {
    //********************************
    //MODULO:INGRESAR STOCK EN DISTRIBUIDORA
    //USUARIO: DEPÓSITO
    //OBJETIVO: LEER EL CÓDIGO DE BARRA PARA BUSCAR AUTOMÁTICAMENTE EL PRODUCTO DENTRO DE LA BASE DE DATOS
    //ENTRADAS: BARCODE
    //SALIDAS:
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
</head>
<body>
    <?php include_once("header.php"); ?>
    </div>
        <h1>Ingresar stock en distribuidora</h1><br>
        <script>
        // Esta función se llama cuando se ingresa el código de barras
        function enviarFormulario(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Evitar que se envíe el formulario de forma estándar
                document.querySelector('.loginForm2').submit(); // Enviar el formulario automáticamente
            }
        }

        window.onload = function() {
            const codeBarInput = document.querySelector('input[name="codeBar"]');
            codeBarInput.addEventListener('keypress', enviarFormulario);
            codeBarInput.focus(); // Asegurar que el campo esté enfocado al cargar la página
        };
    </script>
    <!--Form de lectura del código de barra-->
         <form action="addProductDistri-two.php" class="loginForm2" method="POST">
                <label for="user">
                    <input type="text" name="barcode" placeholder="Usa el lector de código de barra" autofocus>
                    <button name="buscar">Buscar Producto</button>
                </label>
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