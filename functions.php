<?php
include "conexion.php";
//********************************
    //MODULO:FUNCIONES DEL SISTEMA EN GENERAL
    //USUARIO: DEVELOPERS
    //OBJETIVO: EJECUTAR DIFERENTES FUNCIONES AL SER INVOCADAS 
    //ENTRADAS: MULTIPLES
    //SALIDAS: MULTIPLES
    //AUTOR: AUSTRY CASTILLO
    //FECHA: JUNIO 2024
    //*************************** */


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
    try{
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
    }catch(Exception $e){
        echo $e->getMessage();
    }
}





/***************FUNCIÓN PARA BUSCAR UN PRODUCTO****************/
function searchProduct($barcode)
{
    global $conexion;
    $data=null;
    try{
        $sql = "SELECT *FROM product WHERE barcode=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $barcode, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $data = $stmt->fetch();
            if ($data) {  
                   //echo "producto encontrado";                 
            } else {
                echo "
                Producto no encontrado, por favor intente de vuelta... 
                <script>
                    // Redirigir después de 3 segundos
                    setTimeout(function () {
                        window.location.href = 'addProductDistri-one.php';
                    }, 3000);
                </script>
                 ";
                //no existe dato
            }
        } else {
            echo "
            Error interno, por favor intente más tarde o reporte al administrador... 
            <script>
                // Redirigir después de 3 segundos
                setTimeout(function () {
                    window.location.href = 'main.php';
                }, 3000);
            </script>
             ";
            //error del query
        }
        return $data;
    }catch(Exception $e){
        echo $e->getMessage();
    }
}





/***************FUNCIÓN PARA INSERTAR UN PRODUCTO AL LISTADO TEMPORAL SIN CONFIRMAR POR EL DEPÓSITO****************/
function insertProduct($datos)
{
    global $conexion;
    try{
        $sql = "INSERT INTO operation (idUser,barcode,dateInfo, stock) VALUES (?,?,?,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $datos[0], PDO::PARAM_INT);
        $stmt->bindParam(2, $datos[1], PDO::PARAM_STR);
        $stmt->bindParam(3, $datos[2], PDO::PARAM_STR);
        $stmt->bindParam(4, $datos[3], PDO::PARAM_INT);
        //$stmt->bindParam("issi",$datos[0],$datos[1],$datos[2],$datos[3]);    
        if ($stmt->execute()) {       
                echo "<div align=center style=color:green>producto guardado</div>";      
                //guardado                
        } else {
            echo "Error interno, por favor intente más tarde o reporte al administrador...";
            //error del query
        }
    }catch(Exception $e){
        echo $e->getMessage();
    }
   
}






/***************FUNCIÓN PARA BUSCAR LISTADO DE PRODUCTOS SIN CONFIRMAR POR DEPÓSITO****************/
function searchProductsNoConfirm()
{
    global $conexion;
    $data=null;
    try{
        $sql = "SELECT *FROM operation WHERE authorized = 0 ORDER BY dateInfo DESC";
        $stmt = $conexion->prepare($sql);
        if ($stmt->execute()) {
            $data = $stmt->fetchAll();
            if (!$data) {  
                //echo "error sin datos";
                //no existe dato
            }
        } else {
            echo "Error interno, por favor intente más tarde o reporte al administrador...";
            //error del query
        }
        return $data;   
    }catch(Exception $e){
        echo $e->getMessage();
    }    
}







/***************FUNCIÓN PARA ELIMINAR UN PRODUCTO ****************/
function deleteProduct($barcode)
{
    global $conexion;
    try{
        $sql = "DELETE FROM operation WHERE barcode = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $barcode, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "<div align=center style=color:red>Producto eliminado</div>";
                //no existe dato
        }else{       
            echo "Error interno, por favor intente más tarde o reporte al administrador...";
            //error del query
        }    
    }catch(Exception $e){
        echo $e->getMessage();
    }   
}








/***************FUNCIÓN PARA BUSCAR UN PRODUCTO EN OPERACIONES TEMPORALES****************/
function searchProductOperationNotConfirm($barcode)
{
    global $conexion;
    $data = null;
    try{
        $sql = "SELECT *FROM operation WHERE barcode=? and authorized = 0";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $barcode, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $data = $stmt->fetch();
            
            if (!$data) {  
                //echo "No existe el producto";
                //no existe dato
            }

        } else {
            echo "Error interno, por favor intente más tarde o reporte al administrador...";
            //error del query
        }
        return $data;
    }catch(Exception $e){
        echo $e->getMessage();
    }
}




