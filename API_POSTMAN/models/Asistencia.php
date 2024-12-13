<?php
require_once "connection/Connection.php";

class Asistencia {
    public static function getAll() {
        $db = new Connection();
        
        $query = "
            SELECT 
                asistencias.id_asistencia, 
                asistencias.id_empleado, 
                asistencias.fecha AS fecha_asistencia, 
                asistencias.estado, 
                empleados.nombre AS nombre_empleado, 
                empleados.cargo
            FROM asistencias
            LEFT JOIN empleados ON asistencias.id_empleado = empleados.id_empleado
        ";        
        $resultado = $db->query($query);
        $datos = [];
        
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'id_asistencia' => $row['id_asistencia'],
                    'id_empleado' => $row['id_empleado'],
                    'fecha_asistencia' => $row['fecha_asistencia'],
                    'estado' => $row['estado'],
                    'nombre_empleado' => $row['nombre_empleado'],
                    'cargo' => $row['cargo']
                ];
            } 
            return $datos;
        } //end if
        
        return $datos;
    }
    public static function getWhere($id_asistencia) {
        $db = new Connection();
        $query = "SELECT * FROM asistencias WHERE id_asistencia = $id_asistencia";
        
        $resultado = $db->query($query);
        $datos = [];
        
        if($resultado->num_rows) {
            while($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'id_asistencia' => $row['id_asistencia'],
                    'id_empleado' => $row['id_empleado'],
                    'fecha' => $row['fecha'],
                    'estado' => $row['estado']
                ];
            } //end while
            return $datos;
        } // end if
        
        return $datos;
    } //end getWhere

    public static function insert($id_empleado, $fecha, $estado) {
        $db = new Connection();
        $query = "INSERT INTO asistencias (id_empleado, fecha, estado)
                  VALUES ('".$id_empleado."', '".$fecha."', '".$estado."')";
        
        $db->query($query);
        
        if($db->affected_rows) {
            return TRUE; // Si la inserción fue exitosa
        } //end if
        
        return FALSE; // Si hubo un error
    } //end insert

    public static function update($id_asistencia, $id_empleado, $fecha, $estado) {
        $db = new Connection();
        $query = "UPDATE asistencias SET
                  id_empleado = '".$id_empleado."', fecha = '".$fecha."', estado = '".$estado."' 
                  WHERE id_asistencia = $id_asistencia";
        
        $db->query($query);
        
        if($db->affected_rows) {
            return TRUE; // Si la actualización fue exitosa
        } //end if
        
        return FALSE; // Si hubo un error
    } //end update

    public static function delete($id_asistencia) {
        $db = new Connection();
        $query = "DELETE FROM asistencias WHERE id_asistencia = $id_asistencia";
        
        $db->query($query);
        
        if($db->affected_rows) {
            return TRUE; // Si la eliminación fue exitosa
        } //end if
        
        return FALSE; // Si hubo un error
    } //end delete

} //end class Asistencia
?>
