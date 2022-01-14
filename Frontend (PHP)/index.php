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

    if(isset($_SESSION['usuario']) && isset($_SESSION['google_login'])){
        $email = $_SESSION['usuario']['email'];

        // Compruebo si el email existe en la BD
        $data = file_get_contents("http://localhost:3000/findUserByEmail/" . $email);
        $user = json_decode($data);

        // Si existe -> me traigo su información y lo guardo
        if (!empty($user->data->usuarios)){
            unset($_SESSION['google_login']);
            unset($user->data->usuarios[0]->password);
            $_SESSION['usuario'] = $user->data->usuarios[0]; 
        }else{
        // Si no existe -> lo inserto en la BD e inicializo sus valores
            header('Location: /funciones/nuevo_usuario.php');
        }
    }

    var_dump($_SESSION);

    include 'includes/header.php';

    include "includes/api_tiempo.php";

    include 'includes/buscador_incidencias.php';
    
    include 'includes/mapa.php';

    include 'includes/usuarios.php';
    
    include 'includes/viajes.php';
    
    include 'includes/footer.php';
    
?>
