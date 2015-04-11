<?php

if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );







global $wpdb;
	if(isset($_SERVER['REMOTE_ADDR']))
	{
		$my_IP=$_SERVER['REMOTE_ADDR'];
	}


	$IPBLC_failed_sort_status=get_option('IPBLC_failed_sort_status');


//---start admin options

	?>

<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<h2>Failed Login</h2>



<BR>

<B>NOTE:</B> After adding any IP to blacklist, please submit comment on IP-FINDER.ME to help others regarding the issue related to that specific IP.

<BR>

<?php


	if(isset($_POST['emptyFailed']))
	{

		$wpdb->query("TRUNCATE TABLE ".$wpdb->prefix."IPBLC_login_failed ");
	
echo "<div id='setting-error-settings_updated' class='updated settings-error'>

	<p><strong>All failed logins details deleted successfully!</strong></p></div>";

	}

?>

<BR><BR>
<form action="?page=wp-IPBLC-failed-login&empty=true" method="POST">
<input type="submit" name="emptyFailed" id="emptyFailed" value="Empty Failed Login Attempts" class="button-primary">
</form>
<BR>
<BR>


<?php



//-----------------------------------------SETTINGS----------------------------------------



//--Posts per page
$rowsPerPage = 50;

// by default we show first page
$pageNum = 1;

// if $_GET['page'] defined, use it as page number
if(isset($_GET['page_num']))
{
    $pageNum = $_GET['page_num'];
}



// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
$page_num=$pageNum;

//---------------------------------------------------------------------------------



$orderby="";
if(isset($_GET['orderby']))
{
	$orderby=sanitize_text_field($_GET['orderby']);
}

$order="";
if(isset($_GET['order']))
{
	$order=sanitize_text_field($_GET['order']);
}

$sort1="sortable";
$sort2="sortable";
$sort3="sortable";
$sort4="sortable";
$sort5="sortable";


