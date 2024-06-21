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


            <form action="" class="loginForm2" method="POST">
                <label for="user">
                    <input type="text" placeholder="Producto x" disabled>
                    <input type="number" name="unid" placeholder="unidades" autofocus>
                    <input type="hidden" name="idProduct">
                    <button name="ingresar">Ingresar</button>
                </label>
            </form>
            <div class="containerMenu">
                <?php
                if (isset($_POST['unid']) && isset($_POST['ingresar']) && ($_POST['unid']>=1)) {
                    echo "
                    Guardando. ".$_POST['unid']." unidades, por favor espere...       
                    <script>
                        // Redirigir después de 3 segundos
                        setTimeout(function () {
                            window.location.href = 'addProductCustomer.php';
                        }, 3000);
                    </script>
                     ";
                // Detener la ejecución del script PHP
                exit();
                }elseif(isset($_POST['unid']) && ($_POST['unid']==0)){
                    echo "debe ingresar cantidad de unidades";
                }
                    ?>

            </div>
        </div>
    </main>

    <script src="js/index.js"></script>
</body>

</html>
<?php } else{
    header("location:./index.php?rta=<p style=color:red;text-align:center;>Debe estar autorizado para ver el contenido</p>");
} ?>