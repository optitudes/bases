<?php
require_once('fpdf/fpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consulta = $_POST["consulta"];

    // Obtén los datos según la consulta
    switch ($consulta) {
        case "1":
            $data = $_POST['data1']; // Usa los datos de la Consulta 1
            $header = "Consulta 1: Clientes con diabetes nacidos antes del año 2000";
            break;
        case "2":
            $data = $_POST['data2']; // Usa los datos de la Consulta 2
            $header = "Consulta 2: Empleados con salario mayor a 50000, que cualquiera de sus nombres inicia con 'm' y ordenalos desde menor a mayor salario";
            break;
        case "3":
            $data = $_POST['data3']; // Usa los datos de la Consulta 3
            $header = "Consulta 3:Citas con duración superior a 1 hora";
            break;
        case "4":
            $data = $_POST['data4']; // Usa los datos de la Consulta 3
            $header = "Consulta 4";
            break;
            break;
        // Agrega más casos para otras consultas
    }

    // Genera y muestra el PDF
    generatePDF($data, $_POST["filename"], $header);
}

function generatePDF($data, $filename, $header) {
    // Crear una nueva instancia de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Agregar imagen como fondo
    $pdf->Image('./imagenes/fondo.png', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());

    // Configurar la fuente y tamaño
    $pdf->SetFont('Arial', 'B', 12);

    // Posiciona el texto en una ubicación específica en la página
    $pdf->SetXY(10, 10);
    $pdf->Cell(0, 10, $header, 0, 1, 'C');

    // Contenido del informe
    foreach ($data as $row) {
        foreach ($row as $column) {
            $pdf->Cell(40, 10, $column, 1);
        }
        $pdf->Ln();
    }

    // Salida del PDF al navegador
    $pdf->Output($filename, 'I');
}
?>
