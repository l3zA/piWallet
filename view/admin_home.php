<?php if (!defined("IN_WALLET")) { die("Auth Error!"); } ?>
<?php
if (!empty($error))
{
    echo "<p style='font-weight: bold; color: red;'>" . $error['message']; "</p>";
}
if (!empty($msg))
{
    echo "<p style='font-weight: bold; color: green;'>" . $msg['message']; "</p>";
}
?>
<p><?php echo $lang['WALLET_HELLO']; ?>, <strong><?php echo $user_session; ?></strong>!  <?php if ($admin) {?><strong><font color="red">[Admin]</font><?php }?></strong></p>
<table id="wallets" class="table table-responsive">
<thead>
<tr>
<th onclick="sortTable(0)">Coin</th>
<th onclick="sortTable(1)">Balance</th>
<th onclick="sortTable(2)">Lastest Block</th>
<th onclick="sortTable(3)">Synced Block</th>
<th onclick="sortTable(4)">Diff</th>
</tr>
</thead>
<tbody>

<?php 
	function isAssoc(array $arr)
	{
		if (array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}

	foreach ($coins as $value) {
		echo "<tr data-currency='$value->name'>";
		echo "<td>$value->name</td>";
		echo '<td>';
		echo satoshitize($value->balance);
		echo '</td>';
		echo '<td>';
		$lastBlock = "";
		$haveApiLastestBlock = false;
		$url = "";
		switch($value->name){
			case "XLR";
				$haveApiLastestBlock = true;
				$url = "https://solaris.blockexplorer.pro/api/getblockcount";
				break;
			case "SPK";
				$haveApiLastestBlock = true;
				$url = "http://explorer.sparks.gold/api/getblockcount";
				break;
			default:
				$haveApiLastestBlock = false;
				echo "-";
				break;
		}
		
		if($haveApiLastestBlock){
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$lastBlock = curl_exec($ch); 
			curl_close($ch); 			
			echo $lastBlock;
		}
		
		echo '</td>';
		echo '<td>';
		if($lastBlock!=""){
			if($lastBlock>$value->syncedBlock){
				echo "<span style='color:red'>$value->syncedBlock</span>";
			}else{
				echo "<span style='color:green'>$value->syncedBlock</span>";
			}
		}else{
			echo $value->syncedBlock;
		}
		
		echo '</td>';
		echo '<td>';
		if(is_numeric($value->diff) || is_bool($value->diff)){
			echo number_format($value->diff,6, '.', '');
		}else{
			if(isAssoc($value->diff)){
				$numItems = count($value->diff);
				$i = 0;
				foreach ($value->diff as $k => $v){
					echo $k;
					echo " : ";
					echo number_format($v,6, '.', '');
					if(++$i != $numItems) {
						echo ",";
					}
				}
			}else{
				echo number_format($value->diff,6, '.', '');
			}
		}
		
		
		echo '</td>';
		echo "</tr>";
	}

?>
</tbody>
</table>
<br />
<a href="?" class="btn btn-default">Go back to wallet</a>
<br /><br />
<p><strong>Add Coin</strong></p>
<form action="index.php?a=home" method="POST" class="clearfix" id="coinform">
    <div class="col-md-2"><input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name"></div>
    <div class="col-md-2"><input type="text" class="form-control" id="name" name="name" placeholder="Shot Name"></div>
    <div class="col-md-2"><input type="number" class="form-control" id="port" name="port" placeholder="Port"></div>
    <div class="col-md-2">
	<a class="btn btn-default" href="#" id="btnAddCoin">Add</a>
	</div>
</form>
<br /><br />
<p>List of all users:</p>
<table class="table table-bordered table-striped" id="userlist">
<thead>
   <tr>
      <td nowrap>Username</td>
      <td nowrap>Created</td>
      <td nowrap>Is admin?</td>
      <td nowrap>Is locked?</td>
      <td nowrap>IP</td>
      <td nowrap>Info</td>
      <td nowrap>Delete</td>
   </tr>
</thead>
<tbody>
   <?php
   foreach($userList as $user) {
      echo '<tr>
               <td>' . $user['username'] . '</td>
               <td>' . $user['date'] . '</td>
               <td>' . ($user['admin'] ? '<strong>Yes</strong> <a href="?a=home&m=deadmin&i=' . $user['id'] . '">De-admin</a>' : 'No <a href="?a=home&m=admin&i=' . $user['id'] . '">Make admin</a>') . '</td>
               <td>' . ($user['locked'] ? '<strong>Yes</strong> <a href="?a=home&m=unlock&i=' . $user['id'] . '">Unlock</a>' : 'No <a href="?a=home&m=lock&i=' . $user['id'] . '">Lock</a>') . '</td>
               <td>' . $user['ip'] . '</td>
               <td>' . '<a href="?a=info&i=' . $user['id'] . '">Info</a>' . '</td>
                       <td>' . '<a href="?a=home&m=del&i=' . $user['id'] . '" onclick="return confirm(\'Are you sure you really want to delete user ' . $user['username'] . ' (id=' . $user['id'] . ')?\');">Delete</a>' . '</td>
            </tr>';
   }
   ?>
   </tbody>
</table>
<script>
	$(document).ready(function(){
		$("#btnAddCoin").on('click', function(){
			$(this).attr('disabled', 'disabled');
			if($("#fullName").val() != "" && $("#name").val() != "" && $("#port").val() != ""){
				window.location = "?a=home&i=i&m=addcoin&fullname=" + $("#fullName").val() + "&name=" + $("#name").val() + "&port=" + $("#port").val();
			}else{
				alert('please fill form');
			}
		});
		
	});
	
	function sortTable(n) {
	  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	  table = document.getElementById("wallets");
	  switching = true;
	  // Set the sorting direction to ascending:
	  dir = "asc"; 
	  /* Make a loop that will continue until
	  no switching has been done: */
	  while (switching) {
		// Start by saying: no switching is done:
		switching = false;
		rows = table.getElementsByTagName("TR");
		/* Loop through all table rows (except the
		first, which contains table headers): */
		for (i = 1; i < (rows.length - 1); i++) {
		  // Start by saying there should be no switching:
		  shouldSwitch = false;
		  /* Get the two elements you want to compare,
		  one from current row and one from the next: */
		  x = rows[i].getElementsByTagName("TD")[n];
		  y = rows[i + 1].getElementsByTagName("TD")[n];
		  /* Check if the two rows should switch place,
		  based on the direction, asc or desc: */
		  if (dir == "asc") {
			if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
			  // If so, mark as a switch and break the loop:
			  shouldSwitch= true;
			  break;
			}
		  } else if (dir == "desc") {
			if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
			  // If so, mark as a switch and break the loop:
			  shouldSwitch= true;
			  break;
			}
		  }
		}
		if (shouldSwitch) {
		  /* If a switch has been marked, make the switch
		  and mark that a switch has been done: */
		  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
		  switching = true;
		  // Each time a switch is done, increase this count by 1:
		  switchcount ++; 
		} else {
		  /* If no switching has been done AND the direction is "asc",
		  set the direction to "desc" and run the while loop again. */
		  if (switchcount == 0 && dir == "asc") {
			dir = "desc";
			switching = true;
		  }
		}
	  }
	}
</script>