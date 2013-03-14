<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<h2>Add Username to Blacklist</h2>






<?php

global $wpdb,$USER_globale,$USER_error,$found;



	if($_POST['blacklist'])
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


/*
					$post_IP=$wpdb->insert( 

						$table, 

						array( 

							'USERNAME' => $USER, 

							'timestamp' => $time

						), 

						array( 

							'%s', 

							'%d' 

						) 

					);
*/


					$wpdb->query("INSERT INTO $table (USERNAME,timestamp) VALUES('$USER','$time')");
//$wpdb->print_error();



		//---post blacklist data to ip-finder.me

		$contextData = array ( 
		'method' => 'POST',
		'header' => "Connection: close\r\n". 
		"Referer: ".site_url()."\r\n"); 

		$context = stream_context_create (array ( 'http' => $contextData ));


		$USER2=urlencode($USER);

$link="http://ip-finder.me/wp-content/themes/ipfinder/blacklist_user_add.php?USER=$USER2&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'));

		$post_to_cloud =  file_get_contents (
		$link,
		false,
		$context);





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

