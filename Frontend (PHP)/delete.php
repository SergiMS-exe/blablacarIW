<?php 
    session_start();
    $url = 'http://localhost:3000/users/delete';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);

    $data = array(
        "id" => $_POST['id']
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



    