<?php




		$js_url =get_bloginfo('template_directory');
		$upload_d = wp_upload_dir();
		$upload_url=$upload_d['baseurl'];
		$upload_dir=$upload_d['basedir'];


//---start admin options

	?>

<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<h2>Plugin Settings</h2>



<?php

global $wpdb;


		update_option('IPBLC_cloud_email',"");
		update_option('IPBLC_cloud_key',"");


	if($_POST['update_IPBLC'])
	{

		update_option('IPBLC_auto_comments',$_POST['auto_comments']);
		update_option('IPBLC_protected',$_POST['IPBLC_protected']);
		update_option('IPBLC_failed_sort_status',$_POST['IPBLC_failed_sort_status']);



		//$cloudemail=$_POST['cloud_email'];
		//$cloudkey=$_POST['cloud_key'];


		$cloudemail="";
		$cloudkey="";

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

	if(isset($_POST['update_cloud_connect']))
	{

		update_option('IPBLC_cloud_on',$_POST['IPBLC_cloud_on']);
		update_option('IPBLC_cloud_password',$_POST['IPBLC_cloud_password']);


		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>Settings saved.</strong></p></div>";

	}

	$IPBLC_failed_sort_status=get_option('IPBLC_failed_sort_status');


	$IPBLC_cloud_password=get_option('IPBLC_cloud_password');

	

	$IPBLC_cloud_on=get_option('IPBLC_cloud_on');
	if(!$IPBLC_cloud_on)
	{
		update_option('IPBLC_cloud_on','1');
		$IPBLC_cloud_on=get_option('IPBLC_cloud_on');
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




	if(isset($_POST['update_IPBLC_failedlogin']))
	{

		update_option('IPBLC_failedlogin_max',$_POST['IPBLC_failedlogin_max']);
		update_option('IPBLC_failedlogin_time',$_POST['IPBLC_failedlogin_time']);
		update_option('IPBLC_failedlogin_email',$_POST['IPBLC_failedlogin_email']);

		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>Settings saved.</strong></p></div>";

	}


	$IPBLC_failedlogin_max=get_option('IPBLC_failedlogin_max');
	if(!$IPBLC_failedlogin_max)
	{
		update_option('IPBLC_failedlogin_max','5');
		$IPBLC_failedlogin_max=get_option('IPBLC_failedlogin_max');

	}
	$IPBLC_failedlogin_time=get_option('IPBLC_failedlogin_time');
	if(!$IPBLC_failedlogin_time)
	{
		update_option('IPBLC_failedlogin_time','60');
		$IPBLC_failedlogin_time=get_option('IPBLC_failedlogin_time');

	}
	$IPBLC_failedlogin_email=get_option('IPBLC_failedlogin_email');

?>

<BR><BR>

<form method="post" ENCTYPE="multipart/form-data">
<h3>Settings</h3>

<table cellspacing=2 cellpadding=2 class="form-table" style="width: 650px;">


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
<b>Allow "Sort by IP status" in failed login page:</b> 
</td>
<td>
<select id="IPBLC_failed_sort_status" name="IPBLC_failed_sort_status"  style="width: 80px;">
<?php
if($IPBLC_failed_sort_status=="")
{
$optioni1_1="selected";
}
elseif($IPBLC_failed_sort_status=="1")
{
$optioni1_2="selected";
}

?>

<option value="" <?php echo $optioni1_1; ?>>No</option>
<option value="1" <?php echo $optioni1_2; ?>>Yes</option>

</select>
</td>
</tr>



<tr valign="top" valign="top">
<td colspan=2 height=60>
<input type="submit" name="update_IPBLC" id="update_IPBLC" value="Save Changes" class="button-primary">
</td>
</tr>
</table>
</form>
<b style="color: #FF0000;">NOTE: If <i style="color: #000099;">Allow "Sort by IP status" in failed login page</i> is set to YES and does not show any data in "Failed Login" page, please set this option to NO.</b><BR>



<h3>Failed Login Settings (Auto Blacklist)</h3>
<form  method="post" ENCTYPE="multipart/form-data">
<table cellspacing=2 cellpadding=2 class="form-table" style="width: 680px;">


<tr valign="top">
<td>
Maximum attempts: 
</td>
<td>
<input type="input" name="IPBLC_failedlogin_max" id="IPBLC_failedlogin_max" value="<?php echo $IPBLC_failedlogin_max; ?>" class="regular-text" style="width: 180px;">

</td>
</tr>

<tr valign="top">
<td>
Time limit for maximum attempts (minutes): 
</td>
<td>
<input type="input" name="IPBLC_failedlogin_time" id="IPBLC_failedlogin_time" value="<?php echo $IPBLC_failedlogin_time; ?>" class="regular-text" style="width: 180px;"> Minutes

</td>
</tr>

<tr valign="top">
<td>
Send Email on Auto Block: 
</td>
<td>
<input type="input" name="IPBLC_failedlogin_email" id="IPBLC_failedlogin_email" value="<?php echo $IPBLC_failedlogin_email; ?>" class="regular-text" style="width: 180px;"> <small>(Leave blank if you don't want email.)</small>

</td>
</tr>

<tr valign="top" valign="top">
<td colspan=2 height=60>
<input type="submit" name="update_IPBLC_failedlogin" id="update_IPBLC_failedlogin" value="Save Changes" class="button-primary">
</td>
</tr>


</table>
</form>


<h3>Import/Export Blacklisted IP and Usernames Database</h3>

<table cellspacing=2 cellpadding=2 class="form-table" style="width: 550px;">


<tr valign="top">
<td>
Export: 
</td>
<td>
	<input type="submit" name="ExportCloud" id="ExportCloud" class="button-primary" value="Export Database" style="width: 160px;">

</td>
</tr>


<tr valign="top">
<td>
Import: 
</td>
<td>
<?php
		
if(!$_FILES['importCSV'])
{

?>

<form method="post" ENCTYPE="multipart/form-data">
CSV File: 

<input type="file" name="importCSV" id="importCSV" accept=".csv"><BR>
	<input type="submit" name="ImportCloud" id=ImportCloud" class="button-primary" value="Upload File" style="width: 160px;">


</form>
<?php
}
else
{
	$fileX=$_FILES['importCSV'];
	$ext=explode(".",$fileX['name']);
	
	$ext=$ext[count($ext)-1];

	if(strtolower($ext)=="csv")
	{
		$tempName=$fileX['tmp_name'];
		$filename=$upload_dir."/".$fileX['name'];



		move_uploaded_file($tempName,$filename);
		?>


<input type="submit" name="ImportCloud" id="ImportCloud" class="button-primary" value="Import (<?php echo $fileX['name']; ?>)">

<script>
var exportResult=jQuery("#exportResult");
var ajaxloader="<img src=\"<?php echo site_url(); ?>/wp-admin/images/wpspin_light.gif\">";

	jQuery("#ImportCloud").click(function(){

		exportResult.html("Preparing..."+ajaxloader);

		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>/",
			data: {action: "importCSVIPCloud", filename: "<?php echo $fileX['name']; ?>"},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;

			
			if(result)
			{
				if(result=="-1")
				{
					exportResult.html("<font color=red>File not found!</font>");
				}
				else if(result=="[]")
				{
					exportResult.html("<font color=red>File is empty!</font>");
				}
				else
				{
					exportResult.html("Updating Database... "+ajaxloader);
					submitToDB(jQuery.parseJSON(result));

				}
			}
			else
			{
				exportResult.html("<font color=red>Your server is down! Unable to connect to file.</font>");
				//updateToCloud();
			}

		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			exportResult.html("<font color=red>Your server is down! Unable to connect to file.</font>");
			result=false;	
		});


	return false;

	});



	var perc=0;

	var DataDone2=0;
function submitToDB(Data)
{
	totalData=Data.length;
	DataDone=0;	
	DataDone2=0;	
	var IP_Data="";
	var username_Data="";
	for(i in Data)
	{

		if(Data[i].IP)
		{
			IP_Data=Data[i].IP;
			submitToDBIP(IP_Data);
		}
		else if(Data[i].USERNAME)
		{
			username_Data=Data[i].USERNAME;
			submitToDBUsername(username_Data);
			
		}

	}

}






function submitToDBIP(IP) 
{


		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>/",
			data: {action: "submitToDBIP", IP: IP},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			if(result)
			{
				

					if(DataDone==totalData)
					{
						exportResult.html("Updated Database.");
					}	
			}
			else
			{
				exportResult.html("<font color=red>Your server is down! Unable to connect to file.</font>");
				//updateToCloud();
			}

					DataDone2++;
					
					exportResult.html("Updating Database... "+DataDone2+" of "+totalData+" "+ajaxloader);

					if(DataDone2==totalData)
					{
						exportResult.html("Updated Database.");
					}	



		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			exportResult.html("<font color=red>Your server is down! Unable to connect to file.</font>");

					DataDone2++;
					
					exportResult.html("Updating Database... "+DataDone2+" of "+totalData+" "+ajaxloader);

					if(DataDone2==totalData)
					{
						exportResult.html("Updated Database.");
					}	

			result=false;	

		});







}

function submitToDBUsername(username) 
{


		var reRequest=jQuery.ajax({
			  type: "POST",
			  url: "<?php echo site_url(); ?>/",
			data: {action: "submitToDBUSER", USER: username},
  			dataType: "html"
			});

		reRequest.done(function(msg) {
			result=msg;
			//alert(result);

			if(result)
			{				
					if(DataDone==totalData)
					{
						exportResult.html("Updated Database.");
					}	
			}
			else
			{
				exportResult.html("<font color=red>Your server is down! Unable to connect to file.</font>");
				//updateToCloud();
			}

					DataDone2++;
					
					exportResult.html("Updating Database... "+DataDone2+" of "+totalData+" "+ajaxloader);

					if(DataDone2==totalData)
					{
						exportResult.html("Updated Database.");
					}	


		});

		reRequest.fail(function(jqXHR, textStatus) {
			//msg_box.show();
			exportResult.html("<font color=red>Your server is down! Unable to connect to file.</font>");

					DataDone2++;
					
					exportResult.html("Updating Database... "+DataDone2+" of "+totalData+" "+ajaxloader);

					if(DataDone2==totalData)
					{
						exportResult.html("Updated Database.");
					}	


			result=false;	

		});







}





</script>

		<?php

		
	}
}
?>

