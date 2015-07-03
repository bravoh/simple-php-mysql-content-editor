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
		if($event_id ==''){
			$error[] = 'This action action cannot be completed... event is missing a valid id!.';
		}

		if($event_date ==''){
			$error[] = 'Please enter a valid date.';
		}

		if($event_title ==''){
			$error[] = 'Please enter the title of the event.';
		}

		if($event_desc ==''){
			$error[] = 'Please enter the Event Description.';
		}

		if(!isset($error)){

			try {

				//insert into database
				$stmt = $db->prepare('UPDATE events 
					                  SET event_date = :event_date, event_title = :event_title, event_desc = :event_desc, event_venue = :event_venue
					                  WHERE event_id = :event_id') ;
				$stmt->execute(array(
					':event_date'    => $event_date ,
					':event_title'   => $event_title,
					':event_desc'    => $event_desc,
					':event_venue'   => $event_venue,
					':event_id'      => $event_id 
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

			$stmt = $db->prepare('SELECT event_id, event_date, event_title, event_desc, event_venue FROM events WHERE event_id = :event_id') ;
			$stmt->execute(array(':event_id' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		
		<input type='hidden' name='event_id' value='<?php echo $row['event_id'];?>'>

		<p><label>Event Title</label><br />
		<input type='text' name='event_title' value='<?php echo $row['event_title'];?>'></p>

		<p><label>Description</label><br />
		<textarea name='event_desc' cols='60' rows='10'><?php echo $row['event_desc'];?></textarea></p>

		<p><label>Date</label><br />
		<input type='date' name='event_date' value='<?php echo $row['event_date'];?>'></p>

		<p><label>Venue</label><br />
		<input type='text' name='event_venue' value='<?php echo $row['event_venue'];?>'></p>

		<p><input type='submit' name='submit' value='Update'></p>

	</form>

</div>

</body>
</html>	
