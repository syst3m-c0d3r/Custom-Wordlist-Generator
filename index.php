
<?php

/*				  CWG
		CUSTOM WORDLIST GENERATOR
			 By Syst3m-c0d3r
		syst3m-c0d3r@protonmail.com
*/


set_time_limit(0);
if(isset($_POST['generar'])){
	$datos=array();
	$valores_no_vacios = -1; // -1 porque el submit no es un dato 	
	foreach($_POST as $form => $valor) {
		if(!empty($valor) && $valor!="Generar" && $form!="longitud" && $form!="fecha" ){
			if($_POST['otros']==""){
				$valores_no_vacios++;
				// La cantidad de inputs con informacion 
				$datos[$valores_no_vacios]=$valor;	// tengo todos los datos del post en un array
			}else{
				$key=$_POST['otros'];
				$explo=explode(",", $key);
				$cant=count($explo);
				if($cant=="1"){
					$valores_no_vacios++;
					$datos[$valores_no_vacios]=$valor;
				}else{
					$valores_no_vacios++;
					if($form!="otros"){
						$datos[$valores_no_vacios]=$valor;
					}else{
						for($i=0;$i<$cant;$i++){
							$datos[$valores_no_vacios]=$explo[$i];
							$valores_no_vacios++;
						}
						$valores_no_vacios=$valores_no_vacios-1;
					}
				}
			}
		}
    }
	$fecha=$_POST['fecha'];
	$datos[$valores_no_vacios+1]=$fecha;
	$datos[$valores_no_vacios+2]=substr($fecha, 4, 4); //YYYY
	$datos[$valores_no_vacios+3]=substr($fecha, 6, 2); //YY
	$datos[$valores_no_vacios+4]=substr($fecha, 0, 4).substr($fecha, 6, 2);  // DDMMYY
	
	// -------------------------- FIN DE RECOLECCION DE DATOS --------------------------

	// -------------------------- COMIENZO GUARDADO DE DATOS --------------------------
	
	$nombre=$_POST['nombre'];
	$long=$_POST['longitud'];
	$fo=fopen($nombre.".txt", 'a');
	$tot=count($datos); //Cantidad de datos dentro del array $datos

	// empiezo a combinar
	
	for($i=0;$i<$tot;$i++){
		if(strlen($datos[$i])>=$long){	
			if($i+1<=$tot){
				fwrite($fo, $datos[$i]."\r\n");  //Escribo todas las palabras sin combinar	
			}
		}
	}
	//Combinaciones 2 palabras para datos[n]
	for($d=0;$d<($tot*$tot);$d++){	
		for($i=0;$i<$tot;$i++){
			if(strlen($datos[$i])>=$long){	
				if($d<$tot){
					fwrite($fo, $datos[$d].$datos[$i]."\r\n");
				}			
			}
		}	
	}
	//Combinaciones 3 palabras para datos[n]
	for($d=0;$d<($tot*$tot);$d++){	
		for($i=0;$i<$tot;$i++){
			if(strlen($datos[$i])>=$long){	
				if($d<$tot){
					if($i+1<$tot){
						fwrite($fo, $datos[$d].$datos[$i].$datos[$i+1]."\r\n");
						fwrite($fo, $datos[$d].$datos[$i+1].$datos[$i]."\r\n");
					}
				}			
			}
		}	
	}
	//Combinaciones 4 palabras para datos[n]
	for($d=0;$d<($tot*$tot);$d++){	
		for($i=0;$i<$tot;$i++){
			if(strlen($datos[$i])>=$long){	
				if($d<$tot){
					if($i+2<$tot){
						fwrite($fo, $datos[$d].$datos[$i].$datos[$i+1].$datos[$i+2]."\r\n");
						fwrite($fo, $datos[$d].$datos[$i].$datos[$i+2].$datos[$i+1]."\r\n");
					}
				}			
			}
		}	
	}	
	fclose($fo);			
}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="styles/styles.css">
<style>
.alert {
    padding: 20px;
    background-color: #4CAF50; /* Red */
    color: white;
    margin-bottom: 15px;
	overflow:hidden;
	font-family:fixedsyxed;
}
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}
.closebtn:hover {
    color: black;
}
.copy{
	text-align:center;
	font-size:100%;
	font-family:fixedsyxed;
	color:red;
}
</style>
</head>
<body>

<?php
if(isset($_POST['generar'])){
echo '<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
  Wordlist generada correctamente en: '.$nombre.'.txt
</div>';
}
?>
<div class="class1">

<h1>Custom Wordlist Generator</h1>
<hr>
<center>Introducir todos los datos sin espacios<br>
Los datos con <font color="red">(*)</font> son obligatorios<br>
Dejar en blanco los datos no conocidos<br>
Se recomienda usar minusculas<br>
El archivo se generara en /[nombre].txt<div class="copy">Syst3m-c0d3r</div>
<hr style="margin-top:20px;">
<br></center>

<div class="divform">
<form method="POST" action="">
Longitud minima<font color="red">(*)</font>:<br>
<input type="text" name="longitud" placeholder="6" required><br>
Nombre<font color="red">(*)</font>:<br>
<input type="text" name="nombre" placeholder="Nombre" required><br>
Segundo nombre:<br>
<input type="text" name="secnombre" placeholder="Segundo nombre"><br>
Apellido<font color="red">(*)</font>:<br>
<input type="text" name="apellido" placeholder="Apellido" required><br>
Apodo:<br>
<input type="text" name="apodo" placeholder="Apodo"><br>
Fecha de nacimiento<font color="red">(*)</font>:<br>
<input type="text" name="fecha" placeholder="Formato: DDMMAAAA" required><br>
Telefono:<br>
<input type="text" name="telefono" placeholder="Numero de telefono fijo"><br>
Celular:<br>
<input type="text" name="celular" placeholder="Numero de celular"><br>
DNI:<br>
<input type="text" name="dni" placeholder="Numero de DNI"><br>
Otros:<br>
<input type="text" style="width:100%" name="otros" placeholder="Introducir palabras claves separadas por comas sin espacio, ejemplo: acdc,riverplate,juan,nombredelamascota"><br>
<input type="submit" name="generar" value="Generar">
</form>
</div>
</div>

</body>
</html>




