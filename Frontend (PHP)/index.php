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

    include 'includes/header.php';
?>

    <?php include "apiTiempo/index.html"?>

    <?php include 'includes/buscador_incidencias.php' ?>

    <div class="box">
        <div class="header-opciones">
            <a href="incidencias.php" class="btn btn-primary">Mapa de incidencias</a>
        </div>
    </div>

    <h1>Usuarios</h1>

    <div class="header-opciones">
        <a href="usuario/crear_usuario.php" class="btn btn-primary">Crear usuario</a>
    </div>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
        </tr>
            <?php 
                foreach ($data->data->usuarios as $usuario){ ?>
                
                    <tr>
                        <td><?php echo $usuario->nombre; ?></td>
                        <td><?php echo $usuario->apellido; ?></td>
                        <form action="usuario/delete.php" method="POST">
                            <input type="hidden" value="<?php echo $usuario->_id?>" name="id">
                            <th><input type="submit" value="Eliminar"></th>
                        </form>
                        <form action="usuario/edit.php" method="GET">
                            <input type="hidden" value="<?php echo $usuario->_id?>" name="id">
                            <th><input type="submit" value="Editar"></th>
                        </form>
                        <form action="crear_viaje.php" method="GET">
                            <input type="hidden" value="<?php echo $usuario->_id?>" name="id">
                            <th><input type="submit" value="Añadir viaje"></th>
                        </form>
                    </tr>
                
            <?php } ?>
    </table>

    <h1>Viajes</h1>

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
                    <tr>
                        <td><?php echo $viaje->nombre_conductor; ?></td>
                        <td><?php echo $viaje->fecha_salida; ?></td>
                        <td><?php echo $viaje->hora_salida; ?></td>
                        <td><?php echo $viaje->lugar_salida; ?></td>
                        <td><?php echo $viaje->lugar_llegada; ?></td>
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

    <?php include 'includes/footer.php' ?>
