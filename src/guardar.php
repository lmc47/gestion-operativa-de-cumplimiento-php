<?php
// archivo de conexion
require '../config/conexion/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // parte donde se manaje la subida de la firma 
    $ruta_firma = "";
    if (isset($_FILES['ejecutor_firma']) && $_FILES['ejecutor_firma']['error'] == 0) {
        $directorio = "../uploads/firmas/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $extension = pathinfo($_FILES['ejecutor_firma']['name'], PATHINFO_EXTENSION);
        // Guardamos con timestamp para que no se repitan nombres
        $nombre_archivo = "firma_" . time() . "." . $extension;
        $ruta_firma = $directorio . $nombre_archivo;

        move_uploaded_file($_FILES['ejecutor_firma']['tmp_name'], $ruta_firma);
    }

    //insert del reporte
    $stmt = $conn->prepare("INSERT INTO reportes (unidad_solicitante, fecha, tiempo_ejecucion, lugar_atencion, clima, observaciones, ejecutor_nombre, firma_ruta) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");


    $stmt->bind_param("ssssssss",
        $_POST['unidad'],
        $_POST['fecha'],
        $_POST['tiempo'],
        $_POST['lugar'],
        $_POST['clima'],
        $_POST['observaciones'],
        $_POST['ejecutor_nombre'],
        $ruta_firma
    );

    $stmt->execute();
    $id_reporte = $conn->insert_id; // Este es el ID que el usuario vio en el formulario

    // insert  de los operadores y su cumplimiento
    if (isset($_POST['operadores'])) {
        foreach ($_POST['operadores'] as $op) {
            $nombre_op = $op['nombre'];


            $stmt_op = $conn->prepare("INSERT INTO operadores (id_reporte, nombre_operador) VALUES (?, ?)");
            $stmt_op->bind_param("is", $id_reporte, $nombre_op);
            $stmt_op->execute();
            $id_operador = $conn->insert_id;


            if (isset($op['items'])) {
                foreach ($op['items'] as $item_idx => $valor) {
                    $stmt_cumple = $conn->prepare("INSERT INTO cumplimiento (id_operador, item_indice, cumple) VALUES (?, ?, ?)");
                    $stmt_cumple->bind_param("iii", $id_operador, $item_idx, $valor);
                    $stmt_cumple->execute();
                }
            }
        }
    }

    // formeteo del id (Ej: 00005)
    $id_formateado = str_pad($id_reporte, 5, "0", STR_PAD_LEFT);

    echo "<script>
            alert('Reporte N° $id_formateado guardado con éxito'); 
            window.location.href='../index.php';
          </script>";
}
?>