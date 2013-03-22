<?php
/*
Plugin Name: IP Blacklist Cloud
Plugin URI: http://wordpress.org/extend/plugins/ip-blacklist-cloud/
Description: Blacklist IP Addresses from visiting your WordPress website and block usernames from spamming.
Version: 1.9
Author: Adeel Ahmed
Author URI: http://demo.ip-finder.me/demo-details/
*/


function ip_added()
{
	global $wpdb,$found,$IP_global, $IP_error;

	$IP=$_GET['blacklist'];
	$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");

	$found=false;

	if(!$IP_in_DP)
	{

		if(filter_var($IP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
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


		//---post blacklist data to ip-finder.me

		$contextData = array ( 
		'method' => 'POST',
		'header' => "Connection: close\r\n". 
		"Referer: ".site_url()."\r\n"); 

		$context = stream_context_create (array ( 'http' => $contextData ));


$link="http://ip-finder.me/wp-content/themes/ipfinder/blacklist_add.php?IP=$IP&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'));

		$post_to_cloud =  file_get_contents (
		$link,
		false,
		$context);

		}
		else
		{
			$found=true;
			$IP_error=true;
		}	
	}
	else
	{
		$found=true;
	}

	$IP_global=$IP;
}








function user_added()
{
	global $wpdb,$found,$USER_global, $USER_error;

	$USER=$_GET['blacklistuser'];
	$USER=urldecode($USER);
	$USER=str_replace("\'","'",$USER);

	$USER=str_replace("\\\'","'",$USER);
	$USER=str_replace("\\\"",'\"',$USER);
	$USER=str_replace("\\\"",'"',$USER);
	$USER2=str_replace("\"","&quot;",$USER);

	$USER_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_usernames WHERE USERNAME=\"$USER2\"");

	$found=false;

	if(!$USER_in_DP)
	{

		if($USER)
		{

		$table=$wpdb->prefix."IPBLC_usernames";
		$time=time();
		//$USERX=str_replace('"',"\\\"",$USER);

/*
			$post_IP=$wpdb->insert( 
				$table, 
				array( 
					'USERNAME' => "$USER2", 
					'timestamp' => $time
				), 
				array( 
					'%s', 
					'%d' 
				) 
			);

*/

					$wpdb->query("INSERT INTO $table (USERNAME,timestamp) VALUES('$USER2','$time')");

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
			$USER_error=true;
		}	
	}
	else
	{
		$found=true;
	}

	$USER_global=$USER;
}



function ip_added_message()
{

	global $found,$IP_global,$IP_error;
	$IP=$IP_global;


	if(!$found)
	{

?>
<style>
#IPBLC_message_blacklist
{

	position: fixed;
	bottom: 8px;
	float: right;
	right: 8px;
	border:1px solid #99FF99;
	background-color: #DDFFDD;
	font-size: 20px;
	//font-weight: bold;
	padding: 12px;
	color: #000000;
}
</style>

<?php

	echo "<div id=\"IPBLC_message_blacklist\">$IP added to blacklist. Please comment on <a href=\"http://ip-finder.me/wpip?IP=$IP\" target=\"_blank\">IP-FINDER.ME</a></div>";

	}
	else
	{
?>

<style>
#IPBLC_message_blacklist
{
	position: fixed;
	bottom: 8px;
	float: right;
	right: 8px;
	border:1px solid #FF9999;
	background-color: #FFDDDD;
	font-size: 20px;
	//font-weight: bold;
	padding: 12px;
	color: #000000;
}
</style>

<?php

		if(!$IP_error)
		{
			echo "<div id=\"IPBLC_message_blacklist\">$IP already added to blacklist.</div>";
		}
		else
		{
			echo "<div id=\"IPBLC_message_blacklist\">$IP is not valid IP Address.</div>";
		}

	}

	echo "<script>jQuery('#IPBLC_message_blacklist').delay(8500).fadeOut(6000); jQuery('#IPBLC_message_blacklist').click(function(){ jQuery(this).hide(); });</script>";

}










function user_added_message()
{

	global $found,$USER_global,$USER_error;
	$USER=$USER_global;


	$USER=str_replace('\"','"',$USER);
	$USER=str_replace("\'","'",$USER);
	$USER=str_replace("\\\'","'",$USER);

	if(!$found)
	{

?>
<style>
#IPBLC_message_blacklist
{

	position: fixed;
	bottom: 8px;
	float: right;
	right: 8px;
	border:1px solid #99FF99;
	background-color: #DDFFDD;
	font-size: 20px;
	//font-weight: bold;
	padding: 12px;
	color: #000000;
}
</style>

<?php

	echo "<div id=\"IPBLC_message_blacklist\">$USER added to blacklist.</a></div>";

	}
	else
	{
?>

<style>
#IPBLC_message_blacklist
{
	position: fixed;
	bottom: 8px;
	float: right;
	right: 8px;
	border:1px solid #FF9999;
	background-color: #FFDDDD;
	font-size: 20px;
	//font-weight: bold;
	padding: 12px;
	color: #000000;
}
</style>

<?php

		if(!$USER_error)
		{
			echo "<div id=\"IPBLC_message_blacklist\">$USER already added to blacklist.</div>";
		}

	}

	echo "<script>jQuery('#IPBLC_message_blacklist').delay(8500).fadeOut(6000); jQuery('#IPBLC_message_blacklist').click(function(){ jQuery(this).hide(); });</script>";

}


function blacklist_failed_login()
{

	include "blacklist-failed-login.php";


}

