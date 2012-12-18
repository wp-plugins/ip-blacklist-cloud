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
		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>Settings saved.</strong></p></div>";
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





<tr valign="top" valign="top">
<td colspan=2 height=60>
<input type="submit" name="update_IPBLC" id="update_IPBLC" value="Save Changes" class="button-primary">
</td>
</tr>
</table>
</form>




</div>

