<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $url = 'http://localhost:3000/messages/add';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);

        $data = array(
            "from" => $_POST['from'],
            "to" => $_POST['to'],
            "texto" => $_POST['msgTexto'],            
            "conversacion" => $_POST['id_conversacion'],
            //"lugar_llegada" => $_POST['lugar_llegada']
        );

        $json = json_encode($data);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $result = json_decode($output);

        $_SESSION['server_msg'] = $result->data->msg;
        
        header('Location: ../index.php');
    }
    $res = file_get_contents("http://localhost:3000/conversacion?id1=".$_GET['id_local']."&id2=".$_GET['id_ajeno']);
    $data = json_decode($res);
    $resUser = file_get_contents("http://localhost:3000/users/edit/".$_GET['id_emisor']);
    $dataUser = json_decode($res);
    
    // $resViajes = file_get_contents("http://localhost:3000/listaviajes");
    // $dataViajes = json_decode($resViajes);
    $usuarioajeno = $data->data->usuarios[0];
    if ($data->data->usuarios[0]->_id == "61d4499da80ea85a20f949ed")
    {
        $usuarioajeno = $data->data->usuarios[1];
    }
?>

<h1 align="center">Conversación con <?php echo $usuarioajeno->nombre;?></h1>

<table width="75%" align="center">
    
            <?php 
                foreach ($data->data->mensajes as $mensaje){ ?>                
                    <tr>
                        <?php
                            if($mensaje->from == $_GET['id_ajeno']){
                            ?>
                            <td align="left"><?php echo $mensaje->texto ?></td>
                            <?php } else { ?>
                            <td align="right"><?php echo $mensaje->texto ?></td>    
                            <?php } ?>
                    </tr>
                
            <?php } ?>
            <tr>
                <h1><?php echo $data->data->conversacion[0]->_id ?></h1>
            <form action="ver_conversacion.php" method="POST">
                <input type="text" id="msgTexto" name="msgTexto">
                <input type="hidden" value="<?php echo $_GET['id_local']?>" name="from">
                <input type="hidden" value="<?php echo $_GET['id_ajeno']?>" name="to">
                <input type="hidden" value="<?php echo $data->data->conversacion[0]->_id?>" name="id_conversacion">
                <th><input type="submit" value="Añadir viaje"></th>
            </form>
            </tr>
    </table>