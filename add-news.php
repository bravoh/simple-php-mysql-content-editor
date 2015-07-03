<?php //include config
require_once('includes/config.php');

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>News/Events</title>
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

	<h2>Add a News Item</h2>

	<?php
	//if form has been submitted process it
	if(isset($_POST['submit'])){
	//collect form data
		extract($_POST);
		//very basic validation
		if($news_subj ==''){
			$error[] = 'Please enter the title.';
		}

		if($news_message ==''){
			$error[] = 'Please enter the description.';
		}

		if($news_author ==''){
			$error[] = 'Please enter the news Author.';
		}

		
		if(!isset($error)){

			try {
				//insert into database
				$stmt = $db->prepare('INSERT INTO news (news_subj,news_message,news_author, news_date) 
					                            VALUES (:news_subj, :news_message, :news_author, :news_date)') ;
			
				$stmt->execute(array(
					':news_subj'=> $news_subj,
					':news_message' => $news_message,
					':news_author' => $news_author,
					':news_date' => date('Y-m-d H:i:s')
				));
				$news_id = $db->lastInsertId();
				//add categories

				//redirect to index page
				header('Location: index.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post' enctype="multipart/form-data">

		<p><label>Title</label><br />
		<input type='text' name='news_subj' size="60" value="<?php if(isset($error)){ echo $_POST['news_subj'];}?>"></p>

		<p><label>Description</label><br />
		<textarea name='news_message' cols='60' rows='2'><?php if(isset($error)){ echo $_POST['news_message'];}?></textarea></p>

		
		<p><label>Content</label><br />
		<textarea name='news_author' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['news_author'];}?></textarea></p>

		<p><label>Source/Author</label><br />
		<input type='text' name='news_author' size="60" value="<?php if(isset($error)){ echo $_POST['news_author'];}?>"></p>
		
		<p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
