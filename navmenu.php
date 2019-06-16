<?php

$runQ = "Select * from shoeData";

	if (!$result = $mysqli->query($runQ)) {
		echo "Error, handle";
	}

	if($result->num_rows === 0) {
		echo "raar";
	}

	echo "<nav class = \"menustyling\">";
	echo "	<ul>";
	echo "		<li><a href=\"index.php\">Home</a></li>";


	while ($row = $result->fetch_assoc()) {
			$titles = $row['Name'];
			$id = $row['shoeId'];
			echo "		<li><a href=\"shoe.php?pagenum=$id\">$titles</a></li>";

	}
	if(isset($_SESSION['login_name'])){
			$name = $_SESSION['login_user'];
			echo "  <li><a href=\"logout.php\">Log Out</a></li>";
	}
echo "	</ul>";
echo "</nav>";

?>