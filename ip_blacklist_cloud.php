<?php
/*
Plugin Name: IP Blacklist Cloud
Plugin URI: http://wordpress.org/extend/plugins/ip-blacklist-cloud/
Description: Blacklist IP Addresses from visiting your WordPress website.
Version: 1.4
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


function page_IPBLC_actions() 
{  

	add_menu_page( "IP Blacklist", "IP Blacklist", "manage_options", "wp-IPBLC","",plugins_url()."/ip-blacklist-cloud/icon.png");
	add_submenu_page( "wp-IPBLC", "Settings", "Settings", "manage_options", "wp-IPBLC", "blacklist_settings" );
	add_submenu_page( "wp-IPBLC", "Blacklist", "Blacklist", "manage_options", "wp-IPBLC-list", "blacklist_tool" );
	add_submenu_page( "wp-IPBLC", "Add IP to Blacklist", "Add IP to Blacklist", "manage_options", "wp-IPBLC-Add", "blacklist_add" );
	add_submenu_page( "wp-IPBLC", "Blacklist Statistics", "Blacklist Statistics", "manage_options", "wp-IPBLC-stats", "blacklist_stats" );
} 

function blacklist_tool()
{
	include "blacklist-list.php";
}

function blacklist_settings()
{

	include "blacklist-settings.php";

}

function blacklist_add()
{
	include "blacklist-add.php";
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

	$columns['IPBLC_IP'] = __( 'IP' );
	$columns['IPBLC_IP_status'] = __( 'IP Staus' );
	$columns['IPBLC_IP_spam'] = __( 'Spam Percentage' );
	return $columns;
}

function IPBLC_IP_value( $column, $comment_ID )
{

	global $wpdb;

	if ( 'IPBLC_IP' == $column )
	{

		$IP=get_comment_author_IP($comment_ID);
		echo "$IP";

		echo '<div class="row-actions">
	<span class="edit">
		<a href="http://ip-finder.me/wpip?IP='.$IP.'" target="_blank" title="IP Details on IP-Finder.me">IP Details</a>
	</span>
	<span class="edit">
		<a href="?blacklist='.$IP.'" title="Blacklist IP">Blacklist</a>
	</span>

		</div>
	'; //---echo end----

	}

	if ( 'IPBLC_IP_status' == $column )
	{

		$IP=get_comment_author_IP($comment_ID);

		$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");

		if($IP_in_DP)
		{
			echo "<font color=red><b>Blacklisted</b></font>";
		}
		else
		{
			echo "<font color=green><b>Neutral</b></font>";
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


	if(!($wpdb->query("SELECT * FROM ".$wpdb->prefix."IPBLC_blacklist"))) 
	{

		$sql = "CREATE TABLE ".$wpdb->prefix."IPBLC_blacklist (
		id INT(60) UNSIGNED NOT NULL AUTO_INCREMENT,
		IP VARCHAR(200) NOT NULL, 
		timestamp VARCHAR(500) NOT NULL, 
		UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
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

}


$found=false;
$IP_global="";
$IP_error=false;

add_action('admin_menu', 'page_IPBLC_actions');  
add_action('admin_init', 'create_sql');  
add_filter( 'manage_edit-comments_columns', 'IPBLC_IP_column' );
add_filter( 'manage_comments_custom_column', 'IPBLC_IP_value', 10, 2 );

add_action('init', 'IPBLC_blockIP');  

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

	$scriptname=$_SERVER['SCRIPT_NAME'];
	$page=$_GET['page'];

if((strpos($scriptname,"edit-comments.php")>0) || (strpos($scriptname,"admin.php")>0 && ($page=="wp-IPBLC-stats" || $page=="wp-IPBLC" || $page=="wp-IPBLC-Add")) )
{

?>

<style>
#IPBLC_message_like
{
	position: fixed;
	bottom: 20px;
	float: left;
	left: 5px;
	border:1px solid #99AA99;
	background-color: #EFEFEF;
	font-size: 12px;
	//font-weight: bold;
	padding: 4px;
	color: #000000;
}

#IPBLC_message_like a
{
	color: #222222;
}
</style>
<div id="IPBLC_message_like">
<a href="http://wordpress.org/extend/plugins/ip-blacklist-cloud/" target="_blank">Rate IP Blacklist Cloud</a>
</div>
<?php

}

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


	echo "Protected with <a href=\"http://ip-finder.me\"><img src=\"".plugins_url()."/ip-blacklist-cloud/icon.png\" style=\"display: inline;\">IP Blacklist Cloud</a>";

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

add_action('comment_post','postToCloud');
add_action( 'admin_enqueue_scripts', 'load_custom_IPBLC_admin_style' );
add_action('admin_footer', 'IPJS');
add_action( 'comment_form', 'protected_comment_link' );


?>