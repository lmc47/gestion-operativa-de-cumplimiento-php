<?php
// Incluimos la conexión a la base de datos
require_once 'config/conexion/database.php';

$query = "SHOW TABLE STATUS LIKE 'reportes'";
$res = $conn->query($query);
$row = $res->fetch_assoc();
$proximo_id = isset($row['Auto_increment']) ? $row['Auto_increment'] : 1;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Audiovisual - Seguimiento Operativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/index.css"
</head>
<body>

<div class="container py-5" style="max-width: 1100px;">
    <div class="text-center mb-5">
        <h2 class="fw-bold m-0 text-uppercase">Formato de Seguimiento General Operativo de Cumplimiento</h2>
        <p class="text-muted small">ARÉA AUDIOVISUALES</p>
    </div>

    <form action="./src/guardar.php" method="POST" enctype="multipart/form-data">
        <!--Informacion General -->
        <div class="card p-4 shadow-sm">
            <div class="section-title"><i class="bi bi-file-earmark-text"></i> Información General</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="small fw-semibold mb-1">Codigo de Atención</label>
                    <input type="text" class="form-control bg-light border-0 fw-bold text-primary"
                           value="<?= str_pad($proximo_id, 5, "0", STR_PAD_LEFT) ?>" readonly>
                </div>
                <div class="col-md-8">
                    <label class="small fw-semibold mb-1">Unidad Solicitante</label>
                    <input type="text" name="unidad" class="form-control bg-light border-0" placeholder="Nombre de la unidad" required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-semibold mb-1">Fecha</label>
                    <input type="date" name="fecha" class="form-control bg-light border-0">
                </div>
                <div class="col-md-4">
                    <label class="small fw-semibold mb-1">Tiempo de Ejecución</label>
                    <input type="text" name="tiempo" class="form-control bg-light border-0" placeholder="Ej. 3h 30min">
                </div>
                <div class="col-md-4">
                    <label class="small fw-semibold mb-1">Lugar de Atención</label>
                    <input type="text" name="lugar" class="form-control bg-light border-0" placeholder="Ej. AUDITORIO FII">
                </div>
            </div>
        </div>
        <!-- Clima-->
        <div class="card p-4 shadow-sm">
            <div class="section-title"><i class="bi bi-brightness-high"></i> Condiciones Climáticas</div>
            <div class="row g-2 text-center">
                <?php
                $climas = ['Soleado' => 'bi-sun', 'Templado' => 'bi-cloud-sun', 'Nublado' => 'bi-cloud', 'Garúa' => 'bi-cloud-drizzle'];
                foreach($climas as $nombre => $icono): ?>
                    <div class="col-6 col-md-3">
                        <input type="radio" class="btn-check" name="clima" id="clima_<?= $nombre ?>" value="<?= $nombre ?>" <?= $nombre=='Soleado'?'checked':'' ?>>
                        <label class="btn weather-card shadow-sm d-flex flex-column align-items-center justify-content-center h-100" for="clima_<?= $nombre ?>">
                            <i class="bi <?= $icono ?> fs-3 mb-2"></i>
                            <span class="small fw-bold"><?= strtoupper($nombre) ?></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!--Los cumplimientos y operadores -->
        <div class="card p-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title m-0"><i class="bi bi-people"></i> Matriz de Cumplimiento</div>
                <button type="button" class="btn btn-dark btn-sm rounded-pill px-3 shadow" onclick="agregarOperador()">
                    <i class="bi bi-person-plus-fill me-1"></i> Añadir Operador
                </button>
            </div>

            <div class="table-responsive">
                <table class="table align-middle border" id="tablaCumplimiento">
                    <thead>
                    <tr id="headerRow">
                        <th style="min-width: 300px;">Item de Seguridad</th>
                        <th class="text-center op-col" data-op-id="0">
                            <div class="op-header-wrapper">
                                <input type="text" name="operadores[0][nombre]" class="op-name-input" value="OPERADOR 1">
                                <small class="text-muted d-block mt-1" style="font-size: 0.6rem;">Nombre Operador</small>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $items = ["Uso de lentes protectores*", "Uso de Protector Solar*", "Uso de chaleco de identificación", "Pausas Activas 15 min", "Cumplimiento del procedimiento de carga y descarga", "Uso de carrito de transporte", "Verificación del estado de equipo (eléctrica)"];
                    foreach($items as $i => $item): ?>
                        <tr data-item-idx="<?= $i ?>">
                            <td class="item-row text-secondary small"><?= $item ?></td>
                            <td class="text-center op-col" data-op-id="0">
                                <select name="operadores[0][items][<?= $i ?>]" class="form-select form-select-sm status-select status-1" onchange="actualizarColor(this)">
                                    <option value="1" selected>✔ SI</option>
                                    <option value="0">✖ NO</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Observaciones-->
        <div class="card p-4 shadow-sm">
            <div class="section-title"><i class="bi bi-chat-left-text"></i> Observaciones</div>
            <textarea name="observaciones" class="form-control border-0 bg-light" rows="3" placeholder="Notas adicionales..."></textarea>
        </div>
        <!-- Ejecutor y firma-->
        <div class="card p-4 shadow-sm">
            <div class="section-title"><i class="bi bi-person-check"></i> Validación de Revisión</div>
            <div class="row g-4 align-items-start">
                <div class="col-md-6">
                    <label class="small fw-semibold mb-2">Nombre del Ejecutor de la Revisión</label>
                    <input type="text" name="ejecutor_nombre" class="form-control" placeholder="Escriba su nombre completo" required>
                </div>
                <div class="col-md-6">
                    <label class="small fw-semibold mb-2">Subir Firma (Foto/Imagen)</label>
                    <input type="file" name="ejecutor_firma" class="form-control" accept="image/*" onchange="previewImage(event)" required>
                    <img id="preview-firma" alt="Vista previa de firma">
                </div>
            </div>
        </div>
        
        <!--Botones -->
        <div class="text-end mb-5">
            <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill shadow fw-bold">
                <i class="bi bi-cloud-arrow-up-fill me-2"></i> GUARDAR REPORTE FINALIZADO
            </button>
        </div>
        <div class="text-center mt-3">
            <a href="./src/exportar_excel.php" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="bi bi-file-earmark-excel me-2"></i> Exportar Último Reporte a Excel
            </a>
        </div>
    </form>
</div>
<script src="assets/js/index.js"></script>

</body>
</html>