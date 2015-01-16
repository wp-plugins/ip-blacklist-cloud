<?php


if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );

	global $check_all_url_open;

	//echo $check_all_url_open;

	//---start admin options

		$s_value="";
		if(isset($_GET['search']))
		{
			$s_value=mysql_real_escape_string($_GET['search']);
		}

	?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>  
<h2>IP Blacklist</h2>
<BR>
<B>NOTE:</B> After adding any IP to blacklist, please submit comment on IP-FINDER.ME to help others regarding the issue related to that specific IP.
<BR>

<div style="float: right; right: 8px;">
<form action="" method="get">
<p class="search-box">
	<label class="screen-reader-text" for="search">Search IP:</label>
	<input type="search" id="search" name="search" value="<?php echo $s_value; ?>">
	<input type="submit" name="" id="search-submit" class="button" value="Search IP">
	<input type="hidden" id="page" name="page" value="wp-IPBLC-list">
	
</p>
</form>
</div>

<BR>
<?php

global $wpdb;
$IP_ID="";
if(isset($_GET['del']))
{
	$IP_ID=mysql_real_escape_string($_GET['del']);
}




	if($IP_ID && is_numeric($IP_ID))
	{

echo "<BR>";

		$IP=$wpdb->get_var("SELECT IP FROM ".$wpdb->prefix."IPBLC_blacklist WHERE id=\"$IP_ID\"");
		$wpdb->query("DELETE FROM ".$wpdb->prefix."IPBLC_blacklist WHERE id=\"$IP_ID\"");
		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>IP Deleted from Blacklist.</strong></p></div>";
$data = array('test' => '1');
//---post data to ip-finder.me
$contextData = array ( 
                'method' => 'POST',
		'content' => http_build_query($data),
                'header' => "Connection: close\r\n".
                "Content-Type: application/x-www-form-urlencoded\r\n".
 
             "Referer: ".site_url()."\r\n");



$context = stream_context_create (array ( 'http' => $contextData ));

$link="http://www.ip-finder.me/wp-content/themes/ipfinder/blacklist_delete.php?IP=".$IP."&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'));
$post_to_cloud =  file_get_contents (
                  $link,  // page url
                  false,
                  $context);
	}

$mulitpleDelete="";
if(isset($_GET['delX']))
{
	$mulitpleDelete=mysql_real_escape_string($_GET['delX']);
}


	if($mulitpleDelete)
	{
		$explode=explode(",",urldecode($mulitpleDelete));

		$IPData="";
		$IPSep="";

		foreach($explode as $IP_ID)
		{
			if(is_numeric($IP_ID))
			{
			$IP=$wpdb->get_var("SELECT IP FROM ".$wpdb->prefix."IPBLC_blacklist WHERE id='$IP_ID'");
			$wpdb->query("DELETE FROM ".$wpdb->prefix."IPBLC_blacklist WHERE id='$IP_ID'");

			$IPData.=$IPSep.$IP;
			$IPSep=",";
			}
		
		}

$data = array('test' => '1');
//---post data to ip-finder.me
$contextData = array ( 
                'method' => 'POST',
		'content' => http_build_query($data),
                'header' => "Connection: close\r\n". 
                        "Content-Type: application/x-www-form-urlencoded\r\n".

             "Referer: ".site_url()."\r\n");



$context = stream_context_create (array ( 'http' => $contextData ));

$link="http://www.ip-finder.me/wp-content/themes/ipfinder/blacklist_delete_multiple.php?IPx=".$IPData."&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'));

//echo $link;

$post_to_cloud =  file_get_contents (
                  $link,  // page url
                  false,
                  $context);


//echo $post_to_cloud;

		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
<p><strong>IP Deleted from Blacklist.</strong></p></div>";

	}


?>
<BR><BR>
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
	$orderby=mysql_real_escape_string($_GET['orderby']);
}

