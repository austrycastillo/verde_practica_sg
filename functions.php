<?php
include "conexion.php";
//********************************
    //MODULO:FUNCIONES DEL SISTEMA EN GENERAL
    //USUARIO: DEVELOPERS
    //OBJETIVO: EJECUTAR DIFERENTES FUNCIONES AL SER INVOCADAS 
    //ENTRADAS: MULTIPLES
    //SALIDAS: MULTIPLES
    //AUTOR:  ING. AUSTRY CASTILLO
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
function loguear($user, $pass, $conexion)
{
    if (empty($user) || empty($pass)) {
        goIndex662();
        exit;
    }
    //global $conexion;
    try{
        $sql = "SELECT *FROM user WHERE nameUser=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $user, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($data) {
                $info =[
                    $data['password'],
                    $data['level'],
                    $data['nameUser'],
                    $data['idUser']
                ];
               
                verifyPassword($pass, $info,$conexion);
            } else {
                goIndex514();
                //no existe dato
            }
        } else {
            goIndex811();
            error_log("Error ejecutando consulta SQL: " . $sql);
             //error del query
        }
    }catch(Exception $e){
        //echo $e->getMessage();//solo para admin
        error_log("Error en loguear: " . $e->getMessage());
        echo "Error interno, por favor intente más tarde. Si continúa el error por favor contacte con el administrador";
        exit;
    }
}





/**************FUNCIÓN PARA VERIFICAR LA CONTRASEÑA ****************/
function verifyPassword($pass, $info, $conexion)
{
    try{
        if (password_verify($pass, $info[0])) {
            session_start();
            $_SESSION['level'] = $info[1];
            echo $_SESSION['nameUser'] = $info[2];
            $_SESSION['idUser'] = $info[3];
            goMain();//OK
        } else {
            goIndex411();
            //datos incorrectos
        }
    }catch(Exception $e){
        //echo $e->getMessage();//solo para admin
        echo "Error interno, por favor intente más tarde. Si continúa el error por favor contacte con el administrador";
    }
}



/***********FUNCION PARA REDIRIGIR AL MAIN**************/
function goMain()
{
    try{
        header("location:./main.php");
    }catch(Exception $e){
        //echo $e->getMessage();//solo para admin
        echo "Error interno, por favor intente más tarde. Si continúa el error por favor contacte con el administrador";
    }
}




/***********FUNCION PARA REDIRIGIR AL INDEX ERROR 411**************/
function goIndex411()
{
    try{
        header("location:./index.php?rta=411");
    }catch(Exception $e){
        //echo $e->getMessage();//solo para admin
        echo "Error interno, por favor intente más tarde. Si continúa el error por favor contacte con el administrador";
    }
}




/***********FUNCION PARA REDIRIGIR AL INDEX ERROR 514**************/
function goIndex514()
{
    try{
        header("location:./index.php?rta=514");
    }catch(Exception $e){
        //echo $e->getMessage();//solo para admin
        echo "Error interno, por favor intente más tarde. Si continúa el error por favor contacte con el administrador";
    }
}


/***********FUNCION PARA REDIRIGIR AL INDEX ERROR 811**************/
function goIndex811()
{
    try{
        header("location:./index.php?rta=811");           
    }catch(Exception $e){
        //echo $e->getMessage();//solo para admin
        echo "Error interno, por favor intente más tarde. Si continúa el error por favor contacte con el administrador";
    }
}




/***********FUNCION PARA REDIRIGIR AL INDEX ERROR 662**************/
function goIndex662()
{
    try{
        header("location:./index.php?rta=662");          
    }catch(Exception $e){
        //echo $e->getMessage();//solo para admin
        echo "Error interno, por favor intente más tarde. Si continúa el error por favor contacte con el administrador";
    }
}




