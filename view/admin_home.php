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
<th>Coin</th>
<th>Balance</th>
<th>Lastest Block</th>
<th>Synced Block</th>
<th>Diff</th>
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
		echo "<td class='lastestBlockAPI'>";
		echo "<input type='hidden' class='url' value='$value->lastestBlockAPI'/>";
		echo '</td>';
		echo '<td class="lastBlock">';
		echo $value->syncedBlock;
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
						echo ", ";
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
    <div class="col-md-2"><input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name" value="<?php echo $_GET["fullName"]; ?>"></div>
    <div class="col-md-2"><input type="text" class="form-control" id="name" name="name" placeholder="Shot Name" value="<?php echo $_GET["name"]; ?>"></div>
    <div class="col-md-2"><input type="number" class="form-control" id="port" name="port" placeholder="Port" value="<?php echo $_GET["port"]; ?>"></div>
	<div class="col-md-3"><input type="text" class="form-control" id="blockapiurl" name="blockapiurl" placeholder="URL Lastest Block API" value="<?php echo $_GET["blockapiurl"]; ?>"></div>
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
			$(this).hide();
			if($("#fullName").val() != "" && $("#name").val() != "" && $("#port").val() != ""){
				window.location = "?a=home&i=i&m=addcoin&fullname=" + $("#fullName").val() + "&name=" + $("#name").val() + "&port=" + $("#port").val() + "&blockapiurl=" + $("#blockapiurl").val();
			}else{
				alert('please fill form');
			}
		});

		$( ".lastestBlockAPI" ).each(function() {
		 	var url = $(this).children('.url').val();
			if(url != ""){
				$.get( "http://wallet.l3za.me/view/repeater.php?url=" + url, function( data ) {
					$(this).text( data );
				});
			}
		});
		
	});
	
	$('#wallets').sortTable();
	
</script>
