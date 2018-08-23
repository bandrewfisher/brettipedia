<?php
	require 'header.php';
	require 'database.php';
	//validate('tag.php');
	if(!isset($_GET['tag'])) {
?>
<h1>Tags on Brettipedia</h1>
<ul>
<?php
	$query = "SELECT tag_name FROM tag_names ORDER BY tag_name";
	$result = $conn->query($query);
	while($row = $result->fetch_assoc()) {
		$tagName = $row['tag_name'];
		$urlName = urlencode($tagName);
		echo "<li><a href='tag.php?tag=$urlName'>".$tagName."</a></li>";
	}
?>	
</ul>

<?php
	}
	else {
		$tagName = $_GET['tag'];
?>

<h1><?php echo $tagName;?></h1>

<?php
	$pages = getPages($tagName);
	if(sizeof($pages) > 0) {
		echo "<h2>Pages</h2>";
		foreach($pages as $page) {
			$urlPage = urlencode($page);
			echo "<a href='page.php?page=$urlPage'>$page</a><br>";
		}
	}
	
?>


<?php
	}
	include 'footer.php';
?>