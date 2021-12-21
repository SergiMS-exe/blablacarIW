<?php
    session_start();
    $res = file_get_contents("http://localhost:3000/");
    $data = json_decode($res);
    $resViajes = file_get_contents("http://localhost:3000/listaviajes");
    $dataViajes = json_decode($resViajes);

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

    <div class="header-opciones">
        <a href="crear_viaje.php" class="btn btn-primary">Crear viaje</a>
    </div>

    <table>
        <tr>
            <th>Conductor</th>
            <th>Fecha Salida</th>
            <th>Hora Salida</th>
            <th>Lugar Salida</th>
            <th>Lugar Llegada</th>
        </tr>
            <?php 
                foreach ($dataViajes->data->viajes as $viaje){ ?>
                    <?php
                        $resAux = file_get_contents("http://localhost:3000/users/edit/".$viaje->id_conductor);
                        $dataAux = json_decode($resAux);
                        $conductor = $dataAux->data->usuario[0];
                    ?>                
                    <tr>
                        <th><?php echo $conductor->nombre; ?></th>
                        <th><?php echo $viaje->fecha_salida; ?></th>
                        <th><?php echo $viaje->hora_salida; ?></th>
                        <th><?php echo $viaje->lugar_salida; ?></th>
                        <th><?php echo $viaje->lugar_llegada; ?></th>
                        <form action="delete_viaje.php" method="POST">
                            <input type="hidden" value="<?php echo $viaje->_id?>" name="id">
                            <th><input type="submit" value="Eliminar"></th>
                        </form>
                        <form action="edit_viaje.php" method="GET">
                            <input type="hidden" value="<?php echo $viaje->_id?>" name="id">
                            <th><input type="submit" value="Editar"></th>
                        </form>
                    </tr>
                
            <?php } ?>
    </table>


    <?php include './includes/footer.php' ?>
