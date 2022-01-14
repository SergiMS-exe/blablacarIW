<section class="container">
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
</section>