<?php
	require 'database.php';
	require 'header.php';
	
	//Return a random 5 character ID for tags or pages	
	function getId() {
		$chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$id = "";
		for($i=0; $i<6; $i++) {
			$id = $id.$chars[rand(0, 61)];
		}
		return $id;
	}
	
	//If the user has added information to the title and description fields,
	// insert it into the database
	if(isset($_POST['page_title']) && isset($_POST['page_description'])) {
		//Get form information about new page
		$pageTitle = $conn->real_escape_string($_POST['page_title']);
		$pageDesc = $conn->real_escape_string($_POST['page_description']);
		$pageId = getId();
		
		//Make sure that the page title doesn't already exist
		if(valInDb("pages", "title", $pageTitle)) {
			echo "There already exists a page with the name $pageTitle.";
		} else {
			//Create new page
			if($pageTitle != '' && $pageDesc != '') {
				
				$query = "INSERT INTO pages (page_id, title, description) VALUES
					('$pageId', '$pageTitle', '$pageDesc')";
				$conn->query($query);
				
				$tags = explode(",", $_POST['tags']);
				
				//Add tags to the pages and insert new tags if necessary
				foreach($tags as $tag) {
					$tag = $conn->real_escape_string(trim($tag));
					$tagId = getTagId($tag);
					if($tagId == null) {
						$tagId = getId();
						while(valInDb("tag_names", "tag_id", $tagId)) {
							$tagId = getId();
						}	
					}
					
					
					if($tag != '' && !valInDb("tag_names", "tag_name", $tag)){	
						$query = "INSERT INTO tag_names (tag_id, tag_name)
							VALUES ('$tagId', '$tag')";
						$conn->query($query);
					}
					
					$query = "INSERT INTO tag_pages (tag_id, page_id)
						VALUES ('$tagId', '$pageId')";
					$conn->query($query);
					
				}
			}
		}
	}
?>

<h1>Create New Page</h1>
<form method="post" action="index.php">
	<input type="text" name="page_title" placeholder="Title"><br>
	<textarea rows="5" cols="40" name="page_description" placeholder="Description"></textarea><br>
	<input type="text" name="tags" placeholder="Tags (comma separated)"><br>
	<input type="submit">
</form>

<?php include 'footer.php'; ?>
