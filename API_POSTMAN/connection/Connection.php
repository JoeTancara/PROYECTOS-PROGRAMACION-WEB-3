<?php

class Connection extends mysqli {
    
    function __construct() {
        parent::__construct('localhost', 'root', '', 'sis_asistencia');
        $this->set_charset('utf8');
        
        if ($this->connect_error) {
            die('Error al conectarse a la DB: ' . $this->connect_error);
        } else {
        }
    }
    
}
?>
