 <?php
 include('dbconnect.php');

 $title = "Shoe Store Register";


 echo "<!DOCTYPE html> ";
 echo "<html> ";

 echo "  <head> ";
 echo "  <meta charset=\"utf-8\">";
 echo "    <title>$title</title> ";
 echo "	<link href=\"style_a2.css\" rel=\"stylesheet\" /> ";
 echo "  </head> ";

 echo "<body>";
$title = "Shoe Store Register";



if(isset($_REQUEST['login'])){
	header('Location:login.php');
	//echo "Insert button pressed";
}

if(isset($_REQUEST["register"])){
	register($mysqli);
}

echo "<form action=\"#\" method=\"POST\"> ";

echo "<fieldset>";
echo "<label> Name </label>";
echo "<input type=\"text\" id=\"fulField\" name=\"fullname\" value=\"\" placeholder=\"full name\"> <br/>";
echo "<label> Username </label>";
echo "<input type=\"text\" id=\"namField\" name=\"username\" value=\"\" placeholder=\"username\"> <br/>";
echo "<label> Password</label>";
echo "<input type=\"text\" id=\"colField\" name=\"password\" value=\"\" placeholder=\"password\"><br/>";
echo "</fieldset>";

echo "<fieldset>";
echo "<input type=\"submit\" name=\"login\" value=\"Return to Login\">";
echo "<input type=\"submit\" name=\"register\" value=\"Register User Account\">";
echo "</fieldset>";
echo " </form>";


include('footer.php');


// Register Function
function register($mysqli){

	$fFna = mysqli_real_escape_string($mysqli, $_REQUEST['fullname']);
	$fNam = mysqli_real_escape_string($mysqli, $_REQUEST['username']);
	$fPas = mysqli_real_escape_string($mysqli, $_REQUEST['password']);

	// 2 queries needed
	// one to check account doesnt exist, one to insert

	// Check match, if a match is found, register
	if(checkmatch($mysqli,$fNam)){

		// Prepare and run query
		$runQ = "INSERT INTO shoeusers (username,fullname,pasword) VALUES ('$fNam','$fFna','$fPas')";
		if (!$result = $mysqli->query($runQ)) {
			echo "Error, handle";
		}
	header('Location:login.php');
	}
}

// queries database with username to check doesnt match
function checkmatch($mysqli,$uname){
	// Prepare and run query
	$runQ = "Select Username from shoeusers WHERE username='$uname'";

	if (!$result = $mysqli->query($runQ)) {
		echo "Error, handle";
	}
	$rowCount = mysqli_num_rows($result);

	if($rowCount>0){
		echo " <h2> Account Already exists </h2>";
		return false;
	}
	else {
		return true;
	}
}



?>
</body>


</html>



