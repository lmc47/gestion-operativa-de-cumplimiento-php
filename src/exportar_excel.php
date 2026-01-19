<?php
//archivo de conexion de la db
require '../config/conexion/database.php';

// obtener el ultimo reporte
$res_id = $conn->query("SELECT MAX(id) as ultimo FROM reportes");
$row_id = $res_id->fetch_assoc();
$id = $row_id['ultimo'];

if (!$id) {
    die("No hay reportes para exportar.");
}

// consultar datos del reporte
$reporte = $conn->query("SELECT * FROM reportes WHERE id = $id")->fetch_assoc();

// consulta de de operadores y sus requirimientos 
$operadores = $conn->query("SELECT * FROM operadores WHERE id_reporte = $id");


header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte_Cumplimiento_" . $id . ".xls");
header("Pragma: no-cache");
header("Expires: 0");


?>
<meta charset="utf-8">
<table border="1">
    <tr>
        <th colspan="2" style="background-color: #1e293b; color: white;">REPORTE DE SEGUIMIENTO OPERATIVO N° <?php echo str_pad($id, 5, "0", STR_PAD_LEFT); ?></th>
    </tr>
    <tr>
        <td><b>Unidad Solicitante:</b></td>
        <td><?php echo $reporte['unidad_solicitante']; ?></td>
    </tr>
    <tr>
        <td><b>Fecha:</b></td>
        <td><?php echo $reporte['fecha']; ?></td>
    </tr>
    <tr>
        <td><b>Lugar:</b></td>
        <td><?php echo $reporte['lugar_atencion']; ?></td>
    </tr>
    <tr>
        <td><b>Clima:</b></td>
        <td><?php echo $reporte['clima']; ?></td>
    </tr>
    <tr>
        <td><b>Ejecutor:</b></td>
        <td><?php echo $reporte['ejecutor_nombre']; ?></td>
    </tr>
</table>

<br>

<table border="1">
    <thead>
    <tr style="background-color: #f1f5f9;">
        <th>Item de Seguridad</th>
        <?php
        $nombres_ops = [];
        while($op = $operadores->fetch_assoc()) {
            echo "<th>" . strtoupper($op['nombre_operador']) . "</th>";
            $nombres_ops[] = $op['id'];
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    $items = ["Uso de lentes protectores*", "Uso de Protector Solar*", "Uso de chaleco de identificación", "Pausas Activas 15 min", "Cumplimiento del procedimiento de carga y descarga", "Uso de carrito de transporte", "Verificación del estado de equipo (eléctrica)"];

    foreach($items as $idx => $nombre_item) {
        echo "<tr>";
        echo "<td>$nombre_item</td>";

        foreach($nombres_ops as $op_id) {
            $cumple_query = $conn->query("SELECT cumple FROM cumplimiento WHERE id_operador = $op_id AND item_indice = $idx");
            $c = $cumple_query->fetch_assoc();
            $resultado = ($c['cumple'] == 1) ? 'SI' : 'NO';
            echo "<td align='center'>$resultado</td>";
        }
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<br>
<table border="1">
    <tr>
        <td style="background-color: #f8fafc;"><b>Observaciones:</b></td>
        <td><?php echo $reporte['observaciones']; ?></td>
    </tr>
</table>