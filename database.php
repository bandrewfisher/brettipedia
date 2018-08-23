<?php
	$conn = new mysqli("localhost", "root", "snowball", "brettipedia");
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	function valInDb($tableName, $colName, $value) {
		global $conn;
		$query = "SELECT * FROM $tableName WHERE $colName='$value'";
		$result = $conn->query($query);
		
		if($result->num_rows > 0) {
			return true;
		}
		return false;
	}
	
	function getPageId($title) {
		global $conn;
		$query = "SELECT page_id FROM pages WHERE title='$title'";
		$result = $conn->query($query);
		
		return ($result->fetch_assoc())['page_id'];
	}
	
	function getPageName($pageId) {
		global $conn;
		$query = "SELECT title FROM pages WHERE page_id='$pageId'";
		$result = $conn->query($query);
		
		return ($result->fetch_assoc())['title'];
	}
	
	function getTagId($tagName) {
		global $conn;
		$query = "SELECT tag_id FROM tag_names WHERE tag_name='$tagName'";
		$result = $conn->query($query);
		
		if($result->num_rows < 1) {
			return null;
		}
		
		return ($result->fetch_assoc())["tag_id"];
	}
	
	function getTagName($tagId) {
		global $conn;
		$query = "SELECT tag_name FROM tag_names WHERE tag_id='$tagId'";
		$result = $conn->query($query);
		
		return ($result->fetch_assoc())['tag_name'];
	}
	
	//Get an array of the tags associated with a page title
	function getTags($title) {
		global $conn;
		$pageId = getPageId($title);
		$query = "SELECT tag_id FROM tag_pages WHERE page_id='$pageId'";
		$result = $conn->query($query);
		
		$tags = [];
		while($row = $result->fetch_assoc()) {
			array_push($tags, getTagName($row['tag_id']));
		}
		return $tags;
	}
	
	//Get an array of the pages that have a certain tag
	function getPages($tag) {
		global $conn;
		$tagId = getTagId($tag);
		
		$query = "SELECT page_id FROM tag_pages WHERE tag_id='$tagId'";
		$result = $conn->query($query);
		
		$pages = [];
		while($row = $result->fetch_assoc()) {
			array_push($pages, getPageName($row['page_id']));
		}
		
		return $pages;
	}
?>