<?php
//include config
require_once('includes/config.php');

//show message from add / edit page
if(isset($_GET['delpost'])){ 
	$stmt = $db->prepare('DELETE FROM events WHERE event_id = :event_id') ;
	$stmt->execute(array(':event_id' => $_GET['delpost']));

	header('Location: events.php?action=deleted');
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
	  	window.location.href = 'events.php?delpost=' + id;
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
		echo '<h3>Event '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>Event Name</th>
		<th>Venue</th>
		<th>Date</th>
		<th>Action</th>
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

				<td>
					<a href="edit-event.php?id=<?php echo $row['event_id'];?>">Edit</a> | 
					<a href="javascript:delpost('<?php echo $row['event_id'];?>','<?php echo $row['event_title'];?>')">Delete</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-event.php'>Add Event</a></p>

</div>

</body>
</html>
