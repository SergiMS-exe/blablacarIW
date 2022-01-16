<?php
    session_start();
    if (isset($_SESSION['login'])) {
        $user = (array) $_SESSION['usuario'];
        $resViajes = file_get_contents("http://localhost:3000/viajesconductor/".$user['_id']);
        $dataViajes = json_decode($resViajes);

        $resViajesRes = file_get_contents("http://localhost:3000/viajespasajero/".$user['_id']);
        $dataViajesRes = json_decode($resViajesRes);

    } else {
        header('Location: /login.php');
    }
?>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>BlablacarIW - Mi cuenta</title>
</head>

<!--- Datos usuario --->
<h2 style="margin-top:40px; margin-left:10px">Mis datos</h2>
<p style="margin-left:20px">Nombre: <?php echo $user['nombre']." ".$user['apellido']; ?> <p>
<p style="margin-left:20px">Email: <?php echo $user['email']; ?> <p>

<!--- TODO: Foto de perfil --->

<!--- Tabla de viajes como conductor --->
<?php if (isset($dataViajes) && sizeof($dataViajes->data->viajes) > 0) { ?>
    <h3 style="margin-top:40px; margin-left:10px">Mis viajes</h3>
    <table>
        <tr>
            <th>Fecha Salida</th>
            <th>Hora Salida</th>
            <th>Lugar Salida</th>
            <th>Lugar Llegada</th>
        </tr>
            <?php foreach ($dataViajes->data->viajes as $viaje) { ?>                
                <tr>
                    <td><?php echo $viaje->fecha_salida; ?></td>
                    <td><?php echo $viaje->hora_salida; ?></td>
                    <td><?php echo $viaje->lugar_salida; ?></td>
                    <td><?php echo $viaje->lugar_llegada; ?></td>
                </tr>
            <?php } ?>
    </table>
<?php } else { ?> <h3 style="margin-top:40px; margin-left:10px">No tienes ningún viaje creado.</h3>  <?php } ?>

<!--- Tabla de viajes como pasajero --->
<?php if (isset($dataViajesRes) && sizeof($dataViajesRes->data->viajes) > 0) { ?>
    <h3 style="margin-top:40px; margin-left:10px">Viajes reservados</h3>
    <table>
        <tr>
            <th>Conductor</th>
            <th>Fecha Salida</th>
            <th>Hora Salida</th>
            <th>Lugar Salida</th>
            <th>Lugar Llegada</th>
        </tr>
            <?php foreach ($dataViajes->data->viajes as $viaje) { ?>                
                <tr>
                    <td><?php echo $viaje->nombre_conductor; ?></td>
                    <td><?php echo $viaje->fecha_salida; ?></td>
                    <td><?php echo $viaje->hora_salida; ?></td>
                    <td><?php echo $viaje->lugar_salida; ?></td>
                    <td><?php echo $viaje->lugar_llegada; ?></td>
                </tr>
            <?php } ?>
    </table>
<?php } else { ?> <h3 style="margin-top:40px; margin-left:10px">No tienes ningún viaje reservado.</h3>  <?php } ?>

<!--- TODO: Boton a conversación --->