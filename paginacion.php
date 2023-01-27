<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="hoja.css">
<title>Documento sin título</title>
</head>

<body>
	
<?php
	
	try{
		$base=new PDO("mysql:host=localhost; dbname=pruebas", "root", "");
		$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$base->exec("SET CHARACTER SET utf8");
		
/*		$sql_total="SELECT * FROM productos";*/
		$registros_por_pagina=5; /* CON ESTA VARIABLE INDICAREMOS EL NUMERO DE REGISTROS QUE QUEREMOS POR PAGINA*/
		$estoy_en_pagina=1;/* CON ESTA VARIABLE INDICAREMOS la pagina en la que estamos*/
		
			if (isset($_GET["pagina"])){
				$estoy_en_pagina=$_GET["pagina"];				
			}
		
		$empezar_desde=($estoy_en_pagina-1)*$registros_por_pagina;
		
		$sql_total="SELECT * FROM productos";
/* CON LIMIT 0,3 HACE LA SELECCION DE LOS 3 REGISTROS QUE HAY EMPEZANDO DESDE EL REGISTRO 0*/
		$resultado=$base->prepare($sql_total);
		$resultado->execute(array());
		
		$num_filas=$resultado->rowCount(); /* nos dice el numero de registros del reusulset*/
		$total_paginas=ceil($num_filas/$registros_por_pagina); /* FUNCION CEIL REDONDEA EL RESULTADO*/

/* ESTA PRIMERA CONSULTA ES PARA SABER NUMERO TOTAL DE REGISTROS Y MOSTRAR LAS PAGINAS Y REGISTROS QUE HAY*/
		
/*		while ($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
			echo "Código Articulo: " . $registro['CODIGOARTICULO'] . " Seccion: " . $registro['SECCION'] ." Nombre Articulo: " . $registro['NOMBREARTICULO'] .  " Precio: " . $registro['PRECIO'] .  " Fecha: " . $registro['FECHA'] .  " Importado: " . $registro['IMPORTADO'] . " Pais de Origen: " . $registro['PAISDEORIGEN'] . "<br>";
		}*/
		
		$resultado->CloseCursor();
		$sql_limite="SELECT * FROM productos LIMIT $empezar_desde,$registros_por_pagina";
		$resultado=$base->prepare($sql_limite);
		$resultado->execute(array());
		


		
	}catch (Exception $e){
		die ("Error: " . $e->getMessage());
		
	}
	

	
?>

<table width="50%" border="0" align="center">
<tr>
          <td class="primera_fila">CODIGOARTICULO</td>
          <td class="primera_fila">SECCION</td>
          <td class="primera_fila">NOMBREARTICULO</td>
          <td class="primera_fila">PRECIO</td>
          <td class="primera_fila">FECHA</td>
          <td class="primera_fila">IMPORTADO</td>
          <td class="primera_fila">PAISDEORIGEN</td>
          
        </tr>
        <tr>
        <?php
            while ($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
                echo "<tr>";
                echo "<td>" . $registro['CODIGOARTICULO'] . "</td>";
                echo "<td>" . $registro['SECCION'] . "</td>";
                echo "<td>" . $registro['NOMBREARTICULO'] . "</td>";
                echo "<td>" . $registro['PRECIO'] . "</td>";
                echo "<td>" . $registro['FECHA'] . "</td>";
                echo "<td>" . $registro['IMPORTADO'] . "</td>";
                echo "<td>" . $registro['PAISDEORIGEN'] . "</td>" ;
                echo "</tr>";
            }
            ?>
        </tr>
    </table>
<style>
div{
    text-align:center;
}
</style>
    <?php
    /*-------------------------PAGINACION-----------------*/
	echo "<br>";
	echo "<div>";
	for ($i=1; $i<=$total_paginas; $i++){
/*		echo "<a href='?pagina=" . $i . "'>" . $i . "</a>  ";*/
		echo "<a href='paginacion.php?pagina=" . $i . "'>" . $i . "</a>  ";
	}
    echo "</div>";
    ?>
</body>
</html>