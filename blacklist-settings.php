<?php





//---start admin options

	?>

<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<h2>Plugin Settings</h2>



<?php

global $wpdb;



	if($_POST['update_IPBLC'])
	{

		update_option('IPBLC_auto_comments',$_POST['auto_comments']);
		update_option('IPBLC_protected',$_POST['IPBLC_protected']);



		$cloudemail=$_POST['cloud_email'];
		$cloudkey=$_POST['cloud_key'];

		if($cloudemail=="" && $cloudkey=="")
		{
		update_option('IPBLC_cloud_email',"");
		update_option('IPBLC_cloud_key',"");
		}

		if($cloudemail && $cloudkey)
		{
			if(filter_var($cloudemail, FILTER_VALIDATE_EMAIL))
			{

		//---post blacklist data to ip-finder.me

		$contextData = array ( 
		'method' => 'POST',
		'header' => "Connection: close\r\n". 
		"Referer: ".site_url()."\r\n"); 

		$context = stream_context_create (array ( 'http' => $contextData ));


		$email2=urlencode($cloudemail);
		$cloudkey2=urlencode($cloudkey);

$link="http://ip-finder.me/wp-content/themes/ipfinder/cloudaccount_status.php?email=$email2&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'))."&cloudkey=".$cloudkey2;


		$post_to_cloud =  file_get_contents (
		$link,
		false,
		$context);

		//echo $post_to_cloud;


		if($post_to_cloud=="-1")
		{
		echo "<div id='setting-error-settings_updated' class='error settings-error'> 
<p><strong>Invalid email address or cloudkey for Cloud Account.</strong></p></div>";
		}
		elseif($post_to_cloud=="-2")
		{
			
		echo "<div id='setting-error-settings_updated' class='error settings-error'> 
<p><strong>Your Cloud Account has expired.</strong></p></div>";


		}
		elseif($post_to_cloud)
		{
		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>Settings saved.</strong></p></div>";

		update_option('IPBLC_cloud_email',$cloudemail);
		update_option('IPBLC_cloud_key',$cloudkey);

		}

				
				

			}
			else
			{
		echo "<div id='setting-error-settings_updated' class='error settings-error'> 
<p><strong>Invalid Email format.</strong></p></div>";


			}

		}
		else
		{
		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>Settings saved.</strong></p></div>";
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


		if($post_to_cloud=="-1")
		{
			
		echo "<div id='setting-error-settings_updated' class='error settings-error'> 
<p><strong>Invalid email address or cloudkey for Cloud Account.</strong></p></div>";


		}
		elseif($post_to_cloud=="-2")
		{
			
		echo "<div id='setting-error-settings_updated' class='error settings-error'> 
<p><strong>Your Cloud Account has expired.</strong></p></div>";


		}
		elseif($post_to_cloud)
		{
		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>Your Cloud Account will expire on ".date("d-m-Y",$post_to_cloud).".</strong></p></div>";


		}
	}





?>

<BR><BR>

<form method="post" ENCTYPE="multipart/form-data">
<h3>Settings</h3>

<table cellspacing=2 cellpadding=2 class="form-table" style="width: 650px;">

<tr valign="top">
<td>
<b>Auto post comments to Cloud for spam reports:</b> 
</td>
<td>
<select id="auto_comments" name="auto_comments"  style="width: 80px;">
<?php
if($IPBLC_auto_comments=="1")
{
$optionh_1="selected";
}
elseif($IPBLC_auto_comments=="2")
{
$optionh_2="selected";
}

?>

<option value="1" <?php echo $optionh_1; ?>>No</option>
<option value="2" <?php echo $optionh_2; ?>>Yes</option>

</select>
</td>
</tr>




<tr valign="top">
<td>
<b>Show "<?php  echo "Protected with <a href=\"http://ip-finder.me\"><img src=\"".plugins_url()."/ip-blacklist-cloud/icon.png\" style=\"display: inline;\">IP Blacklist Cloud</a>"; ?>" message below comments form:</b> 
</td>
<td>
<select id="IPBLC_protected" name="IPBLC_protected"  style="width: 80px;">
<?php
if($IPBLC_protected=="1")
{
$optioni_1="selected";
}
elseif($IPBLC_protected=="2")
{
$optioni_2="selected";
}

?>

<option value="1" <?php echo $optioni_1; ?>>No</option>
<option value="2" <?php echo $optioni_2; ?>>Yes</option>

</select>
</td>
</tr>


<tr valign="top">
<td>
<h3>Cloud Account</h3>
</td>
<td>
</td>
</tr>

<tr valign="top">
<td>
Email: 
</td>
<td>
<input type=input name="cloud_email" id="cloud_email" value="<?php echo $IPBLC_cloud_email; ?>" class="regular-text" style="width: 130px;">
</td>
</tr>

<tr valign="top">
<td>
Cloud Key: 
</td>
<td>
<input type=input name="cloud_key" id="cloud_key" value="<?php echo $IPBLC_cloud_key; ?>" class="regular-text" style="width: 130px;">
</td>
</tr>





<tr valign="top" valign="top">
<td colspan=2 height=60>
<input type="submit" name="update_IPBLC" id="update_IPBLC" value="Save Changes" class="button-primary">
</td>
</tr>
</table>
</form>




</div>

