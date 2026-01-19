CREATE DATABASE sistema_seguimient_op;
USE sistema_seguimient_op;

-- 1. Tabla principal del reporte
CREATE TABLE reportes (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          codigo_atencion VARCHAR(50),
                          unidad_solicitante VARCHAR(255),
                          fecha DATE,
                          tiempo_ejecucion VARCHAR(100),
                          lugar_atencion VARCHAR(255),
                          clima VARCHAR(50),
                          observaciones TEXT,
                          ejecutor_nombre VARCHAR(255),
                          firma_ruta VARCHAR(255),
                          creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE operadores (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            id_reporte INT,
                            nombre_operador VARCHAR(255),
                            FOREIGN KEY (id_reporte) REFERENCES reportes(id) ON DELETE CASCADE
);


CREATE TABLE cumplimiento (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              id_operador INT,
                              item_indice INT, -- El número de fila (0 al 6)
                              cumple TINYINT(1), -- 1 para SI, 0 para NO
                              FOREIGN KEY (id_operador) REFERENCES operadores(id) ON DELETE CASCADE
);
select * from  cumplimiento;
select * from reportes;

