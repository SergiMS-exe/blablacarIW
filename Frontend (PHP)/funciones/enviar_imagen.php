<?php
$file = $_FILES['imagen'];
// Si es una imagen continuamos, si no, mandamos el error :3

$id = $_POST['id'];

if($file['type'] == 'image/jpg' || $file['type'] == 'image/png' || $file['type'] == 'image/jpeg'){
    $filename= $file['tmp_name'];
    $client_id = "531facc897ea14b"; // AQUI SU CLIENT ID
    $handle = fopen($filename, "r");
    $data = fread($handle, filesize($filename));
    $pvars   = array('image' => base64_encode($data));
    $timeout = 30;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
    $out = curl_exec($curl);
    curl_close ($curl);
    $pms = json_decode($out,true);
    $url="";
    set_error_handler(function() { /* ignore errors */ });
    dns_get_record();
    $url=$pms['data']['link'];
    restore_error_handler();


    if($url!=""){

     echo "<h2>¿Esta es la imagen que quieres subir?</h2>";
     echo "<img src='$url'/>";
     ?>
    <form action="../usuario/edit.php" method="POST">
        <input value="<?php echo $id?>" name="id" type="hidden">
        <input value="<?php echo $url?>" name="foto" type="hidden">
        <input type="hidden" name="modo" value="2">
        <input type="submit" value="Confirmar">
    </form>
    <form action="../usuario/edit.php" method="GET">
        <input type="hidden" value="<?php echo $id?>" name="id">
        <input type="submit" value="Cancelar">
    </form>
        <?php
    }else{
     echo "<h2>Ocurrió un problema :(</h2>";
     echo $pms['data']['error'];  
    } 
}

//header ("Location: ../");
?>