/***************FUNCIÓN PARA MENSAJES*************************/
function sendMessages($rta)
{
    try{
        switch($rta){
            case 411:
                $message = 'Datos incorrectos';
                break;
            case 514:
                $message = 'Usuario no registrado';
                break;
            case 811:
                $message = 'ups disculpe tenemos un error, intenta más tarde';
                break;
            case 662:
                $message = 'Por favor ingrese usuario y contraseña';
                break;
            default:
                $message = "Error interno, por favor intente más tarde. Si continúa el error por favor contacte con el administrador";
        }
        return '<center style=color:red>'.$message.'</center>';
                 
    }catch(Exception $e){
        //echo $e->getMessage();//solo para admin
        echo "Error interno, por favor intente más tarde. Si continúa el error por favor contacte con el administrador";
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
                <center style='color:red'>Producto no encontrado, por favor intente de vuelta... </center>
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




/***************FUNCIÓN PARA BUSCAR UN NOMBRE DE USUARIO****************/
function searchNameUser($idUser)
{
    global $conexion;
    $data=null;
    try{
        $sql = "SELECT *FROM user WHERE idUser=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $idUser, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $data = $stmt->fetch();
            if ($data) {  
                   //echo "usuario encontrado";                 
            } else {
                echo "
                <center style='color:red'>Usuario no encontrado, por favor intente de vuelta... </center>
               
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





/***************FUNCIÓN PARA BUSCAR LISTADO DE PRODUCTOS EN DEPÓSITO****************/
function searchProducts()
{
    global $conexion;
    $data=null;
    try{
        $sql = "SELECT *FROM product ORDER BY description ASC";
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









/***************FUNCIÓN PARA BUSCAR UN NOMBRE DE MARCA****************/
function searchBrand($idBrand)
{
    global $conexion;
    $data=null;
    try{
        $sql = "SELECT *FROM brand WHERE idBrand=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $idBrand, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $data = $stmt->fetch();
            if ($data) {  
                   //echo "marca  no encontrada";                 
            } else {
                echo "
                <center style='color:red'>Marca no encontrado, por favor intente de vuelta... </center>
               
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


/***************FUNCIÓN PARA BUSCAR UN PRODUCTO POR ALGÚN TEXTO****************/
function searchProductByText($texto)
{
    global $conexion;
    $data=null;
    try{
        $busqueda = '%'.$texto.'%';
        $sql = "SELECT *FROM product WHERE description LIKE :busqueda";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':busqueda',$busqueda, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $data = $stmt->fetchAll();
            if ($data) {  
                   //echo "producto encontrado"; 
                                 
            } else {
                echo "
                <center style='color:red'>Producto no encontrado, por favor intente de vuelta... </center>
                ";
                //no existe dato
            }
        } else {
            echo "
            Error interno, por favor intente más tarde o reporte al administrador... 
           
             ";
            //error del query
        }
        return $data;
    }catch(Exception $e){
        echo $e->getMessage();
    }
}


/***************FUNCIÓN PARA BUSCAR PRODUCTOS QUE TIENEN POCA MERCADERIA****************/
function searchProductsShort()
{
    global $conexion;
    $data=null;
    try{
        $busqueda = 12;
        $sql = "SELECT *FROM product WHERE stock <= 12";
        $stmt = $conexion->prepare($sql);
       
        if ($stmt->execute()) {
            $data = $stmt->fetchAll();

            if ($data) {  
                   //echo "producto encontrado"; 
                                 
            } else {
                echo "
                <center style='color:red'>Producto no encontrado, por favor intente de vuelta... </center>
                ";
                //no existe dato
            }
        } else {
            echo "
            Error interno, por favor intente más tarde o reporte al administrador... 
           
             ";
            //error del query
        }
        //var_dump($data);
       return $data;
    }catch(Exception $e){
        echo $e->getMessage();
    }
}




/***************FUNCIÓN PARA BUSCAR LISTADO DE ECOMMERCE (CLIENTES)****************/
function searchCustomers()
{
    global $conexion;
    $data=null;
    try{
        $sql = "SELECT *FROM customer ORDER BY nameCustomer ASC";
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




/***************FUNCIÓN PARA BUSCAR UN CLIENTE POR ID****************/
function searchCustomerById($idCustomer)
{
    global $conexion;
    $data=null;
    try{
        $sql = "SELECT *FROM customer WHERE idCustomer=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $idCustomer, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $data = $stmt->fetch();
           
            if ($data) {  
                   //echo "marca  no encontrada";                 
            } else {
                echo "
                <center style='color:red'>Marca no encontrado, por favor intente de vuelta... </center>
               
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
        //var_dump($data);
        return $data;
    }catch(Exception $e){
        echo $e->getMessage();
    }
}






/***************FUNCIÓN PARA BUSCAR LISTADO DE PRODUCTOS SIN CONFIRMAR POR DEPÓSITO PARA ECOMMERCE****************/
function searchProductsNoConfirmEcommerce($idCustomer)
{
    global $conexion;
    $data=null;
    try{
        $sql = "SELECT *FROM operationecommerce WHERE idCustomer = ? and authorized = 0 ORDER BY dateInfo DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $idCustomer, PDO::PARAM_INT);
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


/***************FUNCIÓN PARA BUSCAR UN PRODUCTO EN OPERACIONES TEMPORALES DE ECOMMLERCE****************/
function searchProductOperationNotConfirmEcommerce($barcode,$idCustomer)
{
    global $conexion;
    $data = null;
    try{
        $sql = "SELECT *FROM operationecommerce WHERE barcode=? and idCustomer = ? and authorized = 0";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $barcode, PDO::PARAM_INT);
        $stmt->bindParam(2, $idCustomer, PDO::PARAM_INT);
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



/***************FUNCIÓN PARA INSERTAR UN PRODUCTO AL LISTADO TEMPORAL SIN CONFIRMAR POR EL DEPÓSITO PARA ECOMMERCE****************/
function insertProductEcommerce($datos)
{
    global $conexion;
    try{
        $sql = "INSERT INTO operationecommerce (idUser,idCustomer,barcode,dateInfo, stock) VALUES (?,?,?,?,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $datos[0], PDO::PARAM_INT);
        $stmt->bindParam(2, $datos[1], PDO::PARAM_INT);
        $stmt->bindParam(3, $datos[2], PDO::PARAM_STR);
        $stmt->bindParam(4, $datos[3], PDO::PARAM_STR);
        $stmt->bindParam(5, $datos[4], PDO::PARAM_INT);
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



/***************FUNCIÓN PARA ELIMINAR UN PRODUCTO A AUTORIZAR DE ECOMMERCE ****************/
function deleteProductEcommerce($barcode,$idCustomer)
{
    global $conexion;
    try{
        $sql = "DELETE FROM operationecommerce WHERE barcode = ? and idCustomer = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $barcode, PDO::PARAM_INT);
        $stmt->bindParam(2, $idCustomer, PDO::PARAM_INT);
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




/***************FUNCIÓN PARA EDITAR UN PRODUCTO EN OPERACIONES TEMPORALES EN ECOMMERCE****************/
function editProductOperationNotConfirmEcommerce($stock,$barcode,$idCustomer,$dateInfo)
{
    global $conexion;
    try{
        $sql = "UPDATE operationecommerce SET stock = ?,dateInfo = ? WHERE barcode = ? and idCustomer = ? and authorized = 0";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $stock, PDO::PARAM_INT);
        $stmt->bindParam(2, $dateInfo, PDO::PARAM_STR);
        $stmt->bindParam(3, $barcode, PDO::PARAM_INT);
        $stmt->bindParam(4, $idCustomer, PDO::PARAM_INT);
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


/***************FUNCIÓN PARA CONFIRMAR EL LISTADO DE MERCADERIA POR SACAR DE LA DISTRIBUIDORA PARA DAR AL ECOMMERCE EN LISTA TEMPORAL POR DEPO PARA ECOMMERCE****************/
function confirmOperationEcommerce($idCustomer)
{
    global $conexion;
    try{
        $sql = "UPDATE operationecommerce SET authorized = ? WHERE authorized =? and idCustomer = ?";
        $nco = 0;
        $co = 1;
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1,$co, PDO::PARAM_INT);
        $stmt->bindParam(2, $nco, PDO::PARAM_INT);
        $stmt->bindParam(3, $idCustomer, PDO::PARAM_INT);
       
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







/***************FUNCIÓN PARA BUSCAR LISTADO DE PRODUCTOS PARA SALIDA PARA ECOMMERCE SIN AUTORIZAR POR ADMIN****************/
function searchProductsNoAuthorizeCustomer($idCustomer)
{
    global $conexion;
    $data=null;
    try{
        $sql = "SELECT *FROM operationecommerce WHERE authorized = 1 and idCustomer = ? ORDER BY dateInfo DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1,$idCustomer, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $data = $stmt->fetchAll();
            if (!$data) {  
                echo "<center>Sin datos para autorizar</center>";
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




/***************FUNCIÓN PARA ELIMINAR UN PRODUCTO A AUTORIZAR DE ECOMMERCE POR ADMIN ****************/
function deleteProductEcommerceByAdmin($barcode,$idCustomer)
{
    global $conexion;
    try{
        $sql = "DELETE FROM operationecommerce WHERE barcode = ? and idCustomer = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $barcode, PDO::PARAM_INT);
        $stmt->bindParam(2, $idCustomer, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "<div align=center style=color:red>Producto eliminado</div>";
                //no existe dato
            echo "<script>
                // Redirigir después de 1 segundos
                setTimeout(function () {
                    window.location.href = 'authorizeExitCustomer.php?idCustomer=".$idCustomer."&oper=1';
                }, 1000);
            </script>";

        }else{       
            echo "Error interno, por favor intente más tarde o reporte al administrador...";
            //error del query
        }    
    }catch(Exception $e){
        echo $e->getMessage();
    }   
}






/***************FUNCIÓN PARA AUTORIZAR POR ADMIN LA SALIDA DE MERCADERÍA A ECOMMERCE EN LISTA TEMPORAL DESDE DEPO E IMPACTAR EN EL INVENTARIO****************/
function authorizeOperationEcommerce($idCustomer)
{
    global $conexion;
    try{
               
        $sql = "SELECT *FROM operationecommerce WHERE authorized = ? and idCustomer = ?";
        $a = 1;
        $flag = false;
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1,$a, PDO::PARAM_INT);
        $stmt->bindParam(2,$idCustomer, PDO::PARAM_INT);
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
                        if($data2['stock']>=$prod['stock']){
                            $stock = $data2['stock'] - $prod['stock'];
                          
                        //echo $stock."<br>";
                        $sql3="UPDATE product SET stock = ? WHERE barcode =?";
                        $stmt3 = $conexion->prepare($sql3);
                        $stmt3->bindParam(1,$stock, PDO::PARAM_INT);
                        $stmt3->bindParam(2,$prod['barcode'], PDO::PARAM_INT);
                            if ($stmt3->execute()) {
                            //echo "<div align=center style=color:green>Autorizado correctamente, inventario actualizado</div>";
                            $sql4="UPDATE operationecommerce SET authorized = ? WHERE barcode =? and idCustomer = ?";
                            $a=2;
                            $stmt4 = $conexion->prepare($sql4);
                            $stmt4->bindParam(1,$a, PDO::PARAM_INT);
                            $stmt4->bindParam(2,$prod['barcode'], PDO::PARAM_INT);
                            $stmt4->bindParam(3,$idCustomer, PDO::PARAM_INT);
                            if($stmt4->execute())
                                $flag = true;                         
                            }else{       
                                echo "Error interno 3, por favor intente más tarde o reporte al administrador...";
                                //error del query
                            }  
                        }else{
                            echo "<b style='color:red'><center>No tiene suficiente stock para dar salida, por favor verifique</center></b><br><br>";
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
            echo "<div align=center style=color:green>Algunos productos fueron Autorizados correctamente, inventario actualizado</div>";    
    }catch(Exception $e){
        echo $e->getMessage();
    }
    
}