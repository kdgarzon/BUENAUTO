<?php
    function conectar(){
        $host = "localhost";
        $user = "postgres";
        $pass = "123456";
        $db_name = "concesionario";

        $link = pg_connect("host= $host dbname=$db_name user=$user password=$pass")
        or die('ERROR al conectar a la BD: ' . pg_last_error($link));
        
        //En este caso no se necesita una función separada para seleccionar la BD puesto que,
        //en la función inicial ya se le está indicando al motor la BD con la cual se va a trabajar

        return $link;
    }
?>