function page_IPBLC_actions() 
{  


	global $wpdb;
	$newFailed=0;
	$table1=$wpdb->prefix."IPBLC_login_failed";
	$table2= $wpdb->prefix."IPBLC_blacklist";
	$countMain="";

	$rr=$wpdb->get_results("SELECT * FROM $table1 t1 WHERE NOT EXISTS (SELECT 1 FROM $table2 t2 WHERE t1.IP = t2.IP)");

	//print_r($rr);

	if($rr)
	{
		$newFailed=count($rr);
		$countMain='<span class="awaiting-mod count-'.$newFailed.'"><span class="pending-count">'.$newFailed.'</span></span>';
	}

	if($newFailed==0)
	{
		$newFailed="";
		$countMain="";
	}

	if($newFailed>0)
	{
	add_menu_page( "IP Blacklist", "IP Blacklist $countMain", "manage_options", "wp-IPBLC","",plugins_url()."/ip-blacklist-cloud/icon.png");
	}
	else
	{
	add_menu_page( "IP Blacklist", "IP Blacklist", "manage_options", "wp-IPBLC","",plugins_url()."/ip-blacklist-cloud/icon.png");
	}
	add_submenu_page( "wp-IPBLC", "Settings", "Settings", "manage_options", "wp-IPBLC", "blacklist_settings" );

	add_submenu_page( "wp-IPBLC", "IP Blacklist", "IP Blacklist", "manage_options", "wp-IPBLC-list", "blacklist_tool" );
	add_submenu_page( "wp-IPBLC", "Add IP to Blacklist", "Add IP to Blacklist", "manage_options", "wp-IPBLC-Add", "blacklist_add" );

	add_submenu_page( "wp-IPBLC", "Username Blacklist", "User Blacklist", "manage_options", "wp-IPBLC-list-user", "blacklist_tool_user" );
	add_submenu_page( "wp-IPBLC", "Add username to Blacklist", "Add User to Blacklist", "manage_options", "wp-IPBLC-Add-User", "blacklist_add_user" );

	if($newFailed>0)
	{
	add_submenu_page( "wp-IPBLC", "Failed Login", "<font color=red>Failed Login ($newFailed)</font>", "manage_options", "wp-IPBLC-failed-login", "blacklist_failed_login" );
	}
	else
	{
	add_submenu_page( "wp-IPBLC", "Failed Login", "Failed Login", "manage_options", "wp-IPBLC-failed-login", "blacklist_failed_login" );
	}
	add_submenu_page( "wp-IPBLC", "Blacklist Statistics", "Blacklist Statistics", "manage_options", "wp-IPBLC-stats", "blacklist_stats" );

	add_submenu_page( "wp-IPBLC", "Support", "Support", "manage_options", "wp-IPBLC-support", "blacklist_support" );



	$IPBLC_cloud_email=get_option('IPBLC_cloud_email');
	$IPBLC_cloud_key=get_option('IPBLC_cloud_key');

	if($IPBLC_cloud_email && $IPBLC_cloud_key)
	{
		//---post blacklist data to ip-finder.me

		$contextData = array ( 
		'method' => 'POST',
		'header' => "Connection: close\r\n". 
		"Referer: ".site_url()."\r\n"); 

		$context = stream_context_create (array ( 'http' => $contextData ));


		$email2=urlencode($IPBLC_cloud_email);

$link="http://ip-finder.me/wp-content/themes/ipfinder/cloudaccount_status.php?email=$email2&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'))."&cloudkey=".$IPBLC_cloud_key;


		$post_to_cloud =  file_get_contents (
		$link,
		false,
		$context);

		//echo $post_to_cloud;


		if($post_to_cloud!="-1" && $post_to_cloud!="-2")
		{
	//add_submenu_page( "wp-IPBLC", "Cloud Account Service", "Cloud Account Service", "manage_options", "wp-IPBLC-premium", "blacklist_premium" );

			
		}
	}







} 

function blacklist_premium()
{
	//include "blacklist-premium.php";
}

function blacklist_support()
{
	include "blacklist-support.php";
}


function blacklist_tool()
{
	include "blacklist-list.php";
}
function blacklist_tool_user()
{
	include "blacklist-list-user.php";
}


function blacklist_settings()
{

	include "blacklist-settings.php";

}

function blacklist_add()
{
	include "blacklist-add.php";
}
function blacklist_add_user()
{
	include "blacklist-add-user.php";
}

function blacklist_stats()
{
	//---post data to ip-finder.me

	$contextData = array ( 
	'method' => 'POST',
	'header' => "Connection: close\r\n". 
	"Referer: ".site_url()."\r\n");

	$context = stream_context_create (array ( 'http' => $contextData ));

 	$link="http://ip-finder.me/analysis";
	$analysis =  file_get_contents (
	$link,
	false,
	$context);


	echo $analysis;
}





function IPBLC_IP_column( $columns )
{

	$columns['IPBLC_IP'] = __( 'Details' );
	$columns['IPBLC_IP_status'] = __( 'Staus' );
	$columns['IPBLC_IP_spam'] = __( 'Spam Percentage' );
	return $columns;
}

function IPBLC_IP_value( $column, $comment_ID )
{

	global $wpdb;

	if ( 'IPBLC_IP' == $column )
	{

		$IP=get_comment_author_IP($comment_ID);
		$authorName=get_comment_author($comment_ID);

		echo '<a href="http://ip-finder.me/'.$IP.'/" target="_blank" title="IP Details on IP-Finder.me">'."$IP</a>";

		echo '<div class="row-actions">
	<span class="edit">
		<a href="http://ip-finder.me/'.$IP.'/" target="_blank" title="IP Details on IP-Finder.me">IP Details</a>
	</span> | 
	<span class="edit">
		<a href="javascript: blacklist_IP(\''.$IP.'\','.$comment_ID.');" title="Blacklist IP">Blacklist IP</a>
	</span> | 

	<span class="edit">
		<a href="javascript: blacklist_USER(\''.urlencode($authorName).'\','.$comment_ID.');" title="Blacklist Username">Blacklist Username</a>
	</span>

		</div>
	'; //---echo end----

	}

	if ( 'IPBLC_IP_status' == $column )
	{

		$IP=get_comment_author_IP($comment_ID);
		$authorName=get_comment_author($comment_ID);


		$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");

		if($IP_in_DP)
		{
			echo "IP: <span id=\"IPBlack"."$comment_ID\"><b style=\"color:#FF0000\"> Blacklisted</b></span><BR>";
		}
		else
		{
			echo "IP: <span id=\"IPBlack"."$comment_ID\"><b style=\"color:#009900\"> Neutral</b></span><BR>";
		}

			$authorName=str_replace("\'","'",$authorName);

			$authorName=str_replace("\\\'","'",$authorName);
			$authorName=str_replace("\\\"",'\"',$authorName);
			$authorName=str_replace("\\\"",'"',$authorName);
			$authorName2=str_replace("\"","&quot;",$authorName);

		$USERNAME_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_usernames WHERE USERNAME=\"$authorName2\"");

		if($USERNAME_in_DP)
		{
			echo "Username: <span id=\"UserBlack"."$comment_ID\"><b style=\"color:#FF0000\"> Blacklisted</b></span>";
		}
		else
		{
			echo "Username: <span id=\"UserBlack"."$comment_ID\"><b style=\"color:#009900\"> Neutral</b></span>";
		}

	}

	if ( 'IPBLC_IP_spam' == $column )
	{

			echo "<div id=\"IPSpam-$comment_ID\" class=\"IPSpam\">N/A</div>";
			echo "<a href=\"#\" id=\"IPSpamAction-$comment_ID\" class=\"IPSpamAction\" name=\"$comment_ID\">Calculate</a>";
	}

}

