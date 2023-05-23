<?php

    define ('ABSPATH' , dirname(__FILE__).'/');

    //** Faz a conexão com o banco de dados **
    if ( empty($_SERVER['SERVER_NAME']) || preg_match('/edu.br/', $_SERVER['SERVER_NAME'])  ) {
        if ( !defined('BASEURL') )
            define('BASEURL', "/".'Athernos/');
        define('DB_NAME', 'athernos');
        define('DB_USER', 'athernos');
        define('DB_PASSWORD', 'qo)Aq1.Z');
        define('DB_HOST', 'localhost');
    }else{
        if ( !defined('BASEURL') )
            define('BASEURL', "/".'Athernos/');
        define('DB_NAME', 'athernos');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
        define('DB_HOST', 'localhost');  
    }
    
?>