if(!$order)
{
	$order="desc";
}
if(!$orderby)
{
	$orderby="timestamp";
}
if(!$page_num)
{
	$page_num="1";
}
if($orderby=="timestamp")
{
	$sort1="sorted";
}
else if($orderby=="id")
{
	$sort2="sorted";
}
else if($orderby=="IP")
{
	$sort3="sorted";
}
else if($orderby=="countx")
{
	$sort4="sorted";
}
else if($orderby=="blc")
{
	$sort5="sorted";
}

	if(!$IPBLC_failed_sort_status && $orderby=="blc")
	{
		$sort5="";
		$orderby="timestamp";
		$sort1="sorted";

	}




	$current_order="asc";
	if($order=="asc")
	{
		$current_order="desc";
	}







	global $wpdb;







		$totalIP = $wpdb->query("SELECT DISTINCT(IP), id, COUNT(IP) as countx,timestamp FROM ".$wpdb->prefix."IPBLC_login_failed  GROUP BY IP  ORDER BY $orderby $order");

		$table1=$wpdb->prefix."IPBLC_login_failed";
		$table2=$wpdb->prefix."IPBLC_blacklist";

		if($IPBLC_failed_sort_status=="1")
		{

		$extraSearch=", (SELECT 1 FROM ".$table2." WHERE ".$table2.".IP=".$table1.".IP) as blc ";

		}
		else
		{
			$extraSearch="";

		}

		$resultX = $wpdb->get_results("SELECT  DISTINCT(IP), id, COUNT(IP) as countx, timestamp  $extraSearch
 FROM ".$wpdb->prefix."IPBLC_login_failed GROUP BY IP ORDER BY $orderby $order LIMIT $offset, $rowsPerPage");




		//$totalIP=count($totalcomments);





	//print_r($resultX);







	$self="?page=wp-IPBLC-failed-login&orderby=$orderby&order=$order";

		$maxPage = ceil($totalIP/$rowsPerPage);



		// print the link to access each page







$nav  = "<BR>Page: ";



// ... the previous code



if($pageNum>10)

{

$xyzz=$pageNum-10;

      $nav .= " <a HREF = \"$self&page_num=$xyzz\">&lt;&lt;</a>- &nbsp; ";

}



for($page = 1; $page <= $maxPage; $page++)

{



   if ($page == $pageNum)

   {

      $nav .= "<b><font color=red> $page </font></b> &nbsp; "; // no need to create a link to current page

   }



   else

   {

		if($page<$pageNum & $page>$pageNum-10)

		{





      $nav .= " <a HREF = \"$self&page_num=$page\">$page</a>  &nbsp; ";

		}



		else if($page>$pageNum & $page<$pageNum+10)

		{

		      $nav .= " <a HREF = \"$self&page_num=$page\">$page</a>  &nbsp; ";

		}



   } 



}

if($pageNum<$maxPage-9)

{

$xyzzz=$pageNum+10;

      $nav .= "- <a HREF = \"$self&page_num=$xyzzz\">&gt;&gt;</a> &nbsp; ";

}



		$nav  .= '<BR>';





		echo "$nav<BR>";

//---------------




?>


		<button name="select_all2" id="select_all2" class="button"  onClick="checkAll_IP2(1);">Check All</button> 
		<button name="unselect_all2" id="unselect_all2" class="button"  onClick="checkAll_IP2(0);">Uncheck All</button> 
		<button name="bIP_all2" id="bIP_all" class="button">Blacklist</button> 

<script>
function checkAll_IP2(flag)
{
	if(flag==0)
	{
		 jQuery("#FailedIPTable INPUT[type='checkbox']").attr('checked',false);
	}
	else 
	{
		 jQuery("#FailedIPTable INPUT[type='checkbox']").attr('checked',true);
	}

}
	var selectedIPs=new Array();


jQuery("#bIP_all").click(function(){

	selectedIPs=[];

	jQuery("#FailedIPTable INPUT[type='checkbox']:checked").each(function(){

	selectedIPs.push(jQuery(this).attr('title'));

});

var domainname="";


	if(!selectedIPs.length)
	{
		alert("Please select IP addresses.");


	}
	else
	{
		var bIPN="";
		for(i in selectedIPs)
		{
			bIPN="bIP_"+selectedIPs[i];
			document.getElementById(bIPN).click();

		}

	}
	return false;

});


</script>

<table cellspacing=1 cellpadding=1  class="wp-list-table widefat users" id="FailedIPTable">





	<thead>

	<tr>
		<th style="width: 20px;">Sel</th>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort2; ?> <?php echo $order; ?>'  style="text-align: left; width: 50px;">
<a href="?page=wp-IPBLC-failed-login&orderby=id&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>ID</span><span class="sorting-indicator"></span>
</a>
		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort3; ?> <?php echo $order; ?>'  style="text-align: left; width: 100px;">
<a href="?page=wp-IPBLC-failed-login&orderby=IP&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>IP</span><span class="sorting-indicator"></span>
</a>


		</th>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort4; ?> <?php echo $order; ?>'  style="text-align: left; width: 100px;">
<a href="?page=wp-IPBLC-failed-login&orderby=countx&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Failed Attempts</span><span class="sorting-indicator"></span>
</a>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort1; ?> <?php echo $order; ?>'  style="text-align: left; width: 90px;">
<a href="?page=wp-IPBLC-failed-login&orderby=timestamp&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Server Time</span><span class="sorting-indicator"></span>
</a>

		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 90px;">Full Details</th>

<?php
		if($IPBLC_failed_sort_status=="1")
		{
?>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort5; ?> <?php echo $order; ?>'  style="text-align: left; width: 90px;">
<a href="?page=wp-IPBLC-failed-login&orderby=blc&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>IP Status</span><span class="sorting-indicator"></span>
</a>

<?php
		}
		else
		{

?>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 100px;">IP Status</th>

<?php
		}

?>



		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 50px;">Actions</th>

	</tr>



	</thead>



	<tfoot>

	<tr>
		<th style="width: 20px;">Sel</th>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort2; ?> <?php echo $order; ?>'  style="text-align: left; width: 50px;">
<a href="?page=wp-IPBLC-failed-login&orderby=id&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>ID</span><span class="sorting-indicator"></span>
</a>
		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort3; ?> <?php echo $order; ?>'  style="text-align: left; width: 100px;">
<a href="?page=wp-IPBLC-failed-login&orderby=IP&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>IP</span><span class="sorting-indicator"></span>
</a>


		</th>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort4; ?> <?php echo $order; ?>'  style="text-align: left; width: 100px;">
<a href="?page=wp-IPBLC-failed-login&orderby=countx&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Failed Attempts</span><span class="sorting-indicator"></span>
</a>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort1; ?> <?php echo $order; ?>'  style="text-align: left; width: 90px;">
<a href="?page=wp-IPBLC-failed-login&orderby=timestamp&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Server Time</span><span class="sorting-indicator"></span>
</a>

		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 90px;">Full Details</th>

<?php
		if($IPBLC_failed_sort_status=="1")
		{
?>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort5; ?> <?php echo $order; ?>'  style="text-align: left; width: 90px;">
<a href="?page=wp-IPBLC-failed-login&orderby=blc&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>IP Status</span><span class="sorting-indicator"></span>
</a>

<?php
		}
		else
		{

?>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 100px;">IP Status</th>

<?php
		}

?>



		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 50px;">Actions</th>

	</tr>


	</tfoot>







	<tbody id="the-list" class='list:user'>





	<?php



	if($resultX)

	{

	foreach($resultX as $this_IP)

	{



		$IP=$this_IP->IP;

	?>





	<tr id='user-<?php echo $this_IP->id; ?>' class="alternate">
<td style="width: 20px;">
<input type="checkbox" class="blacklistedFailedCheck" name="blacklistedFailedCheck['<?php echo $this_IP->IP; ?>']" value="<?php echo $this_IP->IP; ?>" title="<?php echo $this_IP->IP; ?>">


</td>
<td class="username column-id"><?php echo $this_IP->id; ?></td>



<td class="username column-username"><a href="http://ip-finder.me/<?php echo $this_IP->IP; ?>/" title="<?php echo $this_IP->IP; ?>"><?php echo $this_IP->IP; ?></a></td>

<td class="name column-name">
<?php echo $this_IP->countx; ?>
</td>


<td class="name column-name"><?php echo date("M d, Y",$this_IP->timestamp); ?></td>


<?php

	if($this_IP->countx>=4)
	{
?>

<td class="name column-name"><a href="<?php echo site_url(); ?>/?action=failedDetails&IP=<?php echo $this_IP->IP; ?>" target=_blank>DETAILS</a></td>

<?php
	}
	else
	{

?>
<td class="name column-name">
	<?php
		$ippXX=$this_IP->IP;
		$singleDetails = $wpdb->get_results( "SELECT variables FROM ".$wpdb->prefix."IPBLC_login_failed WHERE IP=\"$ippXX\" ORDER BY timestamp DESC");
		if($singleDetails)
		{

			foreach($singleDetails as $dd)
			{
				echo $dd->variables."---------------------------<BR>";
			}
		}


	?>

</td>
<?php
	}

?>


<td class="name column-name">
<?php
		$IP=$this_IP->IP;
		$failedID=$this_IP->id;

			$IP_in_DP=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP='$IP'");
			if($IP_in_DP)
			{
				echo "<span id=\"IPBlack"."$failedID\"><b style=\"color:#FF0000\"> Blacklisted</b></span><BR>";
			}
			else
			{
				echo "<span id=\"IPBlack"."$failedID\"><b style=\"color:#009900\"> Neutral</b></span><BR>";
			}

?>

</td>

<td class="name column-name">

<?php 

		if($my_IP!=$IP)
		{

			echo '<a href="javascript: blacklist_IP(\''.$IP.'\','.$failedID.');" title="Blacklist IP" id="bIP_'.$IP.'">Blacklist IP</a>';
		}
		else
		{
				echo "<b style=\"color:#000099\"> YOUR IP</b>";
		}
?>
</td>



</tr>





	<?php

	}

	}

	?>







	</tbody>



</table>


</div>
