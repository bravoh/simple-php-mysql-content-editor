<?php //include config
require_once('includes/config.php');

//if not logged in redirect to login page
//if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>KTTI Events/ News</title>
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

	<h2>Add Event</h2>

	<?php
	//if form has been submitted process it
	if(isset($_POST['submit'])){
	//collect form data
		extract($_POST);
		//very basic validation
		if($event_title ==''){
			$error[] = 'Please enter the title.';
		}

		if($event_desc ==''){
			$error[] = 'Please enter the event description.';
		}

		if ($event_date =='') {
			$error[] = 'Please enter the event date.';
		}

		if($event_venue ==''){
			$error[] = 'Please enter the event venue.';
		}
        
		
		if(!isset($error)){

			try {
				///include("uploader.php");
				$stmt = $db->prepare('INSERT INTO events (event_title, event_desc,event_venue, event_date) 
					                                      VALUES (:event_title, :event_desc, :event_venue, :event_date)') ;
				//$img= resize();
				$stmt->execute(array(
					':event_title' => $event_title,
					':event_desc'  => $event_desc,
					':event_venue' => $event_venue,
					':event_date'  => $event_date
				));
				$event_id = $db->lastInsertId();

				//redirect to index page
				header('Location: events.php?action=added');
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

		<p><label>Event Title</label><br />
		<input type='text' name='event_title' size="60" value='<?php if(isset($error)){ echo $_POST['event_title'];}?>'></p>

		<p><label>Event Description</label><br />
		<textarea name='event_desc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['event_desc'];}?></textarea></p>
        
        <p><label>Date</label><br />
		<input type='date' name='event_date' size="60" value='<?php if(isset($error)){ echo $_POST['event_date'];}?>'></p>
		
		<p><label>Venue</label><br />
		<input type='text' name='event_venue' size="60" value='<?php if(isset($error)){ echo $_POST['event_venue'];}?>'></p>

        <p><input type='submit' name='submit' value='Submit'></p>

	</form>

</div>
