<?php
/*
Plugin Name: IP Blacklist Cloud
Plugin URI: 
Description: Blacklist IP Addresses from visiting your WordPress website.
Version: 0.1
Author: Adeel Ahmed
Author URI: http://demo.ip-finder.me/demo-details/
*/


function ip_added()
{

global $wpdb,$found,$IP_global, $IP_error;


	$IP=$_GET['blacklist'];

$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");

	$found=false;
	//$found=true;

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
	

	echo "<div id=\"IPBLC_message_blacklist\">$IP added to blacklist.</div>";

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

	echo "<script>jQuery('#IPBLC_message_blacklist').delay(3500).fadeOut(1000); jQuery('#IPBLC_message_blacklist').click(function(){ jQuery(this).hide(); });</script>";

}

function page_IPBLC_actions() {  
	add_menu_page( "IP Blacklist", "IP Blacklist", "manage_options", "wp-IPBLC");
	add_submenu_page( "wp-IPBLC", "Blacklist", "Blacklist", "manage_options", "wp-IPBLC", "blacklist_tool" );
	add_submenu_page( "wp-IPBLC", "Add IP to Blacklist", "Add IP to Blacklist", "manage_options", "wp-IPBLC-Add", "blacklist_add" );
} 



function blacklist_tool() {

	include "blacklist-list.php";

}
function blacklist_add() {

	include "blacklist-add.php";

}


function IPBLC_IP_column( $columns )
{
	$columns['IPBLC_IP'] = __( 'IP' );
	$columns['IPBLC_IP_status'] = __( 'IP Staus' );
	return $columns;
}
function IPBLC_IP_value( $column, $comment_ID )
{

global $wpdb;

	if ( 'IPBLC_IP' == $column ) {

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
	if ( 'IPBLC_IP_status' == $column ) {

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
	if($_SERVER['SCRIPT_NAME']=="/wp-admin/edit-comments.php")
	{

		ip_added();
		add_action('admin_footer', 'ip_added_message');

	}
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

?>