/***************FUNCIÓN PARA EDITAR UN PRODUCTO EN OPERACIONES TEMPORALES****************/
function editProductOperationNotConfirm($stock,$barcode,$dateInfo)
{
    global $conexion;
    try{
        $sql = "UPDATE operation SET stock = ?,dateInfo = ? WHERE barcode=? and authorized = 0";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $stock, PDO::PARAM_INT);
        $stmt->bindParam(2, $dateInfo, PDO::PARAM_STR);
        $stmt->bindParam(3, $barcode, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // echo "editado";    
        
        } else {
            echo "Error interno, por favor intente más tarde o reporte al administrador...";
            //error del query
        }
    }catch(Exception $e){
        echo $e->getMessage();
    }
    
}






/***************FUNCIÓN PARA CONFIRMAR EL LISTADO DE MERCADERIA POR INGRESAR A LA DISTRIBUIDORA EN LISTA TEMPORAL POR DEPO****************/
function confirmOperationDistri()
{
    global $conexion;
    try{
        $sql = "UPDATE operation SET authorized = ? WHERE authorized =?";
        $nco = 0;
        $co = 1;
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1,$co, PDO::PARAM_INT);
        $stmt->bindParam(2, $nco, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "<div align=center style=color:green>Mercadería confirmada correctamente</div>";            
        } else {
            echo "Error interno, por favor intente más tarde o reporte al administrador...";
            //error del query
        }
    }catch(Exception $e){
        echo $e->getMessage();
    }
    
}






/***************FUNCIÓN PARA AUTORIZAR POR ADMIN EL INGRESO DE MERCADERÍA A DISTRIBUIDORA EN LISTA TEMPORAL DESDE DEPO E IMPACTAR EN EL INVENTARIO****************/
function authorizeOperationDistri()
{
    global $conexion;
    try{
        
        $sql = "SELECT *FROM operation WHERE authorized = ?";
        $a = 1;
        $flag = false;
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1,$a, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $data = $stmt->fetchAll();
            if (!$data) {  
                echo "error sin datos";
                //no existe dato
            }else{
               // echo  $data['stock']."<br>";
                foreach ($data as $prod) {  
                    //echo  $prod['stock']."<br>";
                    $sql2 = "SELECT stock FROM product WHERE barcode = ?";
                    $stmt2 = $conexion->prepare($sql2);
                    $stmt2->bindParam(1,$prod['barcode'], PDO::PARAM_INT);
                    if ($stmt2->execute()) {
                        $data2 = $stmt2->fetch();
                        //echo $data2['stock']."<br>";
                        $stock = $data2['stock'] + $prod['stock'];
                        //echo $stock."<br>";
                        $sql3="UPDATE product SET stock = ? WHERE barcode =?";
                        $stmt3 = $conexion->prepare($sql3);
                        $stmt3->bindParam(1,$stock, PDO::PARAM_INT);
                        $stmt3->bindParam(2,$prod['barcode'], PDO::PARAM_INT);
                        if ($stmt3->execute()) {
                           //echo "<div align=center style=color:green>Autorizado correctamente, inventario actualizado</div>";
                           $sql4="UPDATE operation SET authorized = ? WHERE barcode =?";
                           $a=2;
                           $stmt4 = $conexion->prepare($sql4);
                           $stmt4->bindParam(1,$a, PDO::PARAM_INT);
                           $stmt4->bindParam(2,$prod['barcode'], PDO::PARAM_INT);
                           if($stmt4->execute())
                            $flag = true;                         
                        }else{       
                            echo "Error interno 3, por favor intente más tarde o reporte al administrador...";
                            //error del query
                        }   
                    }else{       
                        echo "Error interno 2, por favor intente más tarde o reporte al administrador...";
                        //error del query
                    }   
                }
            }
        } else {
            echo "Error interno 1, por favor intente más tarde o reporte al administrador...";
            //error del query
        }
        if($flag)
            echo "<div align=center style=color:green>Autorizado correctamente, inventario actualizado</div>";    
    }catch(Exception $e){
        echo $e->getMessage();
    }
    
}






/***************FUNCIÓN PARA BUSCAR LISTADO DE PRODUCTOS A INGRESAR EN DISTRI SIN AUTORIZAR POR ADMIN****************/
function searchProductsNoAuthorize()
{
    global $conexion;
    $data=null;
    try{
        $sql = "SELECT *FROM operation WHERE authorized = 1 ORDER BY dateInfo DESC";
        $stmt = $conexion->prepare($sql);
        if ($stmt->execute()) {
            $data = $stmt->fetchAll();
            if (!$data) {  
                echo "Sin datos para autorizar";
                //no existe dato
            }
        } else {
            echo "Error interno, por favor intente más tarde o reporte al administrador...";
            //error del query
        }
        return $data;   
    }catch(Exception $e){
        echo $e->getMessage();
    }    
}
