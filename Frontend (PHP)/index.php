<?php
    session_start();
    $res = file_get_contents("http://localhost:3000/");
    $data = json_decode($res);

    var_dump($_SESSION);

    if(isset($_SESSION['server_msg'])){
        echo $_SESSION['server_msg'];
        unset($_SESSION['server_msg']);
    }

    include './includes/header.php';
?>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
        </tr>
            <?php 
                foreach ($data->data->usuarios as $usuario){ ?>
                <form action="delete.php" method="POST">
                    <tr>
                        <th><?php echo $usuario->nombre; ?></th>
                        <th><?php echo $usuario->apellido; ?></th>
                        <input type="hidden" value="<?php echo $usuario->_id?>" name="id">
                        <th><input type="submit" value="Eliminar"></th>
                    </tr>
                </form>
            <?php } ?>
    </table>

    <?php include './includes/footer.php' ?>
