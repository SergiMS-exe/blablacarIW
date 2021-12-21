<div class="box">
    <form action="./apiIncidencias/buscador_incidencias.php" method="GET">
        <select name="provincia" class="form-control">
            <option value="">Elige Provincia</option>
            <option value="Álava/Araba">Álava/Araba</option>
            <option value="Albacete">Albacete</option>
            <option value="Alicante">Alicante</option>
            <option value="Almería">Almería</option>
            <option value="Asturias">Asturias</option>
            <option value="Ávila">Ávila</option>
            <option value="Badajoz">Badajoz</option>
            <option value="Baleares">Baleares</option>
            <option value="Barcelona">Barcelona</option>
            <option value="Burgos">Burgos</option>
            <option value="Cáceres">Cáceres</option>
            <option value="Cádiz">Cádiz</option>
            <option value="Cantabria">Cantabria</option>
            <option value="Castellón">Castellón</option>
            <option value="Ceuta">Ceuta</option>
            <option value="Ciudad Real">Ciudad Real</option>
            <option value="Córdoba">Córdoba</option>
            <option value="Cuenca">Cuenca</option>
            <option value="Gerona/Girona">Gerona/Girona</option>
            <option value="Granada">Granada</option>
            <option value="Guadalajara">Guadalajara</option>
            <option value="Guipúzcoa/Gipuzkoa">Guipúzcoa/Gipuzkoa</option>
            <option value="Huelva">Huelva</option>
            <option value="Huesca">Huesca</option>
            <option value="Jaén">Jaén</option>
            <option value="La Coruña/A Coruña">La Coruña/A Coruña</option>
            <option value="La Rioja">La Rioja</option>
            <option value="Las Palmas">Las Palmas</option>
            <option value="León">León</option>
            <option value="Lérida/Lleida">Lérida/Lleida</option>
            <option value="Lugo">Lugo</option>
            <option value="Madrid">Madrid</option>
            <option value="Málaga">Málaga</option>
            <option value="Melilla">Melilla</option>
            <option value="Murcia">Murcia</option>
            <option value="Navarra">Navarra</option>
            <option value="Orense/Ourense">Orense/Ourense</option>
            <option value="Palencia">Palencia</option>
            <option value="Pontevedra">Pontevedra</option>
            <option value="Salamanca">Salamanca</option>
            <option value="Segovia">Segovia</option>
            <option value="Sevilla">Sevilla</option>
            <option value="Soria">Soria</option>
            <option value="Tarragona">Tarragona</option>
            <option value="Tenerife">Tenerife</option>
            <option value="Teruel">Teruel</option>
            <option value="Toledo">Toledo</option>
            <option value="Valencia">Valencia</option>
            <option value="Valladolid">Valladolid</option>
            <option value="Vizcaya/Bizkaia">Vizcaya/Bizkaia</option>
            <option value="Zamora">Zamora</option>
            <option value="Zaragoza">Zaragoza</option>
        </select>

        <label for="autonomia">Autonomia</label>
        <input type="text" name="autonomia">

        <label for="carretera">Carretera</label>
        <input type="text" name="carretera">

        <input type="submit" value="Buscar">
    </form>

    <?php
    if (isset($_SESSION['busqueda_incidencias'])){
        if ($_SESSION['busqueda_incidencias'] && $_SESSION['incidencias'] !== null){ // Si se ha hecho una busqueda y hay información para mostrar
            $data = $_SESSION['incidencias'];
            ?>
                <table>
                    <tr>
                        <th>Causa</th>
                        <th>Fecha y hora</th>
                        <th>Provincia</th>
                        <th>Poblacion</th>
                    </tr> 
                    <?php foreach ($data as $i){ ?>
                    <tr>
                        <td><?php echo $i->attributes->causa; ?></td>
                        <td><?php echo $i->attributes->fechahora_; ?></td>
                        <td><?php echo $i->attributes->provincia; ?></td>
                        <td><?php echo $i->attributes->poblacion; ?></td>
                    </tr>
                    <?php }
                    ?>
                </table>
            <?php
    
            unset($_SESSION['busqueda_incidencias']);
            unset($_SESSION['incidencias']);
    
        }
    }
    if(isset($_SESSION['busqueda_incidencias']) && $_SESSION['busqueda_incidencias']){
        echo "No hay resultados para la búsqueda";
        unset($_SESSION['busqueda_incidencias']);
        unset($_SESSION['incidencias']);
    }
    ?>
</div>