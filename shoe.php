  <?php
include('session.php');

include('dbconnect.php');

$title = "Rate--Shoe Store";

$pageNum = 1;
$userId = $_SESSION['user_id'];;

if( isset($_REQUEST["pagenum"])){
			$pageNum = $_REQUEST["pagenum"];
}

if( isset($_REQUEST["Rate"])){
			handleRating($mysqli,$userId,$pageNum);
	}




echo "<!DOCTYPE html> ";
echo "<html> ";

echo "  <head> ";
echo "  <meta charset=\"utf-8\">";
echo "    <title>$title</title> ";
echo "	<link href=\"style2.css\" rel=\"stylesheet\" /> ";
echo "  </head> ";

echo "<body>";


	// Get name from session and display
	if(isset($_SESSION['login_name'])){
		$name = $_SESSION['login_name'];
		echo "<h3>Hello $name, welcome back! </h3>";
	}

include('navmenu.php');

$runQ = "Select * from shoeData where shoeId = $pageNum";


if (!$result = $mysqli->query($runQ)) {
		echo "Error, handle";
	}

	if($result->num_rows === 0) {
		echo "raar";
	}
	$countHead = 0;
	while ($row = $result->fetch_assoc()) {
		$name = $row['Name'];
		$cost = $row['Cost'];
		$para1 = $row['p1'];
		$para2 = $row['p2'];
		$para3 = $row['p3'];
		$para4 = $row['p4'];

		echo "<section>";
				echo "	 <h2>$name</h2>";
				echo "	 <h3> \$$cost <h3/>";
				echo "	<img src=\"resources/brand$pageNum.jpg\"  title=\"$name brand\"/>";

				echo "	<img src=\"resources/shoe$pageNum.jpg\"  title=\"$name\"/>";
				echo "	<p>$para1</p>";
				echo "	<p>$para2</p>";
				echo "	<p>$para3</p>";
				echo "	<p>$para4</p>";
		displayStars($mysqli,$pageNum);
		echo "</section>";
	}

ratingForm($mysqli);








include('footer.php');
echo "</body>";

echo "</html>";


// Query to change index
function ratingForm($mysqli){
	echo "<form action=\"#\" method=\"POST\">";

	echo " <fieldset>";
	echo "	 	<input type=\"radio\" name=\"overAll\" value=\"1\">1 ";
	echo "	 	<input type=\"radio\" name=\"overAll\" value=\"2\"> 2";
	echo "	 	<input type=\"radio\" name=\"overAll\" value=\"3\"> 3";
	echo "	 	<input type=\"radio\" name=\"overAll\" value=\"4\">4 ";
	echo "	 	<input type=\"radio\" name=\"overAll\" value=\"5\"> 5";
	echo "	 	<input type=\"submit\" name=\"Rate\" value=\"Rate!\"></input>  ";
	echo " </fieldset>";
echo "</form>";
}

// Query to change rating
function handleRating($mysqli,$userId,$shoeId){

	$rateVal = $_REQUEST['overAll'];
	$runQ = "";
	//echo $rateVal;
	//check if rating is present
	$runQ = "Select * from shoerate WHERE shoeId='$shoeId' AND userId = '$userId'";

	if (!$result = $mysqli->query($runQ)) {
			echo "Error, handle";
	}
	// If no, create an insert query, if yes, update
	if($result->num_rows === 0) {
		$runQ = "INSERT INTO shoerate (shoeId,userId,overall) VALUES ('$shoeId','$userId',$rateVal)";
	} else {
		$runQ = "UPDATE shoerate SET overall=$rateVal WHERE shoeId='$shoeId' AND userId = '$userId'";
	}

	if (!$result = $mysqli->query($runQ)) {
			echo "Error, handle";
	}
}

// Function to display stars
// Query to change rating

function displayStars($mysqli,$shoeId){
	// Go through all table for that shoe id
	$runQ = "Select * from shoerate WHERE shoeId='$shoeId'";

	// Store an overall
	$sumVal = 0;
	$count = 0;

	if (!$result = $mysqli->query($runQ)) {
				echo "Error, handle";
	}
	echo "<p>";
	if($result->num_rows === 0) {
		echo " No rating";
	} 	else {
		while ($row = $result->fetch_assoc()) {
			$over = $row['overall'];

			$sumVal = $sumVal + $over;
			$count++;
		}
	// Calculate mean
	$meanVal = $sumVal/$count;
	echo round($meanVal);

	// Display stars
	for($i =0; $i<$meanVal; $i++) {
		echo "<img src=\"resources/star.jpg\"  title=\"Star!\"/>";
	}
	}

	echo "</p>";



// Display number of stars


}



