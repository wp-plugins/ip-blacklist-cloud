<?php

if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );



?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>  

<h2>Blacklist IP Range</h2>
<BR>

<b style="color: #990000">Any visitor found in provided rage will not get access to site.</b>
<?php

global $wpdb,$IP_globale,$IP_error,$found;


	if(isset($_POST['update_range']))
	{
		$range=$_POST['ip_range'];
	
		$range=str_replace(" ","",$range);
		update_option('IPBLC_ip_range',$range);
		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>Range Updated!</strong></p></div>";

	}

	$IPBLC_ip_range=get_option('IPBLC_ip_range');

?>

<BR>

<table>
<tr valign="top" valign="top">
<td style="width: 330px;" valign="top" valign="top">
<form method="post" ENCTYPE="multipart/form-data">
<textarea id="ip_range" name="ip_range" style="width: 300px; height: 250px;" class="regular-text"><?php echo $IPBLC_ip_range; ?></textarea><BR>

<BR>
<input type="submit" name="update_range" id="update_range" value="Save Changes" class="button-primary">
</form>
</td>

<td valign="top" valign="top">Add IP Ranges. Each range should be on single line. Example: <BR>1.0.0.0-1.20.255.255<BR>110.20.0.0-110.20.255.255<BR><BR>
<b style="color: #FF0000;">Note: No space between x.x.x.x-x.x.x.x<BR>Leave one blank line in the end of text box.</b><BR>

<h4>Your Current IP: <?php echo $_SERVER['REMOTE_ADDR']; ?></h4></td>
</tr>
</table>
</div>
