<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtApellidoP=(isset($_POST['txtApellidoP']))?$_POST['txtApellidoP']:"";
$txtApellidoM=(isset($_POST['txtApellidoM']))?$_POST['txtApellidoM']:"";
$txtCorreo=(isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";

$txtFoto=(isset($_FILES['txtFoto']["name"]))?$_FILES['txtFoto']["name"]:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";

$error=array();

$accionAgregar="";
$accionModificar=$accionEliminar=$accionCancelar="disabled";
$mostrarModal=False;

include("../Conexion/conexion.php");
switch($accion){
    case "btnAgregar":

        if($txtNombre ==""){
            $error['Nombre']="Escribe el nombre";
        }
        if($txtApellidoP ==""){
            $error['ApellidoP']="Escribe el Apellido Paterno";
        }
        if($txtApellidoM ==""){
            $error['ApellidoM']="Escribe el Apellido Materno";
        }
        if($txtCorreo ==""){
            $error['Correo']="Escribe el Correo";
        }

        if(count($error)>0){
            $mostrarModal=true;
            break;
        }
        
        $sentencia=$conn->prepare("INSERT INTO  empleado(Nombre, ApellidoP, ApellidoM, Correo, Foto) 
        VALUES (:Nombre, :ApellidoP, :ApellidoM, :Correo, :Foto)");

        $sentencia->bindParam(':Nombre',$txtNombre);
        $sentencia->bindParam(':ApellidoP',$txtApellidoP);
        $sentencia->bindParam(':ApellidoM',$txtApellidoP);
        $sentencia->bindParam(':Correo',$txtCorreo);
        
        $Fecha = new DateTime();
        $nombreArchivo = ($txtFoto!="")?$Fecha->getTimestamp()."_".$_FILES["txtFoto"]["name"]:"imagen.jpg";

        $tmpFoto=$_FILES['txtFoto']["tmp_name"];
        if($tmpFoto!=""){
            move_uploaded_file($tmpFoto,"../Img/".$nombreArchivo);
        }

        $sentencia->bindParam(':Foto',$nombreArchivo);
        $sentencia->execute();
        header('Location: index.php');
    break;
    case "btnModificar":

        $sentencia=$conn->prepare("UPDATE empleado SET
        Nombre=:Nombre, 
        ApellidoP=:ApellidoP, 
        ApellidoM=:ApellidoM, 
        Correo=:Correo WHERE
        id=:id"); 

        $sentencia->bindParam(':Nombre',$txtNombre);
        $sentencia->bindParam(':ApellidoP',$txtApellidoP);
        $sentencia->bindParam(':ApellidoM',$txtApellidoM);
        $sentencia->bindParam(':Correo',$txtCorreo);
        $sentencia->bindParam(':id',$txtID);
        $sentencia->execute();
        
        $Fecha = new DateTime();
        $nombreArchivo = ($txtFoto!="")?$Fecha->getTimestamp()."_".$_FILES["txtFoto"]["name"]:"imagen.jpg";

        $tmpFoto=$_FILES['txtFoto']["tmp_name"];
        if($tmpFoto!=""){
            move_uploaded_file($tmpFoto,"../Img/".$nombreArchivo);
            $sentencia=$conn->prepare("SELECT Foto FROM empleado  
            WHERE id=:id"); 
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();
            $empleado=$sentencia->fetch(PDO::FETCH_LAZY);

            if(isset($empleado["Foto"])){
                if(file_exists("../Img/".$empleado["Foto"])){
                    if($empleado['Foto']!="imagen.jpg"){
                        unlink("../Img/".$empleado["Foto"]);
                    }
                }
            }

            $sentencia=$conn->prepare("UPDATE empleado SET Foto=:Foto WHERE id=:id"); 
            $sentencia->bindParam(':Foto',$nombreArchivo);
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();
        }

        header('Location: index.php');

        break;
    case "btnEliminar":

        $sentencia=$conn->prepare("SELECT Foto FROM empleado  
        WHERE id=:id"); 
        $sentencia->bindParam(':id',$txtID);
        $sentencia->execute();
        $empleado=$sentencia->fetch(PDO::FETCH_LAZY);

        if(isset($empleado["Foto"])&&($empleado['Foto']!="imagen.jpg")){
            if(file_exists("../Img/".$empleado["Foto"])){
                unlink("../Img/".$empleado["Foto"]);
            }
        }
        $sentencia=$conn->prepare("DELETE FROM empleado  
        WHERE id=:id"); 
        $sentencia->bindParam(':id',$txtID);
        $sentencia->execute();
        
        header('Location: index.php');
    break;
    case "btnCancelar":
        header('Location: index.php');
    break;
    case "SELECCIONAR":
        $accionAgregar="disabled";
        $accionModificar=$accionEliminar=$accionCancelar="";
        $mostrarModal=True;

        $sentencia=$conn->prepare("SELECT Foto FROM empleado WHERE id=:id"); 
        $sentencia->bindParam(':id',$txtID);
        $sentencia->execute();
        $empleado=$sentencia->fetch(PDO::FETCH_LAZY);


        $txtFoto=$empleado['Foto'];
        
    break;
}

    $sentencia=$conn->prepare("SELECT * FROM empleado " );
    $sentencia->execute();
    $listaEmpleados=$sentencia->fetchAll(PDO::FETCH_ASSOC);

?>