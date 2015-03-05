<?php

if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );

?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>  
<h2>Add IP to Blacklist</h2>
<BR>
<B>NOTE:</B> After adding any IP to blacklist, please submit comment on IP-FINDER.ME to help others regarding the issue related to that specific IP.

<BR>
<?php

	global $wpdb,$IP_globale,$IP_error,$found;

	if(isset($_POST['blacklist']))
	{


		$IP=sanitize_text_field($_POST['blacklist']);

		if(filter_var($IP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
		{

 			 // it's valid
			$IP_in_DP=$wpdb->get_var($wpdb->prepare("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP=%s",$IP));

			$found=false;

			//$found=true;

			if(!$IP_in_DP)
			{

				$table=$wpdb->prefix."IPBLC_blacklist";
				$time=time();

				$sql=$wpdb->prepare("INSERT INTO $table (IP,timestamp,visits,lastvisit) VALUES(%s,%d,%d,%d)",array($IP,$time,0,0));

				//echo "<pre>";
					//print_r($sql);
				//echo "</pre>";

				$wpdb->query($sql);

				//$wpdb->print_error();

				//---post data to ip-finder.me
				post_blacklist_add($IP);

			}
			else
			{
				$found=true;
			}


			if(!$found)
			{
			echo "<div id='setting-error-settings_updated' class='updated settings-error'>
				<p><strong>$IP added to blacklist successfully!</strong></p></div>";
			}
			else
			{
			echo "<div id='setting-error-settings_updated' class='updated settings-error' style='color: #FF0000;'>
				<p><strong>$IP already added to blacklist!</strong></p></div>";
			}

		}
		else
		{
			  // it's not valid
		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>$IP is not valid IP address.</strong></p></div>";

		}

	}

?>
<BR><BR>
<form method=post>
<table>
<tr valign="top">
<td>
IP: 
</td>
<td>
<input type=input name="blacklist" id="blacklist" value="" class="regular-text" style="width: 180px;">
</td>
</tr>

<tr valign="top" valign="top">
<td colspan=2 height=60>
<input type="submit" name="add_ip" id="add_ip" value="Add IP" class="button-primary">
</td>
</tr>
</table>
</form>
</div>
