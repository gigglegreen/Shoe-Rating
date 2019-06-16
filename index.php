  <?php
include('session.php');

include('dbconnect.php');

$title = "Index—-Shoe Store";




echo "<!DOCTYPE html> ";
echo "<html> ";

echo "  <head> ";
echo "  <meta charset=\"utf-8\">";
echo "    <title>$title</title> ";
echo "	<link href=\"style2.css\" rel=\"stylesheet\" /> ";
echo "  </head> ";

echo "<body>";

include('navmenu.php');


	// Get name from session and display
	if(isset($_SESSION['login_name'])){
		$name = $_SESSION['login_name'];
		echo "<h3>Hello $name, welcome back! </h3>";
	}



$result = queryShoes($mysqli);


if($result->num_rows === 0) {
	echo "raar";
}
while ($row = $result->fetch_assoc()) {
	$name = $row['Name'];
	$cost = $row['Cost'];
	$para1 = $row['p1'];
	$para2 = $row['p2'];
	$para3 = $row['p3'];
	$id = $row['shoeId'];
	$para4 = $row['p4'];

	echo "	<a href=\"shoe.php?pagenum=$id\"><img src=\"resources/shoe$id.jpg\"  title=\"$name\"/></a>";
}

echo "<form action=\"#\" method=\"POST\">";

echo " <fieldset>";
echo "	 	<input type=\"submit\" name=\"MaleShoes\" value=\"Show only Men's Shoes\"></input>  ";
echo "	 	<input type=\"submit\" name=\"FemaleShoes\" value=\"Show only Women's Shoes\"></input>  ";
echo "	 	<input type=\"submit\" name=\"OrderCost\" value=\"Order by Cost\"></input>  ";
echo "	 	<input type=\"submit\" name=\"Reset\" value=\"Reset\"></input>  ";
echo " </fieldset>";
echo "</form>";





include('footer.php');
echo "</body>";

echo "</html>";





// Query to change index
function queryShoes($mysqli){
		$runQ ="";
		if(isset($_REQUEST["MaleShoes"])){
			$runQ = "Select * from shoeData WHERE shoeId>5";
		}
		else if(isset($_REQUEST["FemaleShoes"])){
			$runQ = "Select * from shoeData WHERE shoeId<6";
		}
		else if(isset($_REQUEST["OrderCost"])){
					$runQ = "Select * from shoeData ORDER BY cost";
		}
		else {
			$runQ = "Select * from shoeData";
		}
	//echo "$runQ";

	if (!$result = $mysqli->query($runQ)) {
		echo "Error, handle";
	}
	return $result;
}


// Generates main content
function mainContent($result) {
	$movName = "";
	while ($row = $result->fetch_assoc()) {
		$fNam = $row['name'];
		$fImg = $row['image'];
		$fDes = $row['description'];
		$fId = $row['id'];

		echo "<section>";
		echo "	 <h2>$fNam</h2>";
		echo "	<img src=\"images/$fImg.jpg\"  title=\"$fNam\"/>";
		echo "	<p>$fDes</p>";
		echo "</section>";
		$movName = $fNam;
	}
	return $movName;
}

function showComments($result){
	echo "<table class=\"aside\"> ";
	echo "	<tr>";
	echo "		<th>User</th>";
	echo "		<th>Posted</th>";
	echo "		<th class=\"comment\">Comment</th>";
	echo "	</tr>";

	while ($row = $result->fetch_assoc()) {
		$ComUsr = $row['authorname'];
		$ComTim = $row['time'];
		$ComCom = $row['comment'];
		echo "	<tr>";
		echo "<td><a href=\"profile.php?usr=$ComUsr\">$ComUsr</a></td>";
		echo "<td>$ComTim</td>";
		echo "<td class=\"comment\">$ComCom</td>";
		echo "	</tr>";
	}

	echo "</table>";
}




// form to add comment
function insertForm(){
	echo "<form action=\"#\" method=\"POST\"> ";

	echo "<fieldset>";
	echo "<label> Comment </label>";
	echo "<input type=\"text\" id=\"comment\" name=\"comment\" value=\"\" placeholder=\"Add Comment\">";
	echo "</fieldset>";

	echo "<fieldset>";
	echo "<input type=\"submit\" name=\"insert\" value=\"Add Comment\">";
	echo "</fieldset>";


	echo "<fieldset>";
	echo "<input type=\"submit\" name=\"old_order\" value=\"Sort by Oldest\">";
	echo "<input type=\"submit\" name=\"new_order\" value=\"Sort by Newest\">";
	echo "<input type=\"submit\" name=\"user_order\" value=\"Sort by User\">";
	echo "</fieldset>";

 	echo " </form>";
}

// Query for a single movie
function getMovieName($mysqli,$pId){
	$runQ = "Select * from cw3_movie WHERE id=$pId";
	if (!$result = $mysqli->query($runQ)) {
		echo "Error, handle";
	}
	$movName = "";
	while ($row = $result->fetch_assoc()) {
		$movName = $row['name'];
	}
	return $movName;
}

// Handle comments by adding to database
function insertCommentDB($mysqli){
	// Need all data

	// authorname
	$autName = $_SESSION['login_user'];
	// moviename
	$pageID = $_REQUEST['id'];
	$movName = getMovieName($mysqli,$pageID);
	// time
	$date = date('Y-m-d H:i:s');
	// comment
	$comment = mysqli_real_escape_string($mysqli,$_REQUEST['comment']);

	// Create an insert query
	$runQ = "INSERT INTO cw3_comments (moviename,authorname,comment,time) VALUES ('$movName','$autName','$comment','$date')";

		if (!$result = $mysqli->query($runQ)) {
			echo "Error, handle";
	}
}


?>

