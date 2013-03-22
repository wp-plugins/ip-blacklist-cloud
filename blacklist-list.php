<?php





//---start admin options

	?>

<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<h2>IP Blacklist</h2>



<BR>

<B>NOTE:</B> After adding any IP to blacklist, please submit comment on IP-FINDER.ME to help others regarding the issue related to that specific IP.

<BR>









<?php

global $wpdb;



$IP_ID=$_GET['del'];



	if($IP_ID)

	{



		$IP=$wpdb->get_var("SELECT IP FROM ".$wpdb->prefix."IPBLC_blacklist WHERE id='$IP_ID'");



		$wpdb->query("DELETE FROM ".$wpdb->prefix."IPBLC_blacklist WHERE id='$IP_ID'");



		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 

<p><strong>IP Deleted from Blacklist.</strong></p></div>";





//---post data to ip-finder.me

$contextData = array ( 

                'method' => 'POST',

                'header' => "Connection: close\r\n". 

             "Referer: ".site_url()."\r\n");

 

// Create context resource for our request

$context = stream_context_create (array ( 'http' => $contextData ));

 

// Read page rendered as result of your POST request



$link="http://ip-finder.me/wp-content/themes/ipfinder/blacklist_delete.php?IP=$IP&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'));

$post_to_cloud =  file_get_contents (

                  $link,  // page url

                  false,

                  $context);











	}

?>

<BR><BR>





<?php



//-----------------------------------------SETTINGS----------------------------------------



//--Posts per page

$rowsPerPage = 30;



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




$orderby=$_GET['orderby'];
$order=$_GET['order'];
$sort1="sortable";
$sort2="sortable";
$sort3="sortable";
$sort4="sortable";

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




	$current_order="asc";
	if($order=="asc")
	{
		$current_order="desc";
	}







	global $wpdb;







		$totalIP = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."IPBLC_blacklist ORDER BY $orderby $order");

		$resultX = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."IPBLC_blacklist ORDER BY $orderby $order LIMIT $offset, $rowsPerPage");

		//$totalIP=count($totalcomments);





	//print_r($resultX);







	$self="?page=wp-IPBLC-list&orderby=$orderby&order=$order";

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





<table cellspacing=1 cellpadding=1  class="wp-list-table widefat users">





	<thead>

	<tr>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort2; ?> <?php echo $order; ?>'  style="text-align: left; width: 50px;">
<a href="?page=wp-IPBLC-list&orderby=id&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>ID</span><span class="sorting-indicator"></span>
</a>
		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort3; ?> <?php echo $order; ?>'  style="text-align: left;">
<a href="?page=wp-IPBLC-list&orderby=IP&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>IP</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 230px;">Details</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort1; ?> <?php echo $order; ?>'  style="text-align: left; width: 200px;">
<a href="?page=wp-IPBLC-list&orderby=timestamp&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Added on</span><span class="sorting-indicator"></span>
</a>

		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort4; ?> <?php echo $order; ?>'  style="text-align: left;  width: 180px;">

<a href="?page=wp-IPBLC-list&orderby=visits&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Visited after blocking</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 100px;">Actions</th>

	</tr>



	</thead>



	<tfoot>


	<tr>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort2; ?> <?php echo $order; ?>'  style="text-align: left; width: 50px;">
<a href="?page=wp-IPBLC-list&orderby=id&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>ID</span><span class="sorting-indicator"></span>
</a>
		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort3; ?> <?php echo $order; ?>'  style="text-align: left;">
<a href="?page=wp-IPBLC-list&orderby=IP&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>IP</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 230px;">Details</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort1; ?> <?php echo $order; ?>'  style="text-align: left; width: 200px;">
<a href="?page=wp-IPBLC-list&orderby=timestamp&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Added on</span><span class="sorting-indicator"></span>
</a>

		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort4; ?> <?php echo $order; ?>'  style="text-align: left;  width: 180px;">

<a href="?page=wp-IPBLC-list&orderby=visits&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Visited after blocking</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 100px;">Actions</th>

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





	<tr id='user-<?php echo $this_IP->id; ?>' class="alternate"><td class="username column-id"><?php echo $this_IP->id; ?></td>



<td class="username column-username"><?php echo $this_IP->IP; ?></td>

<td class="name column-name">

	<a href="http://ip-finder.me/wpip?IP=<?php echo $IP; ?>" target="_blank" title="IP Details on IP-Finder.me">Submit or Read Comments</a>

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
?>


<td class="name column-name"><?php echo $visits; ?></td>
<td class="name column-name"><a href="?page=wp-IPBLC-list&del=<?php echo $this_IP->id; ?>">Delete</a></td>



</tr>





	<?php

	}

	}

	?>







	</tbody>



</table>


</div>
