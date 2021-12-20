<?php
    session_start();
    $res = file_get_contents("http://localhost:3000/");
    $data = json_decode($res);

    //$res2 = file_get_contents("http://localhost:3000/flickr/search10/Citroen%20c3%202004");
    $res2 = file_get_contents("http://localhost:3000/flickr/searchAPP");
    $data2 = json_decode($res2);

    if(isset($_SESSION['server_msg'])){
        echo $_SESSION['server_msg'];
        unset($_SESSION['server_msg']);
    }

    include './includes/header.php';
?>



    <div class="header-opciones">
        <a href="crear_usuario.php" class="btn btn-primary">Crear usuario</a>
    </div>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
        </tr>
            <?php 
                foreach ($data->data->usuarios as $usuario){ ?>
                
                    <tr>
                        <th><?php echo $usuario->nombre; ?></th>
                        <th><?php echo $usuario->apellido; ?></th>
                        <form action="delete.php" method="POST">
                            <input type="hidden" value="<?php echo $usuario->_id?>" name="id">
                            <th><input type="submit" value="Eliminar"></th>
                        </form>
                        <form action="edit.php" method="GET">
                            <input type="hidden" value="<?php echo $usuario->_id?>" name="id">
                            <th><input type="submit" value="Editar"></th>
                        </form>
                    </tr>
                
            <?php } ?>
    </table>

    
    <?php 
        

        foreach ($data2->photos->photo as $photo){
            $image = 'http://farm'. $photo->farm . '.staticflickr.com/' . $photo->server . '/' . $photo->id . '_' . $photo->secret . '_z.jpg';
            $imageData = base64_encode(file_get_contents($image));
            echo '<img src="data:image/jpeg;base64,'.$imageData.'">';
    ?>
    <?php } ?> 

    <?php include './includes/footer.php' ?>
