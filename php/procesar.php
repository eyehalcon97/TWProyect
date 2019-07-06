
<?php

require_once'./BasedeDatos.php';
require_once'./Funciones.php';


	echo "<p>Variables POST: </p>";
	echo "<ul>";

	echo "<p>Variables POST: </p>";
	echo "<ul>";
	foreach ($_POST as $c => $v) {
		if (is_array($v)){
			echo "<li>$c = ";
			print_r($v);
		} else
			echo "<li>$c = $v</li>";
	}
	echo "</ul>"
		
	?>
</body>

