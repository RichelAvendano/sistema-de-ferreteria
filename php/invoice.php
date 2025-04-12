
<?php
	
	require "./code128.php";
	require "main.php";
	require "../inc/session_start.php";
	
	class PDF extends FPDF {
		// Cabecera de página
		function Header() {
			// Logo (ajusta las coordenadas y el tamaño según sea necesario)
			$this->Image('../img/producto.png', 10, 10, 20);
			// Arial bold 15
			$this->SetFont('Arial', 'B', 15);
			// Mover a la derecha
			$this->Cell(80);
			// Título
			$this->Cell(30, 10, 'FerreCopArt', 0, 1, 'C');
			// Salto de línea
			$this->Ln(20);
		}
	
		// Pie de página
		function Footer() {
			// Posición a 1.5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial', 'I', 8);
			// Número de página
			$this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
		}
	}
	
	/* $factura_fecha = conexion();
	$factura_fecha = $factura_fecha->query("SELECT factura_fecha FROM factura WHERE factura_id = 1");
	$factura_fecha = $factura_fecha->fetch();
	$factura_fecha = $factura_fecha['cliente_nombre']; */

	function obtenerProductos($factura_id){
		$conexion = conexion();
		$stmt = $conexion->prepare("SELECT producto_precio, producto_nombre, producto_cantidad FROM factura_producto WHERE factura_id = :factura_id");
		$stmt->bindParam(':factura_id', $factura_id, PDO::PARAM_INT);
		$stmt->execute();
		$factura_producto = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $factura_producto;
	}

	// Función para obtener datos del formulario y de la base de datos
	function obtenerDatos($factura_id) {
		// Sanitizar entradas de usuario
		$factura_fecha = limpiar_cadena($_POST['factura_fecha'] ?? '');
		$cliente_nombre = limpiar_cadena($_POST['cliente_nombre'] ?? '');
		$cliente_cedula = limpiar_cadena($_POST['cliente_cedula'] ?? '');
		$cliente_ubicacion = limpiar_cadena($_POST['cliente_ubicacion'] ?? '');
		$cliente_telefono = limpiar_cadena($_POST['cliente_telefono'] ?? '');

		// Crear conexión y preparar la consulta

		$factura_producto = obtenerProductos($factura_id);

		return [
			'factura_fecha' => $factura_fecha,
			'cliente_nombre' => $cliente_nombre,
			'cliente_cedula' => $cliente_cedula,
			'cliente_ubicacion' => $cliente_ubicacion,
			'cliente_telefono' => $cliente_telefono,
			'factura_producto' => $factura_producto
		];
	}

	// Verificar y obtener datos del formulario
	$factura_id = null;
	if (!empty($_POST["bill_id"])) {
		$factura_id = limpiar_cadena($_POST['bill_id']);
	} elseif (!empty($_POST["bill_id_up"])) {
		$factura_id = limpiar_cadena($_POST['bill_id_up']);
	}

	if ($factura_id) {
		$datos = obtenerDatos($factura_id);

		// Acceder a los datos retornados desde la función
		$factura_fecha = $datos['factura_fecha'];
		$cliente_nombre = $datos['cliente_nombre'];
		$cliente_cedula = $datos['cliente_cedula'];
		$cliente_ubicacion = $datos['cliente_ubicacion'];
		$cliente_telefono = $datos['cliente_telefono'];
		$factura_producto = $datos['factura_producto'];
	}

	// Verificar y obtener datos de la base de datos mediante GET
	if (isset($_GET["bill_id"]) && !empty($_GET["bill_id"])) {
		$factura_id = limpiar_cadena($_GET['bill_id']);
		$conexion = conexion();
		$stmt = $conexion->prepare("SELECT factura.factura_fecha, cliente.cliente_nombre, cliente.cliente_cedula, cliente.cliente_ubicacion, cliente.cliente_telefono
		FROM factura 
		INNER JOIN cliente ON cliente.cliente_id = factura.cliente_id
		WHERE factura.factura_id = :factura_id");
		$stmt->bindParam(':factura_id', $factura_id, PDO::PARAM_INT);
		$stmt->execute();
		$check_factura = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($check_factura) {
			$factura_fecha = $check_factura['factura_fecha'];
			$cliente_nombre = $check_factura['cliente_nombre'];
			$cliente_cedula = $check_factura['cliente_cedula'];
			$cliente_ubicacion = $check_factura['cliente_ubicacion'];
			$cliente_telefono = $check_factura['cliente_telefono'];
		}

		$factura_producto = obtenerProductos($factura_id);
	}

	# Incluyendo librerias necesarias #
	$pdf = new PDF_Code128('P','mm','Letter');
	$pdf->SetMargins(17,17,17);
	$pdf->AddPage();

	# Logo de la empresa formato png #
	$pdf->Image('../img/logo_ferreteria.png',165,12,40,25,'PNG');

	# Encabezado y datos de la empresa #
	$pdf->SetFont('Arial','B',20);
	$pdf->SetTextColor(32,100,210);
	$pdf->Cell(150,10,iconv("UTF-8", "ISO-8859-1",strtoupper("Ferre CopArt, C.A")),0,0,'L');

	$pdf->Ln(9);

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","RIF: J-50463364"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Direccion: Av. Colombia al frente del C.C El Golfito, Barinas Barinas, Zona Postal 5201"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Telefonos: (0426) 413.64.47 / (0273) 532.49.61"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Email: ferrecopart@gmail.com"),0,0,'L');

	$pdf->Ln(8);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,7,iconv("UTF-8", "ISO-8859-1","Fecha de Emisión: "),0,0);
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(116,7,iconv("UTF-8", "ISO-8859-1",$factura_fecha),0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",strtoupper("Factura N°. $factura_id")),0,0,'C');

	$pdf->Ln(7);

	$numero_control = str_pad($factura_id, 8, '0', STR_PAD_LEFT);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(23,7,iconv("UTF-8", "ISO-8859-1","Razón Social: "),0,0,'L');
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(123,7,iconv("UTF-8", "ISO-8859-1", $cliente_nombre),0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",strtoupper("N° de Control 00-$numero_control")),0,0,'C');

	$pdf->Ln(9);

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(53,7,iconv("UTF-8", "ISO-8859-1","N° RIF o N° Cedula o Pasaporte:"),0,0);
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(30,7,iconv("UTF-8", "ISO-8859-1", $cliente_cedula),0,0,'L');
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(26,7,iconv("UTF-8", "ISO-8859-1","N° de Telefono: "),0,0,'L');
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$cliente_telefono),0,0,'L');
	$pdf->SetTextColor(39,39,51);

	$pdf->Ln(7);

	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(17,7,iconv("UTF-8", "ISO-8859-1","Dirección:"),0,0);
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(109,7,iconv("UTF-8", "ISO-8859-1",$cliente_ubicacion),0,0);

	$pdf->Ln(9);

	# Tabla de productos #
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(208,229,255);
	$pdf->SetDrawColor(23,83,201);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(23,8,iconv("UTF-8", "ISO-8859-1","Cantidad"),1,0,'C',true);
	$pdf->Cell(92,8,iconv("UTF-8", "ISO-8859-1","Descripción / Gravado o Exento"),1,0,'C',true);	
	$pdf->Cell(30,8,iconv("UTF-8", "ISO-8859-1","Precio C/U"),1,0,'C',true);
	$pdf->Cell(36,8,iconv("UTF-8", "ISO-8859-1","Subtotal"),1,0,'C',true);

	$pdf->Ln(8);

	$pdf->SetFont('Arial','',10);
	$pdf->SetDrawColor(23,83,201);
	$pdf->SetTextColor(0,0,0);
	$monto_total = 0;

	/*----------  Detalles de la tabla  ----------*/
	foreach($factura_producto as $rows){

		$valorUnitarioProductoBCV = $_SESSION['dolar_valor_bcv'] * $rows['producto_precio'];
		$valorUnitarioProductoMonitor = $_SESSION['dolar_valor_paralelo'] * $rows['producto_precio'];
		
		$valorTotalProductoRef = round(($rows['producto_cantidad']*$rows['producto_precio']) , 2);
		$monto_total += $valorTotalProductoRef;
		$monto_total = round($monto_total,2);

		$valorTotalProductoRef = number_format($valorTotalProductoRef, 2, ',', '.');

		$valorTotalProductoMonitor = round(($rows['producto_cantidad']*$valorUnitarioProductoMonitor) , 2);
		$valorTotalProductoMonitor = number_format($valorTotalProductoMonitor, 2, ',', '.');

		$valorTotalProductoBCV = round(($rows['producto_cantidad']*$valorUnitarioProductoBCV) , 2);
		$valorTotalProductoBCV = number_format($valorTotalProductoBCV, 2, ',', '.');
		
		$producto_precio = number_format($rows["producto_precio"], 2, ',', '.');

		$pdf->Cell(23,7,iconv("UTF-8", "ISO-8859-1",$rows["producto_cantidad"]),'LB',0,'C');
		$pdf->Cell(92,7,iconv("UTF-8", "ISO-8859-1",$rows["producto_nombre"]),'LB',0,'C');	
		$pdf->Cell(30,7,iconv("UTF-8", "ISO-8859-1","$".$producto_precio),'LB',0,'C');
		$pdf->Cell(36,7,iconv("UTF-8", "ISO-8859-1","$".$valorTotalProductoRef),'LBR',0,'C');
		$pdf->Ln(7);
	}
	/*----------  Fin Detalles de la tabla  ----------*/
	$factura_producto = null;
	$monto_total = number_format($monto_total, 2, ',', '.');

	
	$pdf->SetFont('Arial','B',9);
	
	# Impuestos & totales #
	$pdf->Cell(145,7,iconv("UTF-8", "ISO-8859-1","ADICIONES, DESCUENTOS, BONIFICACIONES AL PRECIO"),'R',0,'R');
	$pdf->Cell(36,7,iconv("UTF-8", "ISO-8859-1",""),'BR',0,'C');

	$pdf->Ln(7);

	$pdf->Cell(145,7,iconv("UTF-8", "ISO-8859-1","MONTO TOTAL EXENTO O EXONERADO"),'R',0,'R');
	$pdf->Cell(36,7,iconv("UTF-8", "ISO-8859-1","$$monto_total"),'TBR',0,'C');
	
	$pdf->Ln(7);

	$pdf->Cell(129,7,iconv("UTF-8", "ISO-8859-1","BASE IMPONIBLE SEGÚN ALICUOTA"),'',0,'R');
	$pdf->Cell(12,6,iconv("UTF-8", "ISO-8859-1",""),'B',0,'C');
	$pdf->Cell(4,7,iconv("UTF-8", "ISO-8859-1","%"),'R',0,'R');
	$pdf->Cell(36,7,iconv("UTF-8", "ISO-8859-1",""),'TBR',0,'C');

	$pdf->Ln(7);

	$pdf->Cell(129,7,iconv("UTF-8", "ISO-8859-1","MONTO TOTAL DEL IMPUESTO SEGÚN ALICUOTA"),'',0,'R');
	$pdf->Cell(12,6,iconv("UTF-8", "ISO-8859-1",""),'B',0,'C');
	$pdf->Cell(4,7,iconv("UTF-8", "ISO-8859-1","%"),'R',0,'R');
	$pdf->Cell(36,7,iconv("UTF-8", "ISO-8859-1",""),'TBR',0,'C');

	$pdf->Ln(7);

	$pdf->Cell(145,7,iconv("UTF-8", "ISO-8859-1","MONTO TOTAL DE VENTA"),'R',0,'R');
	$pdf->Cell(36,7,iconv("UTF-8", "ISO-8859-1","$$monto_total"),'TBR',0,'C');

	$pdf->Ln(12);

	$pdf->SetFont('Arial','',9);

	$pdf->SetTextColor(39,39,51);
	$pdf->MultiCell(0,9,iconv("UTF-8", "ISO-8859-1","*** Para poder realizar un reclamo o devolución debe de presentar esta factura ***"),0,'C',false);

	/* $pdf->Ln(9);

	# Codigo de barras #
	$pdf->SetFillColor(39,39,51);
	$pdf->SetDrawColor(23,83,201);
	$pdf->Code128(72,$pdf->GetY(),"COD000001V0001",70,20);
	$pdf->SetXY(12,$pdf->GetY()+21);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","COD000001V0001"),0,'C',false); */

	# Nombre del archivo PDF #
	$pdf->Output("I","Factura_Nro_$factura_id.pdf",true);