<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<h2>Add IP to Blacklist</h2>



<BR>

<B>NOTE:</B> After adding any IP to blacklist, please submit comment on IP-FINDER.ME to help others regarding the issue related to that specific IP.

<BR>





<?php

global $wpdb,$IP_globale,$IP_error,$found;



	if($_POST['blacklist'])

	{

		$IP=$_POST['blacklist'];







		if(filter_var($IP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))

		{

 			 // it's valid







			$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");



			$found=false;

			//$found=true;



			if(!$IP_in_DP)

			{





				$table=$wpdb->prefix."IPBLC_blacklist";

				$time=time();


/*
					$post_IP=$wpdb->insert( 

						$table, 

						array( 

							'IP' => $IP, 

							'timestamp' => $time

						), 

						array( 

							'%s', 

							'%d' 

						) 

					);
*/
				

					$wpdb->query("INSERT INTO $table (IP,timestamp) VALUES('$IP','$time')");

//$wpdb->print_error();



//---post data to ip-finder.me

$contextData = array ( 

                'method' => 'POST',

                'header' => "Connection: close\r\n". 

             "Referer: ".site_url()."\r\n");

 

// Create context resource for our request

$context = stream_context_create (array ( 'http' => $contextData ));

 

// Read page rendered as result of your POST request



$link="http://ip-finder.me/wp-content/themes/ipfinder/blacklist_add.php?IP=$IP&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'));

$post_to_cloud =  file_get_contents (

                  $link,  // page url

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