function create_sql()
{

	global $wpdb;

	if(!($wpdb->query("SELECT * FROM ".$wpdb->prefix."IPBLC_login_failed"))) 
	{

		$sql = "CREATE TABLE ".$wpdb->prefix."IPBLC_login_failed (
		id INT(60) UNSIGNED NOT NULL AUTO_INCREMENT,
		IP VARCHAR(200) NOT NULL, 
		useragent VARCHAR(500) NOT NULL, 
		variables TEXT NOT NULL, 
		timestamp INT(200) NOT NULL,
		UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}




	if(!($wpdb->query("SELECT * FROM ".$wpdb->prefix."IPBLC_blacklist"))) 
	{

		$sql = "CREATE TABLE ".$wpdb->prefix."IPBLC_blacklist (
		id INT(60) UNSIGNED NOT NULL AUTO_INCREMENT,
		IP VARCHAR(200) NOT NULL, 
		timestamp VARCHAR(500) NOT NULL,
		visits INT(255) NOT NULL, 
		UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	if(!($wpdb->query("SELECT * FROM ".$wpdb->prefix."IPBLC_usernames"))) 
	{

		$sql = "CREATE TABLE ".$wpdb->prefix."IPBLC_usernames (
		id INT(60) UNSIGNED NOT NULL AUTO_INCREMENT,
		USERNAME VARCHAR(250) NOT NULL, 
		timestamp VARCHAR(500) NOT NULL,
		visits INT(255) NOT NULL,  
		UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

		$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames CHANGE  `USERNAME` `USERNAME` VARCHAR( 1000 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

		$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames ENGINE = MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist ENGINE = MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");



		$checkVisits=$wpdb->get_results("SHOW columns from `".$wpdb->prefix."IPBLC_usernames` where field='visits'");

		if(!$checkVisits)
		{
		$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames ADD  `visits` INT( 255 ) NOT NULL");
		$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist ADD  `visits` INT( 255 ) NOT NULL");
		}
		else
		{
			$checkType=$wpdb->get_results("SHOW FIELDS from `".$wpdb->prefix."IPBLC_usernames` where field='visits'");

			if($checkType)
			{
				$visitType=$checkType[0]->Type;

				if($visitType!="int(255)")
				{
				//echo $visitType;
		$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames CHANGE `visits`  `visits` INT( 255 ) NOT NULL");
		$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist CHANGE `visits`  `visits` INT( 255 ) NOT NULL");
				}
			}

		}


	if($_GET['blacklist'])
	{

		//print_r($_SERVER);

		$referer=$_SERVER['HTTP_REFERER'];
		if(strpos($referer,"edit-comments.php")>0)
		{
			ip_added();
		}
	}



	if($_GET['blacklistuser'])
	{

		//print_r($_SERVER);

		$referer=$_SERVER['HTTP_REFERER'];
		if(strpos($referer,"edit-comments.php")>0)
		{
			user_added();
		}
	}


	$IPBLC_auto_comments=get_option('IPBLC_auto_comments');
	if(!$IPBLC_auto_comments)
	{
		update_option('IPBLC_auto_comments','2');
		$IPBLC_auto_comments=get_option('IPBLC_auto_comments');
	}


	$IPBLC_protected=get_option('IPBLC_protected');
	if(!$IPBLC_protected)
	{
		update_option('IPBLC_protected','2');
		$IPBLC_protected=get_option('IPBLC_protected');
	}



}





function IPBLC_blockip()
{

	global $wpdb;

	$IP=$_SERVER['REMOTE_ADDR'];
	$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");
	if($IP_in_DP)
	{
		$visits=$wpdb->get_var("SELECT visits FROM ".$wpdb->prefix."IPBLC_blacklist WHERE id='$IP_in_DP'");
		$visits=$visits+1;
		$wpdb->query("UPDATE ".$wpdb->prefix."IPBLC_blacklist SET `visits`=\"$visits\" WHERE id=\"$IP_in_DP\"");
		


	?>



<head><title><?php echo get_bloginfo('name'); ?></title></head>
<style>
#IPBLC_message_blacklist
{
	border:1px solid #FF9999;
	background-color: #FFDDDD;
	font-size: 20px;
	//font-weight: bold;
	padding: 12px;
	color: #000000;
	margin-top: 50px;
}

</style>
<center>
<div id="IPBLC_message_blacklist">Your IP <?php echo $IP; ?> has been blacklisted!</div><BR>
</center>
	<?php
		exit();
	}



	$author=$_POST['author'];

	$USER=str_replace("\'","'",$author);

	$USER=str_replace("\\\'","'",$USER);
	$USER=str_replace("\\\"",'\"',$USER);
	$USER=str_replace("\\\"",'"',$USER);
	$USER2=str_replace("\"","&quot;",$USER);



	$USER_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_usernames WHERE USERNAME=\"$USER2\"");
	if($USER_in_DP)
	{

	$author=str_replace('\"','"',$author);
	$author=str_replace("\'","'",$author);
	$author=str_replace("\\\'","'",$author);



		$visits=$wpdb->get_var("SELECT visits FROM ".$wpdb->prefix."IPBLC_usernames WHERE id='$USER_in_DP'");
		$visits=$visits+1;
		$wpdb->query("UPDATE ".$wpdb->prefix."IPBLC_usernames SET `visits`=\"$visits\" WHERE id=\"$USER_in_DP\"");

	?>

<head><title><?php echo get_bloginfo('name'); ?></title></head>
<style>
#IPBLC_message_blacklist
{
	border:1px solid #FF9999;
	background-color: #FFDDDD;
	font-size: 20px;
	//font-weight: bold;
	padding: 12px;
	color: #000000;
	margin-top: 50px;
}

</style>
<center>
<div id="IPBLC_message_blacklist"> "<?php echo $USER2; ?>" is blacklisted!</div><BR>
</center>
	<?php
		exit();
	}


	if($_POST['action']=="blacklistUSERJS")
	{
		if(current_user_can( 'manage_options' ))
		{


	$USER=$_POST['blacklistuser'];

	$USER=urldecode($USER);
	$USER=str_replace("+"," ",$USER);

	$USER=str_replace("\'","'",$USER);

	$USER=str_replace("\\\'","'",$USER);
	$USER=str_replace("\\\"",'\"',$USER);
	$USER=str_replace("\\\"",'"',$USER);
	$USER2=str_replace("\"","&quot;",$USER);

	$USER_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_usernames WHERE USERNAME=\"$USER2\"");

	$found=false;

	if(!$USER_in_DP)
	{

		if($USER)
		{

		$table=$wpdb->prefix."IPBLC_usernames";
		$time=time();
		//$USERX=str_replace('"',"\\\"",$USER);



					$wpdb->query("INSERT INTO $table (USERNAME,timestamp) VALUES('$USER2','$time')");

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
			$USER_error=true;
		}	
	}


	$USER_in_DP="";

	//---delay
	for($d=0;$d<=100000;$d++)
	{
		//----
	}

	$USER_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_usernames WHERE USERNAME=\"$USER2\"");




	if($USER_in_DP)
	{
		echo "<b style=\"color: #FF0000;\"> Blacklisted</b>";
	}
	else
	{
		echo "<b style=\"color: #009900;\"> Neutral</b>";
	}






		}
		exit();
	}

	if($_POST['action']=="blacklistIPJS")
	{
		if(current_user_can( 'manage_options' ))
		{

			$IP=$_POST['blacklist'];

			if(filter_var($IP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
			{

				$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");
				$found=false;

				if(!$IP_in_DP)
				{
					$table=$wpdb->prefix."IPBLC_blacklist";
					$time=time();
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


				$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");
				$found=false;

				if($IP_in_DP)
				{
					echo "<b style=\"color: #FF0000;\"> Blacklisted</b> <a href=\"http://ip-finder.me/$IP/\" target=_blank title=\"Leave Comment\">Why?</a>";
				}
				else
				{
					echo "<b style=\"color: #009900;\"> Neutral</b>";
				}
					
			}



		}
		exit();
	}
	

	//-----export Database-----


	if($_REQUEST['action']=="exportIPCloud")
	{
		if(current_user_can( 'manage_options' ))
		{

				$IPs_in_DP=$wpdb->get_results("SELECT IP FROM ".$wpdb->prefix."IPBLC_blacklist ORDER BY id DESC");

					$AllData=array();

				if($IPs_in_DP)
				{
					foreach($IPs_in_DP as $this_IP)
					{
						//$IPx['IP']=$this_IP->IP;
						$AllData[]=array("IP",$this_IP->IP);

					}
				}



				$USERs_in_DP=$wpdb->get_results("SELECT USERNAME FROM ".$wpdb->prefix."IPBLC_usernames ORDER BY id DESC");

				if($USERs_in_DP)
				{
					foreach($USERs_in_DP as $this_USER)
					{
						
						$USERx=$this_USER->USERNAME;
						$USERx=str_replace("&quot;",'"',$USERx);

						$USERx=urlencode($USERx);
						//$userxx['username']=$USERx;
						$AllData[]=array("USERNAME",$USERx);
						
					}
				}



				//echo json_encode($AllData);

				header( 'Content-Type: text/csv' );
				header( 'Content-Disposition: attachment;filename=IPBlacklistDB.csv');
				$fp = fopen('php://output', 'w');
				if($AllData)
				{
					foreach($AllData as $line)
					{
									
						fputcsv($fp, $line);	
					}

				}

				
				fclose($fp);

		}

		exit();
	}

	//------end Export-----

	//-----Import Database-----


	if($_REQUEST['action']=="importCSVIPCloud")
	{
		if(current_user_can( 'manage_options' ) && $_REQUEST['filename'])
		{




				$js_url =get_bloginfo('template_directory');
				$upload_d = wp_upload_dir();
				$upload_url=$upload_d['baseurl'];
				$upload_dir=$upload_d['basedir'];
				$filename= $upload_dir."/".$_REQUEST['filename'];

			
			//echo "file: $filename<BR>";
			$row = 1;
			if (($handle = fopen("$filename", "r")) !== FALSE)
			{
				$AllData=array();
				while (($data = fgetcsv($handle, 100000000, ",")) !== FALSE)
				{

					$field=$data[0];
					$value=$data[1];

					$AllData[]=array("$field"=>$value);
				}
				fclose($handle);

				echo json_encode($AllData);

			}
			else
			{
				echo "-1";
			}



			
		}

		exit();
	}
	//------end Import-----

	if($_POST['action']=="verifyCloudAccount")
	{
		if(current_user_can( 'manage_options' ))
		{
			verifyCloudAccount(true);
		}

		exit();
	}
	if($_POST['action']=="updateToCloud")
	{
		if(current_user_can( 'manage_options' ))
		{
			$status=verifyCloudAccount(false);

			if($status=="-1")
			{
				echo "<font color=red><b>Invalid Cloud Account Details.</b></font>";

			}
			elseif($status=="-2")
			{
				echo "<font color=red><b>Your Cloud Account has Expired.</b></font>";

			}
			else
			{
				$IPBLC_cloud_email=get_option('IPBLC_cloud_email');
				$IPBLC_cloud_key=get_option('IPBLC_cloud_key');

				if($IPBLC_cloud_email && $IPBLC_cloud_key)
				{
					//---post blacklist data to ip-finder.me

					$contextData = array ( 
					'method' => 'POST',
					'header' => "Connection: close\r\n". 
					"Referer: ".site_url()."\r\n"); 

					$context = stream_context_create (array ( 'http' => $contextData ));


					$email2=urlencode($IPBLC_cloud_email);
					$cloudKey=urlencode($IPBLC_cloud_key);



				}

				$IPs_in_DP=$wpdb->get_results("SELECT IP FROM ".$wpdb->prefix."IPBLC_blacklist ORDER BY id DESC");

					$AllData=array();

				if($IPs_in_DP)
				{
					foreach($IPs_in_DP as $this_IP)
					{
						$IPx['IP']=$this_IP->IP;
						$AllData[]=$IPx;

					}
				}



				$USERs_in_DP=$wpdb->get_results("SELECT USERNAME FROM ".$wpdb->prefix."IPBLC_usernames ORDER BY id DESC");

				if($USERs_in_DP)
				{
					foreach($USERs_in_DP as $this_USER)
					{
						
						$USERx=$this_USER->USERNAME;
						$USERx=str_replace("&quot;",'"',$USERx);

						$USERx=urlencode($USERx);
						$userxx['username']=$USERx;
						$AllData[]=$userxx;
						
					}
				}

				if($AllData)
				{

					echo json_encode($AllData);
				}
				else
				{
					echo "-1";
				}



			}

		}

		exit();
	}
	if($_POST['action']=="submitToCloudIP")
	{
		if(current_user_can( 'manage_options' ))
		{
			$status=verifyCloudAccount(false);

			if($status=="-1")
			{
				echo "<font color=red><b>Invalid Cloud Account Details.</b></font>";

			}
			elseif($status=="-2")
			{
				echo "<font color=red><b>Your Cloud Account has Expired.</b></font>";

			}
			else
			{
				$IPBLC_cloud_email=get_option('IPBLC_cloud_email');
				$IPBLC_cloud_key=get_option('IPBLC_cloud_key');

				if($IPBLC_cloud_email && $IPBLC_cloud_key)
				{
					//---post blacklist data to ip-finder.me

					$contextData = array ( 
					'method' => 'POST',
					'header' => "Connection: close\r\n". 
					"Referer: ".site_url()."\r\n"); 

					$context = stream_context_create (array ( 'http' => $contextData ));


					$email2=urlencode($IPBLC_cloud_email);
					$cloudKey=urlencode($IPBLC_cloud_key);



				}
				$IPx=$_POST['IP'];


				if($IPx)
				{

					$link="http://ip-finder.me/wp-content/themes/ipfinder/updateToCloud.php?email=$email2"."&cloudkey=".$cloudKey."&IP=$IPx";

						//echo $link."<BR>";

						$post_to_cloud =  file_get_contents (
						$link,
						false,
						$context);
						echo "Done";


				}

			}

		}

		exit();
	}
	if($_POST['action']=="submitToCloudUSER")
	{
		if(current_user_can( 'manage_options' ))
		{
			$status=verifyCloudAccount(false);

			if($status=="-1")
			{
				echo "<font color=red><b>Invalid Cloud Account Details.</b></font>";

			}
			elseif($status=="-2")
			{
				echo "<font color=red><b>Your Cloud Account has Expired.</b></font>";

			}
			else
			{
				$IPBLC_cloud_email=get_option('IPBLC_cloud_email');
				$IPBLC_cloud_key=get_option('IPBLC_cloud_key');

				if($IPBLC_cloud_email && $IPBLC_cloud_key)
				{
					//---post blacklist data to ip-finder.me

					$contextData = array ( 
					'method' => 'POST',
					'header' => "Connection: close\r\n". 
					"Referer: ".site_url()."\r\n"); 

					$context = stream_context_create (array ( 'http' => $contextData ));


					$email2=urlencode($IPBLC_cloud_email);
					$cloudKey=urlencode($IPBLC_cloud_key);



				}
				$USERx=$_POST['USER'];


				if($USERx)
				{
					$link="http://ip-finder.me/wp-content/themes/ipfinder/updateToCloud.php?email=$email2"."&cloudkey=".$cloudKey."&USER=$USERx";


						//echo $link."<BR>";

						$post_to_cloud =  file_get_contents (
						$link,
						false,
						$context);
						echo "Done";


				}

			}

		}

		exit();
	}
	if($_POST['action']=="updateFromCloud")
	{
		if(current_user_can( 'manage_options' ))
		{
			$status=verifyCloudAccount(false);

			if($status=="-1")
			{
				echo "<font color=red><b>Invalid Cloud Account Details.</b></font>";

			}
			elseif($status=="-2")
			{
				echo "<font color=red><b>Your Cloud Account has Expired.</b></font>";

			}
			else
			{
				$IPBLC_cloud_email=get_option('IPBLC_cloud_email');
				$IPBLC_cloud_key=get_option('IPBLC_cloud_key');

				if($IPBLC_cloud_email && $IPBLC_cloud_key)
				{
					//---post blacklist data to ip-finder.me

					$contextData = array ( 
					'method' => 'POST',
					'header' => "Connection: close\r\n". 
					"Referer: ".site_url()."\r\n"); 

					$context = stream_context_create (array ( 'http' => $contextData ));


					$email2=urlencode($IPBLC_cloud_email);
					$cloudKey=urlencode($IPBLC_cloud_key);

					$link="http://ip-finder.me/wp-content/themes/ipfinder/updateFromCloud.php?email=$email2"."&cloudkey=".$cloudKey."&GETDB=IP";

						//echo $link."<BR>";

						$post_to_cloud =  file_get_contents (
						$link,
						false,
						$context);




					$IPs=json_decode($post_to_cloud);



					$link="http://ip-finder.me/wp-content/themes/ipfinder/updateFromCloud.php?email=$email2"."&cloudkey=".$cloudKey."&GETDB=USERS";


						$post_to_cloud =  file_get_contents (
						$link,
						false,
						$context);


					$USERs=json_decode($post_to_cloud);

					$AllData=array();

					$IPx=array();
					$userx=array();
					if($IPs)
					{
						foreach($IPs as $this_IP)
						{
							//print_r($this_IP);
							$IPx['IP']=$this_IP->IP;
							$AllData[]=$IPx;

						}


					}

					if($USERs)
					{
						$USER="";
						foreach($USERs as $this_user)
						{
							
							$USER=$this_user->USERNAME;
							$user2=urlencode($USER);	

							$userx['username']=$user2;
							$AllData[]=$userx;
						}


					}


					if($AllData)
					{
						echo json_encode($AllData);
					}
					else
					{
						echo "-1";

					}

					//echo "IPS: ";
					//print_r($IPs);

/*

				if($IPs)
				{
				  foreach($IPs as $this_IP)
				  {
					$IP=$this_IP->IP;	

					if(filter_var($IP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
					{
						$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");
						if(!$IP_in_DP)
						{

							$table=$wpdb->prefix."IPBLC_blacklist";
							$time=time();



					$wpdb->query("INSERT INTO $table (IP,timestamp) VALUES('$IP','$time')");




						//---post blacklist data to ip-finder.me

						$contextData = array ( 
						'method' => 'POST',
						'header' => "Connection: close\r\n". 
						"Referer: ".site_url()."\r\n"); 

						$context = stream_context_create (array ( 'http' => $contextData ));


$link="http://ip-finder.me/wp-content/themes/ipfinder/blacklist_add.php?IP=$IP&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'));

						$post_to_cloud =  file_get_contents (
						$link,
						false,
						$context);




						}
					}

				  }

				echo "Updated IP Database from Cloud.<BR>";

				}
				else
				{
					if($post_to_cloud=="-1")
					{
						echo "<font color=red>Invalid email address or cloudkey for Cloud Account.</font><BR>";
					}
					elseif($post_to_cloud=="-2")
					{
						echo "<font color=red>Your Cloud Account has expired.</font><BR>";
					}
					else
					{
						echo $post_to_cloud;
					}

				}



				//echo "Usernames database....<BR>";




					$link="http://ip-finder.me/wp-content/themes/ipfinder/updateFromCloud.php?email=$email2"."&cloudkey=".$cloudKey."&GETDB=USERS";

						//echo $link."<BR>";

						$post_to_cloud =  file_get_contents (
						$link,
						false,
						$context);

					//echo $post_to_cloud;

					$USERS=json_decode($post_to_cloud);
					
				



				if($USERS)
				{
				  foreach($USERS as $this_USER)
				  {
					$USER=$this_USER->USERNAME;	

					if($USER)
					{
						$USER_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_usernames WHERE USERNAME=\"$USER\"");
						if(!$USER_in_DP)
						{

							$table=$wpdb->prefix."IPBLC_usernames";
							$time=time();


					$wpdb->query("INSERT INTO $table (USERNAME,timestamp) VALUES('$USER','$time')");




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
					}

				  }

				echo "Updated Usernames Database from Cloud.<BR>";

				}
				else
				{
					if($post_to_cloud=="-1")
					{
						echo "<font color=red>Invalid email address or cloudkey for Cloud Account.</font><BR>";
					}
					elseif($post_to_cloud=="-2")
					{
						echo "<font color=red>Your Cloud Account has expired.</font><BR>";
					}
					else
					{
						echo $post_to_cloud;
					}

				}



*/





				}

			}

		}

		exit();
	}
		



	if($_POST['action']=="submitToDBIP")
	{
		if(current_user_can( 'manage_options' ))
		{


				$IP=$_POST['IP'];

				
				




		$found="";

		if(filter_var($IP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
		{



			$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");

			$found=false;

			//$found=true;

			if(!$IP_in_DP)
			{


				$table=$wpdb->prefix."IPBLC_blacklist";
				$time=time();

					$wpdb->query("INSERT INTO $table (IP,timestamp) VALUES('$IP','$time')");

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
			echo "Done";
		}



		}

		exit();
	}



	if($_POST['action']=="submitToDBUSER")
	{
		if(current_user_can( 'manage_options' ))
		{

				$USER=$_POST['USER'];

				
				$found="";


	$USER=urldecode($USER);
	$USER=str_replace("\'","'",$USER);

	$USER=str_replace("\\\'","'",$USER);
	$USER=str_replace("\\\"",'\"',$USER);
	$USER=str_replace("\\\"",'"',$USER);
	$USER=str_replace("\"","&quot;",$USER);


		if($USER)
		{

			$USER_in_DB=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_usernames WHERE USERNAME=\"$USER\"");

			$found=false;

			if(!$USER_in_DB)
			{

				$table=$wpdb->prefix."IPBLC_usernames";
				$time=time();

					$wpdb->query("INSERT INTO $table (USERNAME,timestamp) VALUES('$USER','$time')");

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
			echo "Done";

		}


		}

		exit();
	}







	if($_POST['action']=="restoreToCloud")
	{
		if(current_user_can( 'manage_options' ))
		{
			$status=verifyCloudAccount(false);

			if($status=="-1")
			{
				echo "<font color=red><b>Invalid Cloud Account Details.</b></font>";

			}
			elseif($status=="-2")
			{
				echo "<font color=red><b>Your Cloud Account has Expired.</b></font>";

			}
			else
			{
				$IPBLC_cloud_email=get_option('IPBLC_cloud_email');
				$IPBLC_cloud_key=get_option('IPBLC_cloud_key');

				if($IPBLC_cloud_email && $IPBLC_cloud_key)
				{
					//---post blacklist data to ip-finder.me

					$contextData = array ( 
					'method' => 'POST',
					'header' => "Connection: close\r\n". 
					"Referer: ".site_url()."\r\n"); 

					$context = stream_context_create (array ( 'http' => $contextData ));


					$email2=urlencode($IPBLC_cloud_email);
					$cloudKey=urlencode($IPBLC_cloud_key);


					$link="http://ip-finder.me/wp-content/themes/ipfinder/restoreToCloud.php?email=$email2"."&cloudkey=".$cloudKey."&restore=1";

						//echo $link."<BR>";

						$post_to_cloud =  file_get_contents (
						$link,
						false,
						$context);

						//echo $post_to_cloud."<BR>";


				}

				$IPs_in_DP=$wpdb->get_results("SELECT IP FROM ".$wpdb->prefix."IPBLC_blacklist ORDER BY id DESC");

					$AllData=array();

				if($IPs_in_DP)
				{
					foreach($IPs_in_DP as $this_IP)
					{
						$IPx['IP']=$this_IP->IP;
						$AllData[]=$IPx;

					}
				}



				$USERs_in_DP=$wpdb->get_results("SELECT USERNAME FROM ".$wpdb->prefix."IPBLC_usernames ORDER BY id DESC");

				if($USERs_in_DP)
				{
					foreach($USERs_in_DP as $this_USER)
					{
						
						$USERx=$this_USER->USERNAME;
						$USERx=str_replace("&quot;",'"',$USERx);

						$USERx=urlencode($USERx);
						$userxx['username']=$USERx;
						$AllData[]=$userxx;
						
					}
				}

				if($AllData)
				{

					echo json_encode($AllData);
				}
				else
				{
					echo "-1";
				}



			}

		}

		exit();
	}

	if($_POST['action']=="restoreFromCloud")
	{
		if(current_user_can( 'manage_options' ))
		{
			$status=verifyCloudAccount(false);

			if($status=="-1")
			{
				echo "<font color=red><b>Invalid Cloud Account Details.</b></font>";

			}
			elseif($status=="-2")
			{
				echo "<font color=red><b>Your Cloud Account has Expired.</b></font>";

			}
			else
			{
				$IPBLC_cloud_email=get_option('IPBLC_cloud_email');
				$IPBLC_cloud_key=get_option('IPBLC_cloud_key');

				if($IPBLC_cloud_email && $IPBLC_cloud_key)
				{
					//---post blacklist data to ip-finder.me



					$wpdb->query("TRUNCATE TABLE ".$wpdb->prefix."IPBLC_usernames");


					$wpdb->query("TRUNCATE TABLE ".$wpdb->prefix."IPBLC_blacklist");


					$contextData = array ( 
					'method' => 'POST',
					'header' => "Connection: close\r\n". 
					"Referer: ".site_url()."\r\n"); 

					$context = stream_context_create (array ( 'http' => $contextData ));



					$link="http://ip-finder.me/wp-content/themes/ipfinder/restoreFromCloudDelete.php";

						//echo $link."<BR>";

						$post_to_cloud =  file_get_contents (
						$link,
						false,
						$context);

						//echo $post_to_cloud;



					$email2=urlencode($IPBLC_cloud_email);
					$cloudKey=urlencode($IPBLC_cloud_key);

					$link="http://ip-finder.me/wp-content/themes/ipfinder/updateFromCloud.php?email=$email2"."&cloudkey=".$cloudKey."&GETDB=IP";

						//echo $link."<BR>";

						$post_to_cloud =  file_get_contents (
						$link,
						false,
						$context);




					$IPs=json_decode($post_to_cloud);



					$link="http://ip-finder.me/wp-content/themes/ipfinder/updateFromCloud.php?email=$email2"."&cloudkey=".$cloudKey."&GETDB=USERS";


						$post_to_cloud =  file_get_contents (
						$link,
						false,
						$context);


					$USERs=json_decode($post_to_cloud);

					$AllData=array();

					$IPx=array();
					$userx=array();
					if($IPs)
					{
						foreach($IPs as $this_IP)
						{
							//print_r($this_IP);
							$IPx['IP']=$this_IP->IP;
							$AllData[]=$IPx;

						}


					}

					if($USERs)
					{
						$USER="";
						foreach($USERs as $this_user)
						{
							
							$USER=$this_user->USERNAME;
							$user2=urlencode($USER);	

							$userx['username']=$user2;
							$AllData[]=$userx;
						}


					}


					if($AllData)
					{
						echo json_encode($AllData);
					}
					else
					{
						echo "-1";

					}

					//echo "IPS: ";
					//print_r($IPs);






				}

			}

		}

		exit();
	}








}


$found=false;
$IP_global="";
$IP_error=false;


$USER_global="";
$USER_error=false;

add_action('admin_menu', 'page_IPBLC_actions');  
add_action('admin_init', 'create_sql');  
add_filter( 'manage_edit-comments_columns', 'IPBLC_IP_column' );
add_filter( 'manage_comments_custom_column', 'IPBLC_IP_value', 10, 2 );

add_action('init', 'IPBLC_blockIP');  


add_action('wp_login_failed','IPBLC_login_failed');

function IPBLC_login_failed(){

	global $wpdb;


	$postedData="";
	//print_r($_SERVER);
	$visitorIP=$_SERVER['REMOTE_ADDR'];
	$visitor_time=$_SERVER['REQUEST_TIME'];
	$visitor_user_agent=$_SERVER['HTTP_USER_AGENT'];

	if($_POST)
	{
		foreach($_POST as $k=>$v)
		{
			$postedData.="<font color=green>$k</font> => <font color=red>$v</font><BR>";
		}

	}

	$table=$wpdb->prefix."IPBLC_login_failed";

	$wpdb->query("INSERT INTO $table (IP,variables,useragent,timestamp) VALUES(\"$visitorIP\",\"$postedData\",\"$visitor_user_agent\",\"$visitor_time\")");


}



function load_custom_IPBLC_admin_style()
{

        echo "<style type=\"text/css\">\n
	.IPSpam, .IPSpamAction{ display: inline; margin: 0px 10px;}\n		
	</style>\n
	";

}



function IPJS()
{
	if($_GET['blacklist'])
	{
		//print_r($_SERVER);
		$referer=$_SERVER['HTTP_REFERER'];

	
		if(strpos($referer,"edit-comments.php")>0)
		{
			ip_added_message();
		}

	}


	elseif($_GET['blacklistuser'])
	{
		//print_r($_SERVER);
		$referer=$_SERVER['HTTP_REFERER'];

	
		if(strpos($referer,"edit-comments.php")>0)
		{
			user_added_message();
		}

	}




	$scriptname=$_SERVER['SCRIPT_NAME'];
	$page=$_GET['page'];

?>
<script type="text/javascript">
jQuery(".IPSpamAction").click(function(){

	var comment_ID=jQuery(this).attr('name');
	var spamperc=jQuery("#IPSpam-"+comment_ID);
	spamperc.css("color","#000000");
	spamperc.html("<img src=\"<?php echo site_url(); ?>/wp-admin/images/wpspin_light.gif\">");
<?php

	//------plugin url---
	$plugin_dir_name=plugin_dir_url(__FILE__);
	//------SpamCheckerfile---
	$SpamCheckerUrl=$plugin_dir_name."SpamChecker.php";

?>



		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo $SpamCheckerUrl; ?>",
			  data: {comment_ID: comment_ID},
  			dataType: "html"

			});

		reRequest.done(function(msg,response) {
			if(msg)
			{
				spamperc.css("color","#000000");
				spamperc.html(msg);
			}
		});

		reRequest.fail(function(jqXHR, textStatus) {
			spamperc.css("color","#FF0000");
			spamperc.html("<?php echo __("Error"); ?>");
		});

	return false;

});
</script>
<?php
}

function protected_comment_link()
{
	$IPBLC_protected=get_option('IPBLC_protected');
	if($IPBLC_protected=="2")
	{


	echo "Protected with <a href=\"http://ip-finder.me\"><img src=\"".plugins_url()."/ip-blacklist-cloud/icon.png\" style=\"display: inline;\" alt=\"IP Blacklist Cloud\">IP Blacklist Cloud</a>";

	}

}


function postToCloud($comment_id)
{

	$IPBLC_auto_comments=get_option('IPBLC_auto_comments');


	if($IPBLC_auto_comments=="2")
	{

		if(is_numeric($comment_id))
		{

			//------plugin url---
			$plugin_dir_name=plugin_dir_url(__FILE__);
			//------SpamCheckerfile---
			$SpamCheckerUrl=$plugin_dir_name."SpamChecker.php";


			//echo $SpamCheckerUrl;

			$handle = curl_init($SpamCheckerUrl);
			
			curl_setopt($handle, CURLOPT_POSTFIELDS,"comment_ID=$comment_id");
			curl_setopt($handle, CURLOPT_POST, 1);
			curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($handle, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			curl_setopt($handle, CURLOPT_REFERER, site_url());
			curl_setopt( $handle, CURLOPT_FOLLOWLOCATION, true );
			curl_setopt( $handle, CURLOPT_ENCODING, "" );
			curl_setopt( $handle, CURLOPT_AUTOREFERER, true );
			curl_setopt( $handle, CURLOPT_MAXREDIRS, 10 );
			curl_setopt($handle,CURLOPT_TIMEOUT,15);
			curl_setopt($handle,CURLOPT_CONNECTTIMEOUT,15);





			$header_info = curl_getinfo( $handle );
 
			$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);


			$response = curl_exec($handle);

			$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
			curl_close($handle);

			//echo $response;

		}
	}
}

//-----disable auto post to cloud-----------
//add_action('comment_post','postToCloud');


add_action( 'admin_enqueue_scripts', 'load_custom_IPBLC_admin_style' );
add_action('admin_footer', 'IPJS');
add_action( 'comment_form', 'protected_comment_link' );

add_action('wp_ajax_verifyCloudAccount', 'verifyCloudAccount_callback');



function verifyCloudAccount($echo=false)
{


	$IPBLC_cloud_email=get_option('IPBLC_cloud_email');
	$IPBLC_cloud_key=get_option('IPBLC_cloud_key');

	if($IPBLC_cloud_email && $IPBLC_cloud_key)
	{
		//---post blacklist data to ip-finder.me

		$contextData = array ( 
		'method' => 'POST',
		'header' => "Connection: close\r\n". 
		"Referer: ".site_url()."\r\n"); 

		$context = stream_context_create (array ( 'http' => $contextData ));

		$email2=urlencode($IPBLC_cloud_email);

$link="http://ip-finder.me/wp-content/themes/ipfinder/cloudaccount_status.php?email=$email2&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'))."&cloudkey=".$IPBLC_cloud_key;


		$post_to_cloud =  file_get_contents (
		$link,
		false,
		$context);

		if($echo)
		{
			echo $post_to_cloud;
		}
		else
		{
			return $post_to_cloud;
		}

	}
	else
	{
		if($echo)
		{
			echo "-1";
		}
		else
		{
			return "-1";
		}
	}
}

add_action('admin_footer', 'IPJS2');


function IPJS2()
{

?>
<script>

var ajaxloader="<img src=\"<?php echo site_url(); ?>/wp-admin/images/wpspin_light.gif\">";


function blacklist_IP(IP,commentID)
{
	jQuery("#IPBlack"+commentID).html(ajaxloader);

		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>/",
			data: {blacklist: IP, action: "blacklistIPJS"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			
		if(result)
		{
			jQuery("#IPBlack"+commentID).html(result);

		}
		else
		{
			jQuery("#IPBlack"+commentID).html("<font color=red>Error! Try Again.</font>");
		}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			jQuery("#IPBlack"+commentID).html("<font color=red>Error! Try Again.</font>");
			result=false;	
		});



	
}

function blacklist_USER(USER,commentID)
{
	jQuery("#UserBlack"+commentID).html(ajaxloader);

		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>/",
			data: {blacklistuser: USER, action: "blacklistUSERJS"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			
		if(result)
		{
			jQuery("#UserBlack"+commentID).html(result);

		}
		else
		{
			jQuery("#UserBlack"+commentID).html("<font color=red>Error! Try Again.</font>");
		}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			jQuery("#UserBlack"+commentID).html("<font color=red>Error! Try Again.</font>");
			result=false;	
		});	
}



</script>

<?php



}

?>