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
        <a href="index.php"><img src="images/logo.jpg" alt="verdemas" class="logo"></a>
    </header>
    <main>
        <div class="login">
            <form action="" class="loginForm" method="post">
                <label for="user">
                    <input type="text" name="user" placeholder="Usuario">
                    <input type="password" name="password" placeholder="Contraseña">
                    <button style="cursor: pointer;">Ingresar al sistema</button>
                </label>
            </form>
            <?php
                            include "functions.php";
                            include "conexion.php";

                            if (isset($_POST['user'])) {                               
                                $rta = loguear($_POST['user'], $_POST['password'],$conexion);
                                echo $rta;
                            }
                            if(isset($_GET['rta'])){
                                echo sendMessages($_GET['rta']);
                            }
                            if(isset($_GET['logout']) && $_GET['logout']==true){
                                session_start();//recuperar la sessión para destruirla
                                unset($_SESSION);//borrar el contenido de las variables SESSION
                                session_destroy();//destruir la session
                                setcookie(session_name(),'null');
                                header("location:./index.php?rta=<br><p style=color:green;text-align:center;>Saliste del sistema, nos vemos pronto!</p>");
                                
                            }
                           
                            ?>
                            
        </div>
    </main>
    
    <script src="js/index.js"></script>
</body>
</html>