$order="";
if(isset($_GET['order']))
{
	$order=mysql_real_escape_string($_GET['order']);
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
else if($orderby=="visits")
{
	$sort4="sorted";
}
else if($orderby=="lastvisit")
{
	$sort5="sorted";
}




	$current_order="asc";
	if($order=="asc")
	{
		$current_order="desc";
	}







	global $wpdb;



		


		if($s_value=="")
		{

		$totalIP = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."IPBLC_blacklist ORDER BY $orderby $order");

		$resultX = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."IPBLC_blacklist ORDER BY $orderby $order LIMIT $offset, $rowsPerPage");

		//$totalIP=count($totalcomments);

		}
		else
		{
			$ss=$s_value;

		$totalIP = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."IPBLC_blacklist WHERE IP LIKE \"%$ss%\" ORDER BY $orderby $order");

		$resultX = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."IPBLC_blacklist  WHERE IP LIKE \"%$ss%\" ORDER BY $orderby $order LIMIT $offset, $rowsPerPage");



		}



	//print_r($resultX);






	$sss=$s_value;

	$self="?page=wp-IPBLC-list&orderby=$orderby&order=$order&search=$sss";

		$maxPage = ceil($totalIP/$rowsPerPage);



		// print the link to access each page







$nav  = "<BR>Page: ";



// ... the previous code



if($pageNum>10)

{

$xyzz=$pageNum-10;

      $nav .= " <a HREF = \"$self&page_num=$xyzz\">&lt;&lt;</a>-";

}



for($page = 1; $page <= $maxPage; $page++)

{



   if ($page == $pageNum)

   {

      $nav .= "<b><font color=red> $page </font></b>"; // no need to create a link to current page

   }



   else

   {

		if($page<$pageNum & $page>$pageNum-10)

		{





      $nav .= " <a HREF = \"$self&page_num=$page\">$page</a> ";

		}



		else if($page>$pageNum & $page<$pageNum+10)

		{

		      $nav .= " <a HREF = \"$self&page_num=$page\">$page</a> ";

		}



   } 



}

if($pageNum<$maxPage-9)

{

$xyzzz=$pageNum+10;

      $nav .= "- <a HREF = \"$self&page_num=$xyzzz\">&gt;&gt;</a>";

}



		$nav  .= '<BR>';





		echo "$nav<BR>";

//---------------




?>


		<button name="select_all" id="select_all" class="button"  onClick="checkAll_IP(1);">Check All</button> 
		<button name="unselect_all" id="unselect_all" class="button"  onClick="checkAll_IP(0);">Uncheck All</button> 
		<button name="deleteIP_all" id="deleteIP_all" class="button">Delete</button> 

<script>
function checkAll_IP(flag)
{
	if(flag==0)
	{
		 jQuery("#theip-list INPUT[type='checkbox']").attr('checked',false);
	}
	else 
	{
		 jQuery("#theip-list INPUT[type='checkbox']").attr('checked',true);
	}

}
	var selectedIPs=new Array();


jQuery("#deleteIP_all").click(function(){

	selectedIPs=[];

	jQuery("#theip-list INPUT[type='checkbox']:checked").each(function(){

	selectedIPs.push(jQuery(this).attr('title'));

});

var domainname="";


	if(!selectedIPs.length)
	{
		alert("Please select IP addresses.");


	}
	else
	{
		 deleteMultipleIP(selectedIPs);

	}
	return false;

});
function deleteMultipleIP(IPs)
{
	var loc="&delX=";
	var sep="";
	var orderby="<?php echo $orderby; ?>";
	var order="<?php echo $order; ?>";
	for(i in IPs)
	{
		loc+=sep+IPs[i];
		sep=",";
	}
	window.location.href="?page=wp-IPBLC-list"+loc+"&orderby="+orderby+"&order="+order;


}

</script>


<table cellspacing=1 cellpadding=1  class="wp-list-table widefat users">





	<thead>

	<tr>
		<th style="width: 25px;"></th>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort2; ?> <?php echo $order; ?>'  style="text-align: left; width: 50px;">
<a href="?page=wp-IPBLC-list&orderby=id&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>&search=<?php echo $sss; ?>">
<span>ID</span><span class="sorting-indicator"></span>
</a>
		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort3; ?> <?php echo $order; ?>'  style="text-align: left;">
