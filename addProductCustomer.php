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
    <header>
        <a href="main.php"><img src="images/logo.jpg" alt="verdemas" class="logo"></a>
    </header>
    <main>
    <div class="login">
    <div class="containerMenu">
                <a href="main.php">menú</a><br>
    </div>
        <h1>Dar salida para ecommerce</h1><br>
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
         <form action="addProductCustomerUnid.php" class="loginForm2" method="POST">
                <label for="user">
                    <input type="text" name="codeBar" placeholder="Usa el lector de código de barra" autofocus>
                    <button name="buscar">Buscar Producto</button>
                </label>
         </form>
           
        </div>
    </main>
    
    <script src="js/index.js"></script>
</body>
</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>