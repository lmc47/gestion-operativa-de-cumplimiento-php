# 🚀 Sistema de Gestión de Seguimiento Operativo 
Solucion integral para reemplazar la hoja fisica de SEGUIMIENTO GENERAL OPERATIVO DE CUMPLIMIENTO DEL AREA AUDIOVISUALES.
---

## ✨ Características Principales

* **🆔 ID:** Consulta la db y genera el codigo de atencion unico (incrementa) y lo carga al formulario.
* **🌦️ Control Climático:** Permite elegir la condicion climatica con representacion  visual.
* **👥 Varios Operadores:** Tiene un botón que permite añadir varios operadores, cada uno tiene su propia tabla de items de seguridad.
* **✍️ Validación con Firma:** Soporte para subir firma del ejecutor.
* **📊 Reportes en Excel:** Exportacion rapida del ultimo reporte hecho en una hoja de calculo.

---

## 🛠️ Requisitos

* **Servidor:** Apache (XAMPP, etc).
* **Lenguaje:** PHP.
* **Base de Datos:** MariaDB / MySQL.
* **Extensiones de php:** `mysqli` activa en la configuración de PHP.

---

## 🚀 Guía de Instalación

1.  **Descarga:** Copiar los archivos a la carpeta del servidor (ej. `/htdocs`).
2.  **Base de Datos:** * Ejecuta el archivo de script de la db que se encuentra en la carpeta del proyecto (db.sql).
3.  **Conexión:** Modifica el archivo `config/conexion/database.php` con el usuario y contraseña que tendra la base de datos.
4.  **Permisos:** La carpeta `uploads/firmas/` debe tener permisos de escritura.
5.  **Listo:** Corre el servidor.

---

## 📂 Flujo del Sistema

1.  **Inicio:** Se asigna un ID automático (ej: `00011`).
2.  **Llenado:** Se llenan los datos generales, el clima y se asigna los operadores que se necesitan.
3.  **Guardado:** Al gurdar, los datos que se insertan en la base de datos ocurren en 3 tablas (Reporte, Operadores y Cumplimiento).
4.  **Confirmación:** Una ventana confirma que se guardo con exito y el id asignado a ese reporte.
5.  **Descarga:** Al guardar los datos, se habilita la opción de exportar los datos a una hoja de calculo.

---

*FORMATO DE SEGUIMIENTO GENERAL OPERATIVO DE CUMPLIMIENTO DEL AREA AUDIOVISUALES*