<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<h2>Auto Block</h2>
<?php

global $wpdb,$IP_globale,$IP_error,$found;


	if($_POST['update_autoblock'])
	{

		update_option('IPBLC_autoblock',$_POST['autoblock']);
		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>Block list Updated!</strong></p></div>";

	}

	$IPBLC_autoblock=get_option('IPBLC_autoblock');

?>

<BR>

<table>
<tr valign="top" valign="top">
<td style="width: 330px;" valign="top" valign="top">
<form method="post" ENCTYPE="multipart/form-data">
<textarea id="autoblock" name="autoblock" style="width: 300px; height: 250px;" class="regular-text"><?php echo $IPBLC_autoblock; ?></textarea><BR>

<BR>
<input type="submit" name="update_autoblock" id="update_autoblock" value="Save Changes" class="button-primary">
</form>
</td>

<td valign="top" valign="top">
	Add list of usernames which you want to block automatically on first login attempt.<BR><b>Each username per line.</b><BR>
</td>
</tr>
</table>
</div>