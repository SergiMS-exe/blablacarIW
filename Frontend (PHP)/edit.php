<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $url = 'http://localhost:3000/users/edit';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);

        $data = array(
            "_id" => $_POST['id'],
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
    else {
        $res = file_get_contents("http://localhost:3000/users/edit/".$_GET['id']);
        $data = json_decode($res); 
        include './includes/header.php';
    }
?>

<form action="edit.php" method="POST">
    <input value="<?php echo $data->data->usuario[0]->_id?>" name="id" type="hidden">
    <input value="<?php echo $data->data->usuario[0]->nombre?>" name="nombre">
    <input value="<?php echo $data->data->usuario[0]->apellido?>" name="apellido">
    <input value="<?php echo $data->data->usuario[0]->email?>" name="email">
    <input value="<?php echo $data->data->usuario[0]->password?>" name="password">
    <input type="submit" value="Editar">
</form>

<?php include './includes/footer.php' ?>