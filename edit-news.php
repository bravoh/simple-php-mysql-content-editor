<?php //include config
require_once('includes/config.php');

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit News</title>
  <link rel="stylesheet" href="news-style/normalize.css">
  <link rel="stylesheet" href="news-style/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="./">Index</a></p>

	<h2>Edit News Item</h2>


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		extract($_POST);

		//very basic validation
		if($news_id ==''){
			$error[] = 'This action action cannot be completed... news item is missing a valid id!.';
		}

		if($news_date ==''){
			$error[] = 'Please enter a valid date.';
		}

		if($news_subj ==''){
			$error[] = 'Please enter the description of the news.';
		}

		if($news_message ==''){
			$error[] = 'Please enter the news content.';
		}

		if(!isset($error)){

			try {

				//insert into database
				$stmt = $db->prepare('UPDATE news 
					                  SET news_subj = :news_subj, news_message = :news_message, news_author = :news_author, news_date = :news_date
					                  WHERE news_id = :news_id') ;
				$stmt->execute(array(
					':news_subj'    => $news_subj,
					':news_message' => $news_message,
					':news_author'  => $news_author,
					':news_date'    => $news_date,
					':news_id'      => $news_id 
				));
				//redirect to index page
				header('Location: index.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $db->prepare('SELECT news_id, news_subj, news_message, news_author, news_date FROM news WHERE news_id = :news_id') ;
			$stmt->execute(array(':news_id' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		
		<input type='hidden' name='news_id' value='<?php echo $row['news_id'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='news_subj' value='<?php echo $row['news_subj'];?>'></p>

		<p><label>Description</label><br />
		<textarea name='news_message' cols='60' rows='10'><?php echo $row['news_message'];?></textarea></p>

		<p><label>Date</label><br />
		<input type='date' name='news_date' value='<?php echo $row['news_date'];?>'></p>

		<p><label>Source</label><br />
		<input type='text' name='news_author' value='<?php echo $row['news_author'];?>'></p>
		



		<p><input type='submit' name='submit' value='Update'></p>

		

	</form>

</div>

</body>
</html>	
