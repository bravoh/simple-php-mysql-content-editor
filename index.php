<?php
//include config
require_once('includes/config.php');

//show message from add / edit page
if(isset($_GET['delpost'])){ 

	$stmt = $db->prepare('DELETE FROM news WHERE news_id = :news_id') ;
	$stmt->execute(array(':news_id' => $_GET['delpost']));

	header('Location: index.php?action=deleted');
	exit;
} 

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>News/Events</title>
  <link rel="stylesheet" href="news-style/normalize.css">
  <link rel="stylesheet" href="news-style/main.css">
  <script language="JavaScript" type="text/javascript">
  function delpost(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'index.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">

	<?php include('menu.php');?>

	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>News Item '.$_GET['action'].'.</h3>'; 
	} 
	?>


    <h1>News</h1>
	<table>
	<tr>
		<th>Title</th>
		<th>Author</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT news_id, news_subj, news_author, news_date FROM news ORDER BY news_id DESC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['news_subj'].'</td>';
				echo "<td>" .$row["news_author"]. "</td>";
				echo '<td>'.date('jS M Y', strtotime($row['news_date'])).'</td>';
				?>

				<td>
					<a href="edit-news.php?id=<?php echo $row['news_id'];?>">Edit</a> | 
					<a href="javascript:delpost('<?php echo $row['news_id'];?>','<?php echo $row['news_subj'];?>')">Delete</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>
	<p><a href='add-news.php'>Add A News Item</a></p>
	<hr>

	<h1>Events</h1>
	<table>
	<tr>
		<th>Event Name</th>
		<th>Venue</th>
		<th>Date</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT event_id, event_title, event_venue, event_date FROM events ORDER BY event_id DESC');
			while($row = $stmt->fetch()){
				echo '<tr>';
				echo '<td>'.$row['event_title'].'</td>';
				echo "<td>".$row['event_venue']."</td>";
				echo '<td>'.date('jS M Y', strtotime($row['event_date'])).'</td>';
				?>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-event.php'>Add Event</a></p>
	<p>NOTE: to delete or edit events, <a href="events.php">clidk here</a></p>
	<hr>

</div>

</body>
</html>
