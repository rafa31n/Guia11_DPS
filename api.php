<?php
Header('Access-Control-Allow-Origin: *');
if ($_GET) {
    $comando = $_GET['comando'];
    $servername = "localhost";
    $username = "id21448407_root";
    $password = 'r00tPa$$w0rd';
    $dbname = "id21448407_marketudb";
    // Crear conexión
    $conn = new mysqli(
        $servername,
        $username,
        $password,
        $dbname
    );
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($comando == 'agregar') {
        $nombre = $_GET["nombre"];
        $descripcion = $_GET["descripcion"];
        $preciodecosto = $_GET["precioCosto"];
        $preciodeventa = $_GET["precioVenta"];
        $cantidad = $_GET["cantidad"];
        $fotografia = $_GET["fotografia"];
        $sql = "INSERT INTO productos
         (nombre,descripcion,precioCosto,precioVenta,cantidad,fotografia)
        VALUES ('$nombre', '$descripcion',
        $preciodecosto,$preciodeventa,$cantidad,'$fotografia')";
        if ($conn->query($sql) === TRUE) {
            echo '{"mensaje":"Nuevo registro añadido"}';
        } else {
            echo '{"error: "' . $sql . ' ' . $conn->error . '"}';
        }
    }
    if ($comando == 'editar') {
        $nombre = $_GET["nombre"];
        $descripcion = $_GET["descripcion"];
        $preciodecosto = $_GET["precioCosto"];
        $preciodeventa = $_GET["precioVenta"];
        $cantidad = $_GET["cantidad"];
        $fotografia = $_GET["fotografia"];
        $id = $_GET["id"];
        $sql = "UPDATE productos SET nombre='$nombre',
        descripcion='$descripcion',precioCosto=$preciodecosto,
        precioVenta=$preciodeventa, cantidad=$cantidad, fotografia='$fotografia'
        WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo '{"mensaje":"Registro actualizado"}';
        } else {
            echo '{"error: "' . $sql . ' ' . $conn->error . '"}';
        }
    }
    if ($comando == 'eliminar') {
        $id = $_GET["id"];
        // sql to delete a record
        $sql = "DELETE FROM productos WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo '{"mensaje":"Registro eliminado"}';
        } else {
            echo '{"error: "' . $sql . ' ' . $conn->error . '"}';
        }
    }
    if ($comando == 'listar') {
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // obtener cada uno de los registros y almacenarlos en un vector y luego regresarlos en formato json
            $registros = array();
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " .
                $row["lastname"] . "<br>";
                $registros[$i] = $row;
                $i++;
            }
            echo '{"records":' . json_encode($registros) . '}';
        } else {
            echo '{"records":[]}';
        }
    }
    $conn->close();
}
