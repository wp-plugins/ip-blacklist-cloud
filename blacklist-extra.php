<?php

if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );


global $this_plugin_url;

?>


<?php





//---start admin options

	?>

<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<?php

global $wpdb;



$dirMain=get_home_path()."/";
$dirMain=str_replace("//","/",$dirMain);

//echo $dirMain;
		if(isset($_POST['GenerateblacklistedIP']))
		{

		$resultX = $wpdb->get_results( "SELECT DISTINCT(IP) FROM ".$wpdb->prefix."IPBLC_blacklist ORDER BY timestamp DESC");
		$fileData="";

		if($resultX)
		{
			foreach($resultX as $ipp)
			{
				$IP=$ipp->IP;
				$fileData.="$IP\n";
			}

			file_put_contents($dirMain."blacklistedIP.txt",$fileData);

			if(file_exists($dirMain."blacklistedIP.txt"))
			{
			echo "<div id='setting-error-settings_updated' class='updated settings-error'>
				<p><strong>blacklistedIP.txt updated successfully!
 <a href=\"".site_url()."/blacklistedIP.txt\">".site_url()."/blacklistedIP.txt</a></strong></p></div>";
			}
			else
			{

			echo "<div id='setting-error-settings_updated' class='updated settings-error' style='color: #FF0000;'>
				<p><strong>PHP restrictions! Unable to create blacklistedIP.txt</strong></p></div>";
			}

		}


		}
?>



<BR>

<h2>Extra Security</h2>
<BR>
<style>
h3{
color: #009900; 
}
</style>


<h3>The Background</h3>
Whenever visitor/hacker/spammer/bot/attacker visits WordPress based website, before running plugins, WordPress connects database and runs some PHP functions. IP Blacklist Cloud plugin will not allow them to view or access any content or data of your website. But some of you still facing downtime problems, slow website loading or even website gets temporarily locked by hosting.<BR>
<BR>
Question arises <b>Why?</b><BR><BR>

Because plugins runs within WordPress framework and before IP Blacklist Cloud plugin runs, WordPress first connects to database and perform some functions and then plugins or themes comes in. Which means if you are getting too much attacks from different IP addresses and even they are blocked by plugin, dabatase does connect and WordPress runs functions before plugin detects it is blacklisted IP.
<?php

//echo dirname(__FILE__);

?>

<BR>
<center>
<img src="<?php echo $this_plugin_url."extra_1.png"; ?>">
</center>

<BR>

<h3>The Solution</h3>

I have created a premium script (standalone) which works best with <b>IP Blacklist Cloud</b> plugin.<BR>
<BR>
<b>How script works?</b><BR><BR>
Scripts runs between WordPress and visitors that means, script runs first and check if IP is blacklisted or not and if IP address is neutral (not Blacklisted) only then WordPress runs.<BR><BR>
<center>
<img src="<?php echo $this_plugin_url."extra_2.png"; ?>">
</center>


<b>How does it checks without using database?</b><BR><BR>
Script uses a text file <i style="color: #0000FF; "><b>blacklistedIP.txt</b></i> containing all blacklisted IP addresses. This file can be generated or update it below just by pressing a button.<BR>
You can check if file exists or not: <a href="<?php echo site_url(); ?>/blacklistedIP.txt"><?php echo site_url(); ?>/blacklistedIP.txt</a><BR>
<BR>

<h3>Script Details</h3>

Script consist of two files.<BR>
<b>
1. checkIP.php<BR>
2. customMessage.php<BR>
</b>
<BR>
<i style="color: #0000FF; "><b>checkIP.php</b></i> checks visitor IP in file <i style="color: #0000FF; "><b>blacklistedIP.txt</b></i> and if it is blacklisted, it shows message from <i style="color: #0000FF; "><b>customMessage.php</b></i> and does not allow WordPress to run.<BR>
<BR>


<div id="setting-error-settings_updated" class="updated settings-error" style="background: #FFDDDD;">
				<p>You can purchase this script for <b>U.S $5.0</b> via PayPal. Please contact me first at: <b>contact@adiie9.com</b> or <b>ad33l@live.com</b> before making payment.</p></div>



<h3>Script Setup</h3>
1. Upload <i style="color: #0000FF; "><b>checkIP.php</b></i> and <i style="color: #0000FF; "><b>customMessage.php</b></i> to WordPress installation directory.<BR>
<div style="width: 450px; border: 1px #009900 dotted; background-color: #EFEFEF; font-face: courier; margin: auto; padding: 15px;">
<?php echo $dirMain; ?>
</div><BR>


2. Download <i style="color: #0000FF; "><b>wp-config.php</b></i> via FTP from same directory(where WordPress is installed). You just have to add this line in <i style="color: #0000FF; "><b>wp-config.php</b></i> on the top of everything after <b>&lt;?php</b><BR>
<div style="width: 450px; border: 1px #009900 dotted; background-color: #EFEFEF; font-face: courier; margin: auto; padding: 15px;">
include "checkIP.php";
</div><BR>
<BR>

<B style="color: #FF0000; ">NOTE: Make sure you make a backup of <i style="color: #0000FF; ">wp-config.php</i> before editing.</B>
<BR>
<h3>Generate or Update blacklistedIP.txt</h3>

Press the button to generate or update <i style="color: #0000FF; "><b>blacklistedIP.txt</b></i>
<form method="POST">
<input type="submit" name="GenerateblacklistedIP" id="GenerateblacklistedIP" class="button" value="Generate / Update">
</form>
<BR><BR>

</div>

