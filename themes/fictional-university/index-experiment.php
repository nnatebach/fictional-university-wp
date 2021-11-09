<?php

	$names = array("Ross", "Chandler", "Joey", "Monica", "Rachel", "Phoebe");

	$count = 0;

	while ($count < count($names)) {
		echo "<li>Hi, my name is $names[$count]</li>";
		$count++;
	}

?>