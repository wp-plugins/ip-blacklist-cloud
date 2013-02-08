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

$rowsPerPage = 15;



// by default we show first page

$pageNum = 1;



// if $_GET['page'] defined, use it as page number

if(isset($_GET['page_num']))

{

    $pageNum = $_GET['page_num'];

}



// counting the offset

$offset = ($pageNum - 1) * $rowsPerPage;



//---------------------------------------------------------------------------------





	global $wpdb;







		$totalIP = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."IPBLC_blacklist ORDER BY timestamp DESC");

		$resultX = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."IPBLC_blacklist ORDER BY timestamp DESC LIMIT $offset, $rowsPerPage");

		//$totalIP=count($totalcomments);





	//print_r($resultX);







	$self="?page=wp-IPBLC-list";

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

      $nav .= "- <a HREF = \"$self&page_num$xyzzz\">&gt;&gt;</a>";

}



		$nav  .= '<BR>';





		echo "$nav<BR>";

//---------------







?>





<table cellspacing=1 cellpadding=1  class="wp-list-table widefat users">





<thead>

	<tr>

		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">ID</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">IP</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Details</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Added on</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Visited after blocking</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Actions</th>

	</tr>



	</thead>



	<tfoot>

	<tr>

		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">ID</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">IP</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Details</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Added on</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Visited after blocking</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Actions</th>



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
