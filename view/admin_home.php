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
<p style="color:red;">Fee 0.00001</p>
<table id="wallets" class="table">
<thead>
<tr>
<th>Coin</th>
<th>Balance</th>
<th>Last Block</th>
<th>Synced Block</th>
<th>Diff</th>
</tr>
</thead>
<tbody>

<?php 
	foreach ($coins as $value) {
		var_dump($value);
		echo "<tr data-currency='$value->name'>";
		echo "<td>$value->name</td>";
		echo '<td>';
		echo satoshitize($value->balance);
		echo '</td>';
		echo '<td>';
		if($value->name == "XLR"){
			// create curl resource 
			$ch = curl_init(); 

			// set url 
			curl_setopt($ch, CURLOPT_URL, "https://solaris.blockexplorer.pro/api/getblockcount"); 

			//return the transfer as a string 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

			// $output contains the output string 
			$output = curl_exec($ch); 

			// close curl resource to free up system resources 
			curl_close($ch); 			
			echo $output;
		}
		
		echo '</td>';
		echo '<td>';
		echo $value->syncedBlock
		echo '</td>';
		echo '<td>';
		echo $value->diff
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
</script>