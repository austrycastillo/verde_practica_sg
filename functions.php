<?php
include "conexion.php";
//BORRAR LUEGO SOLO ES A MODO PRUEBAS***************
    // $clave = password_hash(123, PASSWORD_DEFAULT);
    // $sql = "UPDATE user SET password=? WHERE idUser=?";
    // $id=1;
    // $stmt = $conexion->prepare($sql);
    // $stmt->bindParam(1, $clave, PDO::PARAM_STR);
    // $stmt->bindParam(2, $id, PDO::PARAM_INT);
    // $stmt->execute();


//************FUNCIÓN PARA LOGUEARSE************************* */
function loguear($user, $pass)
{
    global $conexion;
    $sql = "SELECT *FROM user WHERE nameUser=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(1, $user, PDO::PARAM_STR);
    if ($stmt->execute()) {
        $data = $stmt->fetch();
        if ($data) {
            $passC = $data['password'];
            if (password_verify($pass, $passC)) {
                session_start();
                $_SESSION['level'] = $data['level'];
                echo $_SESSION['nameUser'] = $data['nameUser'];
                $_SESSION['idUser'] = $data['idUser'];
                header("location:./main.php");
            } else {
                header("location:./index.php?rta=<p style=color:red;text-align:center;>Datos incorrectos</p>");
                //datos incorrectos
            }
        } else {
            header("location:./index.php?rta=<p style=color:red;text-align:center;>Usuario no registrado</p>");
            //no existe dato
        }
    } else {
        header("location:./index.php?rta=<p style=color:red;text-align:center;>ups disculpe tenemos un error, intenta más tarde</p>");
        //error del query
    }
}





/***************FUNCIÓN PARA BUSCAR UN PRODUCTO****************/
function searchProduct($idProduct)
{
    global $conexion;
    $sql = "SELECT *FROM product WHERE idProduct=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(1, $idProduct, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $data = $stmt->fetch();
        if ($data) {           
                echo $data['description'];       
           
        } else {
            header("location:./index.php?rta=<p style=color:red;text-align:center;>Producto no encontrado</p>");
            //no existe dato
        }
    } else {
        header("location:./index.php?rta=<p style=color:red;text-align:center;>ups disculpe tenemos un error, intenta más tarde</p>");
        //error del query
    }
}