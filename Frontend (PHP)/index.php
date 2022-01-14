<?php
    session_start();
    $res = file_get_contents("http://localhost:3000/");
    $dataUsers = json_decode($res);
    $resViajes = file_get_contents("http://localhost:3000/listaviajes");
    $dataViajes = json_decode($resViajes);

    if(isset($_SESSION['server_msg'])){
        echo $_SESSION['server_msg'];
        unset($_SESSION['server_msg']);
    }
    error_reporting(E_ERROR | E_PARSE);

    include 'includes/header.php';

    include "includes/api_tiempo.php";

    include 'includes/buscador_incidencias.php';
    
    include 'includes/mapa.php';

    include 'includes/usuarios.php';
    
    include 'includes/viajes.php'?>

    <?php include 'includes/footer.php' ?>