</td>
</tr>


</table>

<BR><BR>

<div id="exportResult" style="font-weight: bold;"></div>

<BR>

<?php
/*
?>

<form method="post" ENCTYPE="multipart/form-data">
<h3>Cloud Settings</h3>
<BR><b>Note: If you have purchased IP Cloud Server and it is running, turn on "Connect to Cloud" option and set password for this website.</b><BR>

<table cellspacing=2 cellpadding=2 class="form-table" style="width: 650px;">


<tr valign="top">
<td>
<b>Connect to cloud:</b> 
</td>
<td>
<select id="IPBLC_cloud_on" name="IPBLC_cloud_on"  style="width: 80px;">
<?php
if($IPBLC_cloud_on=="1")
{
$option2_1="selected";
$option2_2="";
}
elseif($IPBLC_cloud_on=="2")
{
$option2_2="selected";
$option2_1="";
}

?>

<option value="1" <?php echo $option2_1; ?>>No</option>
<option value="2" <?php echo $option2_2; ?>>Yes</option>

</select>
</td>
</tr>

<tr valign="top">
<td>
<b>Set password:</b>
</td>
<td>
<input type="input" name="IPBLC_cloud_password" id="IPBLC_cloud_password" value="<?php echo $IPBLC_cloud_password; ?>" class="regular-text" style="width: 180px;">
</td>
</tr>

<tr valign="top" valign="top">
<td colspan=2 height=60>
<input type="submit" name="update_cloud_connect" id="update_cloud_connect" value="Save Changes" class="button-primary">
</td>
</tr>

</table>
</form>
<?php
*/
?>
<script>

var exportResult=jQuery("#exportResult");

	jQuery("#ExportCloud").click(function(){

		window.location.href="<?php echo site_url(); ?>/?action=exportIPCloud";

	return false;

	});


</script>





</div>

