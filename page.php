<?php
	require 'database.php';
	require 'header.php';
	if(!isset($_GET['page'])) {
?>

<h1>Pages on Brettipedia</h1>
<ul>
<?php
	$query = "SELECT title FROM pages ORDER BY title";
	$result = $conn->query($query);
	while($row = $result->fetch_assoc()) {
		$title = $row['title'];
		$urlTitle = urlencode($title);
		echo "<li><a href='page.php?page=$urlTitle'>".$title."</a></li>";
	}
?>	
</ul>

<?php
	}
	else {
		$title = $_GET['page'];
?>
		<h1><?php echo $title;?></h1>
		<p>
			<?php
				$query = "SELECT description FROM pages WHERE title='$title'";
				$result = $conn->query($query);
				
				echo ($result->fetch_assoc())['description'];
			?>
		</p>
		
		<?php
			$tags = getTags($title);
			if(sizeof($tags) > 0) {
				echo "<h2>Tags</h2>";
				foreach($tags as $tag) {
					$urlTag = urlencode($tag);
					echo "<a href='tag.php?tag=$urlTag'>$tag</a><br>";
				}
			}
			
		?>

<?php
	}
	include 'footer.php';
?>