<?php
session_start();
?>

<html>
<head>
	<title>Login</title>
	<link href="style2.css" rel="stylesheet" />
</head>

<body>
<?php



include('dbconnect.php');

if(isset($_REQUEST['login'])){
	login($mysqli);
	//echo "Insert button pressed";
}

if(isset($_REQUEST["register"])){
	//echo " <p> Welcome: ". $_REQUEST['name']. "</p>";
	header('Location:register.php');
}


echo "<form action=\"#\" method=\"POST\"> ";

echo "<fieldset>";
echo "<label> Username </label>";
echo "<input type=\"text\" id=\"namField\" name=\"username\" value=\"\" placeholder=\"username\"> <br/>";
echo "<label> Password</label>";
echo "<input type=\"text\" id=\"colField\" name=\"password\" value=\"\" placeholder=\"password\"><br/>";
echo "</fieldset>";

echo "<fieldset>";
echo "<input type=\"submit\" name=\"login\" value=\"Login\">";
echo "<input type=\"submit\" name=\"register\" value=\"Register\">";
echo "</fieldset>";
echo " </form>";


include('footer.php');


// Login Function
function login($mysqli){

	$fNam = $_REQUEST['username'];
	//$fPas = $_REQUEST['password'];

	$fNam = mysqli_real_escape_string($mysqli, $_REQUEST['username']);
	$fPas = mysqli_real_escape_string($mysqli, $_REQUEST['password']);

	//echo "$fNam $fPas";
	// Prepare and run query
	$runQ = "Select id,username,pasword,fullname from shoeUsers WHERE Username='$fNam' AND pasword = '$fPas'";

	if (!$result = $mysqli->query($runQ)) {
		echo "Error, handle";
	}
	$rowCount = mysqli_num_rows($result);

	if($rowCount==1){
		while ($row = $result->fetch_assoc()) {
			$_SESSION['login_user'] = $row['username'];
			$_SESSION['login_name'] = $row['fullname'];
			$_SESSION['user_id'] = $row['id'];
		}
		header('Location:index.php');
	}
	else{
		echo "<p>  Username or Password incorrect, please re-enter/ </p>";
	}
}

?>
</body>


</html>



