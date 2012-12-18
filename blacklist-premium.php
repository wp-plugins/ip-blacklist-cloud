<?php





//---start admin options

	?>

<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<?php

global $wpdb;




?>


<?php

$listLink=get_admin_url()."admin.php?page=wp-IPBLC-list";
$blLink=get_admin_url()."admin.php?page=wp-IPBLC-Add";
$setLink=get_admin_url()."admin.php?page=wp-IPBLC";

//echo "$listLink<BR>$blLink";



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


		if($post_to_cloud!="-1" && $post_to_cloud!="-2" && ($post_to_cloud))
		{
?>
<BR>
<style>
#cloudTable
{
background-color: #DFDFDF;

border:1px #AFAFAF solid;
-webkit-box-shadow: inset 0 1px 0 white;
box-shadow: inset 0 1px 0 white;
-webkit-border-radius: 3px;
border-radius: 3px;
padding: 4px;


}
</style>

<h2> Cloud Account Service (Premium)</h2>
<BR>
<table id="cloudTable">


<tr>
<td style="width: 150px;">
	<input type="submit" name="updateFromCloud" id="updateFromCloud" class="button-primary" value="Update from Cloud" style="width: 130px;">
</td>
<td>
	Update IP and Username blacklist database of this website from your Cloud Account.
</td>
</tr>



<tr>
<td style="width: 150px;">
	<input type="submit" name="updateToCloud" id="updateToCloud" class="button-primary" value="Update Cloud" style="width: 130px;">
</td>
<td>
	Update Cloud Account with this website IP and Username blacklist database.
</td>
</tr>





<tr>
<td style="width: 150px;">
	<input type="submit" name="restoreFromCloud" id="restoreFromCloud" class="button-primary" value="Restore from Cloud" style="width: 130px;">
</td>
<td>
	Delete IP and Username blacklist database of this website and restore it from your Cloud Account.
</td>
</tr>

<tr>
<td style="width: 150px;">
	<input type="submit" name="restoreToCloud" id="restoreToCloud" class="button-primary" value="Restore Cloud" style="width: 130px;">
</td>
<td>
	Delete IP and Username blacklist database of Cloud Account and retore it with this website IP blacklist database.
</td>
</tr>

</table>
<style>
#cloudResult
{
	padding: 8px 4px;
	font-size: 14px;
	font-weight: bold;


}
</style>
<div id="cloudResult">
</div>

<script>
var this_page_url="<?php echo $listLink; ?>";
var settings_page_url="<?php echo $setLink; ?>";
var blacklist_page_url="<?php echo $blLink; ?>";
var ajaxloader="<img src=\"<?php echo site_url(); ?>/wp-admin/images/wpspin_light.gif\">";

var cloudAccountOption="";
var cloudEmail="<?php echo urlencode($IPBLC_cloud_email); ?>";
var cloudKey="<?php echo urlencode($IPBLC_cloud_key); ?>";

var this_website_encode="<?php echo urlencode(site_url()); ?>";
var this_website_name="<?php echo get_bloginfo('name'); ?>";


var cloudResult=jQuery("#cloudResult");


	jQuery("#updateToCloud").click(function(){

	cloudAccountOption="updateToCloud";
	cloudResult.html("Verifying account...."+ajaxloader);


		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>",
			data: {action: "verifyCloudAccount"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			
		if(result)
		{
			if(result=="-1")
			{
				cloudResult.html("<font color=red><b>Invalid Cloud Account Details.</b></font>");
			}
			else if(result=="-2")
			{
				cloudResult.html("<font color=red><b>Your Cloud Account has Expired.</b></font>");
			}
			else
			{
				cloudResult.html("Updating Cloud...."+ajaxloader);
				updateToCloud();
			}
		}
		else
		{
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
		}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
			result=false;	
		});

	return false;

	});







	jQuery("#updateFromCloud").click(function(){

	cloudAccountOption="updateFromCloud";
	cloudResult.html("Verifying account...."+ajaxloader);


		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>",
			data: {action: "verifyCloudAccount"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			
		if(result)
		{
			if(result=="-1")
			{
				cloudResult.html("<font color=red><b>Invalid Cloud Account Details.</b></font>");
			}
			else if(result=="-2")
			{
				cloudResult.html("<font color=red><b>Your Cloud Account has Expired.</b></font>");
			}
			else
			{
				cloudResult.html("Updating from Cloud...."+ajaxloader);
				updateFromCloud();
			}
		}
		else
		{
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
		}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
			result=false;	
		});

	return false;

	});







function updateToCloud()
{

		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>",
			data: {action: "updateToCloud"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			
			if(result)
			{
				cloudResult.html(result);
			}

			else
			{
				cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
				//updateToCloud();
			}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
			result=false;	
		});




}



function updateFromCloud()
{

		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>",
			data: {action: "updateFromCloud"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			
			if(result)
			{
				cloudResult.html(result);
			}

			else
			{
				cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
				//updateToCloud();
			}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
			result=false;	
		});




}


	jQuery("#restoreToCloud").click(function(){

	cloudAccountOption="restoreToCloud";
	cloudResult.html("Verifying account...."+ajaxloader);


		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>",
			data: {action: "verifyCloudAccount"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			
		if(result)
		{
			if(result=="-1")
			{
				cloudResult.html("<font color=red><b>Invalid Cloud Account Details.</b></font>");
			}
			else if(result=="-2")
			{
				cloudResult.html("<font color=red><b>Your Cloud Account has Expired.</b></font>");
			}
			else
			{
				cloudResult.html("Updating Cloud...."+ajaxloader);
				restoreToCloud();
			}
		}
		else
		{
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
		}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
			result=false;	
		});

	return false;

	});







	jQuery("#restoreFromCloud").click(function(){

	cloudAccountOption="restoreFromCloud";
	cloudResult.html("Verifying account...."+ajaxloader);


		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>",
			data: {action: "verifyCloudAccount"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			
		if(result)
		{
			if(result=="-1")
			{
				cloudResult.html("<font color=red><b>Invalid Cloud Account Details.</b></font>");
			}
			else if(result=="-2")
			{
				cloudResult.html("<font color=red><b>Your Cloud Account has Expired.</b></font>");
			}
			else
			{
				cloudResult.html("Updating from Cloud...."+ajaxloader);
				restoreFromCloud();
			}
		}
		else
		{
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
		}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
			result=false;	
		});

	return false;

	});







function restoreToCloud()
{

		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>",
			data: {action: "restoreToCloud"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			
			if(result)
			{
				cloudResult.html(result);
			}

			else
			{
				cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
				//restoreToCloud();
			}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
			result=false;	
		});




}



function restoreFromCloud()
{

		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>",
			data: {action: "restoreFromCloud"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			
			if(result)
			{
				cloudResult.html(result);
			}

			else
			{
				cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
				//restoreToCloud();
			}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			cloudResult.html("<font color=red>Error Connecting Cloud Account Please Try Again.</font>");
			result=false;	
		});




}



</script>
<?php


		}
	}







?>

</div>