// Generates main content
// function mainContent($result) {
// 	$movName = "";
// 	while ($row = $result->fetch_assoc()) {
// 		$fNam = $row['name'];
// 		$fImg = $row['image'];
// 		$fDes = $row['description'];
// 		$fId = $row['id'];

// 		echo "<section>";
// 		echo "	 <h2>$fNam</h2>";
// 		echo "	<img src=\"images/$fImg.jpg\"  title=\"$fNam\"/>";
// 		echo "	<p>$fDes</p>";
// 		echo "</section>";
// 		$movName = $fNam;
// 	}
// 	return $movName;
// }

// function showComments($result){
// 	echo "<table class=\"aside\"> ";
// 	echo "	<tr>";
// 	echo "		<th>User</th>";
// 	echo "		<th>Posted</th>";
// 	echo "		<th class=\"comment\">Comment</th>";
// 	echo "	</tr>";

// 	while ($row = $result->fetch_assoc()) {
// 		$ComUsr = $row['authorname'];
// 		$ComTim = $row['time'];
// 		$ComCom = $row['comment'];
// 		echo "	<tr>";
// 		echo "<td><a href=\"profile.php?usr=$ComUsr\">$ComUsr</a></td>";
// 		echo "<td>$ComTim</td>";
// 		echo "<td class=\"comment\">$ComCom</td>";
// 		echo "	</tr>";
// 	}

// 	echo "</table>";
// }

// // Query for a single movie
// function queryMovieDbSingle($mysqli,$pId){
// 	$runQ = "Select * from cw3_movie WHERE id=$pId";
// 	if (!$result = $mysqli->query($runQ)) {
// 		echo "Error, handle";
// 	}
// 	return $result;
// }
// // Query for all comments for a single movie
// function queryCommentDbMovie($mysqli,$nam){
// 		$runQ ="";
// 		if(isset($_REQUEST["old_order"])){
// 			$runQ = "Select * from cw3_comments WHERE moviename='$nam' ORDER BY time ASC";
// 		}
// 		else if(isset($_REQUEST["new_order"])){
// 				$runQ = "Select * from cw3_comments WHERE moviename='$nam' ORDER BY time DESC";
// 		}
// 		else if(isset($_REQUEST["user_order"])){
// 				$runQ = "Select * from cw3_comments WHERE moviename='$nam' ORDER BY authorname";
// 		}
// 		else {
// 			$runQ = "Select * from cw3_comments WHERE moviename='$nam'";
// 	}
// 	//echo "$runQ";

// 	if (!$result = $mysqli->query($runQ)) {
// 		echo "Error, handle";
// 	}
// 	return $result;
// }

// form to add comment
// function insertForm(){
// 	echo "<form action=\"#\" method=\"POST\"> ";

// 	echo "<fieldset>";
// 	echo "<label> Comment </label>";
// 	echo "<input type=\"text\" id=\"comment\" name=\"comment\" value=\"\" placeholder=\"Add Comment\">";
// 	echo "</fieldset>";

// 	echo "<fieldset>";
// 	echo "<input type=\"submit\" name=\"insert\" value=\"Add Comment\">";
// 	echo "</fieldset>";


// 	echo "<fieldset>";
// 	echo "<input type=\"submit\" name=\"old_order\" value=\"Sort by Oldest\">";
// 	echo "<input type=\"submit\" name=\"new_order\" value=\"Sort by Newest\">";
// 	echo "<input type=\"submit\" name=\"user_order\" value=\"Sort by User\">";
// 	echo "</fieldset>";

//  	echo " </form>";
// }

// // Query for a single movie
// function getMovieName($mysqli,$pId){
// 	$runQ = "Select * from cw3_movie WHERE id=$pId";
// 	if (!$result = $mysqli->query($runQ)) {
// 		echo "Error, handle";
// 	}
// 	$movName = "";
// 	while ($row = $result->fetch_assoc()) {
// 		$movName = $row['name'];
// 	}
// 	return $movName;
// }

// // Handle comments by adding to database
// function insertCommentDB($mysqli){
// 	// Need all data

// 	// authorname
// 	$autName = $_SESSION['login_user'];
// 	// moviename
// 	$pageID = $_REQUEST['id'];
// 	$movName = getMovieName($mysqli,$pageID);
// 	// time
// 	$date = date('Y-m-d H:i:s');
// 	// comment
// 	$comment = mysqli_real_escape_string($mysqli,$_REQUEST['comment']);

// 	// Create an insert query
// 	$runQ = "INSERT INTO cw3_comments (moviename,authorname,comment,time) VALUES ('$movName','$autName','$comment','$date')";

// 		if (!$result = $mysqli->query($runQ)) {
// 			echo "Error, handle";
// 	}
// }


?>