<a href="?page=wp-IPBLC-list&orderby=IP&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>&search=<?php echo $sss; ?>">
<span>IP</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 230px;">Details</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort1; ?> <?php echo $order; ?>'  style="text-align: left; width: 200px;">
<a href="?page=wp-IPBLC-list&orderby=timestamp&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>&search=<?php echo $sss; ?>">
<span>Added on</span><span class="sorting-indicator"></span>
</a>

		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort4; ?> <?php echo $order; ?>'  style="text-align: left;  width: 180px;">

<a href="?page=wp-IPBLC-list&orderby=visits&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>&search=<?php echo $sss; ?>">
<span>Visited after blocking</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort5; ?> <?php echo $order; ?>'  style="text-align: left;  width: 100px;">

<a href="?page=wp-IPBLC-list&orderby=lastvisit&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>&search=<?php echo $sss; ?>">
<span>Last Attack</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 100px;">Actions</th>

	</tr>



	</thead>



	<tfoot>


	<tr>
		<th style="width: 25px;"></th>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort2; ?> <?php echo $order; ?>'  style="text-align: left; width: 50px;">
<a href="?page=wp-IPBLC-list&orderby=id&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>&search=<?php echo $sss; ?>">
<span>ID</span><span class="sorting-indicator"></span>
</a>
		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort3; ?> <?php echo $order; ?>'  style="text-align: left;">
<a href="?page=wp-IPBLC-list&orderby=IP&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>&search=<?php echo $sss; ?>">
<span>IP</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 230px;">Details</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort1; ?> <?php echo $order; ?>'  style="text-align: left; width: 200px;">
<a href="?page=wp-IPBLC-list&orderby=timestamp&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>&search=<?php echo $sss; ?>">
<span>Added on</span><span class="sorting-indicator"></span>
</a>

		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort4; ?> <?php echo $order; ?>'  style="text-align: left;  width: 180px;">

<a href="?page=wp-IPBLC-list&orderby=visits&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>&search=<?php echo $sss; ?>">
<span>Visited after blocking</span><span class="sorting-indicator"></span>
</a>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort5; ?> <?php echo $order; ?>'  style="text-align: left;  width: 100px;">

<a href="?page=wp-IPBLC-list&orderby=lastvisit&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>&search=<?php echo $sss; ?>">
<span>Last Attack</span><span class="sorting-indicator"></span>
</a>


		</th>



		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 100px;">Actions</th>

	</tr>







	</tfoot>







	<tbody id="theip-list" class='list:user'>





	<?php



	if($resultX)

	{

	foreach($resultX as $this_IP)

	{



		$IP=$this_IP->IP;

	?>



	

	<tr id='user-<?php echo $this_IP->id; ?>' class="alternate">
<td>

<input type="checkbox" class="blacklistedIPCheck" name="blacklistedIPCheck[<?php echo $this_IP->id; ?>]" value="<?php echo $this_IP->id; ?>" title="<?php echo $this_IP->id; ?>">
</td>

<td class="username column-id"><?php echo $this_IP->id; ?></td>



<td class="username column-username"><?php echo $this_IP->IP; ?></td>

<td class="name column-name">

	<a href="http://www.ip-finder.me/<?php echo $IP; ?>/" target="_blank" title="IP Details on IP-Finder.me">Submit or Read Comments</a>

</td>

<td class="name column-name"><?php echo date("M d, Y",$this_IP->timestamp); ?></td>

<?php
$visits=$this_IP->visits;
if(!$visits)
{
	$visits=0;
}

if($visits>1)
{
	$visits="$visits times";
}
else
{
	$visits="$visits time";
}

$last=$this_IP->lastvisit;
if($last>0)
{
	$last=date("M d, Y",$last);
}
else
{
	$last="N/A";
}
?>


<td class="name column-name"><?php echo $visits; ?></td>
<td class="name column-name"><?php echo $last; ?></td>
<td class="name column-name"><a href="?page=wp-IPBLC-list&del=<?php echo $this_IP->id; ?>">Delete</a></td>



</tr>





	<?php

	}

	}

	?>







	</tbody>



</table>


</div>
