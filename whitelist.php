<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<h2>Whitelist</h2>
<?php

global $wpdb,$IP_globale,$IP_error,$found;


	if($_POST['update_whitelist'])
	{

		update_option('IPBLC_whitelist',$_POST['whitelist']);
		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>Whitelist Updated!</strong></p></div>";

	}

	$IPBLC_whitelist=get_option('IPBLC_whitelist');

?>

<BR>

<table>
<tr valign="top" valign="top">
<td style="width: 330px;" valign="top" valign="top">
<form method="post" ENCTYPE="multipart/form-data">
<textarea id="whitelist" name="whitelist" style="width: 300px; height: 250px;"><?php echo $IPBLC_whitelist; ?></textarea><BR>

<BR>
<input type="submit" name="update_whitelist" id="update_whitelist" value="Save Changes" class="button-primary">
</form>
</td>

<td valign="top" valign="top">Add IP addresses to whitelist and save your self from auto blacklisting for failed login attempts. Each IP should on single line. Example: <BR>1.1.1.1<BR>1.1.1.2<BR>1.1.1.3<BR><BR>
<b style="color: #FF0000;">Note: Leave one blank line in the end of text box.</b><BR>

<h4>Your Current IP: <?php echo $_SERVER['REMOTE_ADDR']; ?></h4></td>
</tr>
</table>
</div>

