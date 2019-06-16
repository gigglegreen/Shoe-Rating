 <?php

 $mysqli =@(new mysqli('127.0.0.1','ge.li','123456','ge.li'));

  	if ($mysqli->connect_errno) {
  	  echo "Error: Failed to make a MySQL connection: \n";
  	  echo "Errno: " . $mysqli->connect_errno . "\n";
  	  echo "Error: " . $mysqli->connect_error . "\n";

  	   echo "<p> Sorry, this website is experiencing problems. </p>";
  	   exit;
	}

	?>