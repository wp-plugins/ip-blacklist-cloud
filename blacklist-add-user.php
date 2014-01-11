<?php

if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );

?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>  
<h2>Add Username to Blacklist</h2>
<?php

	global $wpdb,$USER_globale,$USER_error,$found;

	if(isset($_POST['blacklist']))
	{
		$USER=$_POST['blacklist'];

	$USER=urldecode($USER);
	$USER=str_replace("\'","'",$USER);
	$USER=str_replace("\\\'","'",$USER);
	$USER=str_replace("\\\"",'\"',$USER);
	$USER=str_replace("\\\"",'"',$USER);
	$USER=str_replace("\"","&quot;",$USER);


		if($USER)
		{

 			 // it's valid

			$USER_in_DB=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_usernames WHERE USERNAME=\"$USER\"");

			$found=false;
			//$found=true;
			if(!$USER_in_DB)
			{

				$table=$wpdb->prefix."IPBLC_usernames";
				$time=time();

				$wpdb->query("INSERT INTO $table (USERNAME,timestamp,visits,lastvisit) VALUES('$USER','$time',0,0)");
				//$wpdb->print_error();

				//---post blacklist data to ip-finder.me


				$USER2=urlencode($USER);
				post_blacklist_add_user($USER2);
			}
			else
			{
				$found=true;
			}

			if(!$found)
			{
			echo "<div id='setting-error-settings_updated' class='updated settings-error'>

				<p><strong>$USER added to blacklist successfully!</strong></p></div>";
			}
			else
			{
			echo "<div id='setting-error-settings_updated' class='updated settings-error' style='color: #FF0000;'>

				<p><strong>$USER already added to blacklist!</strong></p></div>";
			}

		}		
	}

?>
<BR><BR>

<form method=post>

<table>

<tr valign="top">

<td>

Username: 

</td>

<td>

<input type=input name="blacklist" id="blacklist" value="" class="regular-text" style="width: 180px;">

</td>

</tr>



<tr valign="top" valign="top">

<td colspan=2 height=60>

<input type="submit" name="add_user" id="add_user" value="Add User" class="button-primary">

</td>

</tr>

</table>

</form>

</div>

