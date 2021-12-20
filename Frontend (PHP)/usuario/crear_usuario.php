<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $url = 'http://localhost:3000/users/add';
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);

        $data = array(
            "nombre" => $_POST['nombre'],
            "apellido" => $_POST['apellido'],            
            "email" => $_POST['email'],
            "password" => $_POST['password']
        );

        $json = http_build_query($data);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch); 
        $result = json_decode($output);
        
        $_SESSION['server_msg'] = $result->data->msg;
        
        header('Location: index.php');
    }
?>


<h1>Crear usuario</h1>

<form action="crear_usuario.php" method="POST">
    <input placeholder="nombre" name="nombre">
    <input placeholder="apellido" name="apellido">
    <input placeholder="email" name="email">
    <input placeholder="password" name="password">
    <input type="submit" value="Crear">
</form>


<a href="index.php" class="btn btn-danger">Cancelar</a>