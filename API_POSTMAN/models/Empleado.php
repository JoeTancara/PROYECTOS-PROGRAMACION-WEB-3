<?php
    require_once "connection/Connection.php";

    class Empleado {

        public static function getAll() {
            $db = new Connection();
            
            // Consulta para obtener los datos de empleados junto con las asistencias
            $query = "
                SELECT 
                    empleados.id_empleado, 
                    empleados.nombre, 
                    empleados.cargo, 
                    empleados.fecha_ingreso, 
                    asistencias.id_asistencia, 
                    asistencias.fecha AS fecha_asistencia, 
                    asistencias.estado
                FROM empleados
                LEFT JOIN asistencias ON empleados.id_empleado = asistencias.id_empleado
            ";
            
            $resultado = $db->query($query);
            $datos = [];
            
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'id_empleado' => $row['id_empleado'],
                        'nombre' => $row['nombre'],
                        'cargo' => $row['cargo'],
                        'fecha_ingreso' => $row['fecha_ingreso'],
                        'id_asistencia' => $row['id_asistencia'],
                        'fecha_asistencia' => $row['fecha_asistencia'],
                        'estado' => $row['estado']
                    ];
                } 
                return $datos;
            } //end if
            
            return $datos;
        } //end getAll
        

        public static function getWhere($id_empleado) {
            $db = new Connection();
            
            $query = "SELECT * FROM empleados WHERE id_empleado = $id_empleado";
            
            $resultado = $db->query($query);
            $datos = [];
            
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'id_empleado' => $row['id_empleado'],
                        'nombre' => $row['nombre'],
                        'cargo' => $row['cargo'],
                        'fecha_ingreso' => $row['fecha_ingreso']
                    ];
                } // end while
                return $datos;
            } // end if
            
            return $datos;
        } // end getWhere

        public static function insert($nombre, $cargo, $fecha_ingreso) {
            $db = new Connection();
            $query = "INSERT INTO empleados (nombre, cargo, fecha_ingreso)
                      VALUES ('".$nombre."', '".$cargo."', '".$fecha_ingreso."')";
            
            $db->query($query);
            
            if($db->affected_rows) {
                return TRUE; // Si la inserción fue exitosa
            } //end if
            
            return FALSE; // Si hubo un error
        } //end insert
        

        public static function update($id_empleado, $nombre, $cargo, $fecha_ingreso) {
            $db = new Connection();
            $query = "UPDATE empleados SET
                      nombre = '".$nombre."', cargo = '".$cargo."', fecha_ingreso = '".$fecha_ingreso."' 
                      WHERE id_empleado = $id_empleado";
            
            $db->query($query);
            if($db->affected_rows) {
                return TRUE; // Si la actualización fue exitosa
            } //end if
            
            return FALSE; // Si hubo un error
        } //end update
        

        public static function delete($id_empleado) {
            $db = new Connection();
            $query = "DELETE FROM empleados WHERE id_empleado = $id_empleado";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE; // Si la eliminación fue exitosa
            } //end if            
            return FALSE; // Si hubo un error
        } //end delete
        

    }//end class Client