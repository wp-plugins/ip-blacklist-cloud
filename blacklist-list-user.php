<?php

if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );

?>


<?php





//---start admin options

	?>

<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<h2>Username Blacklist</h2>

<?php

global $wpdb;



$USER_ID="";
if(isset($_GET['del']))
{
	$USER_ID=mysql_real_escape_string($_GET['del']);
}




	if($USER_ID && is_numeric($USER_ID))
	{



		$USER=$wpdb->get_var("SELECT USERNAME FROM ".$wpdb->prefix."IPBLC_usernames WHERE id=\"$USER_ID\"");


		if($USER)
		{
			$wpdb->query("DELETE FROM ".$wpdb->prefix."IPBLC_usernames WHERE id=\"$USER_ID\"");
		}


		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 

<p><strong>Username \"$USER\" Deleted from Blacklist.</strong></p></div>";




$data = array('test' => '1');
//---post data to ip-finder.me
$contextData = array ( 
                'method' => 'POST',
		'content' => http_build_query($data),
                'header' => "Connection: close\r\n". 
                        "Content-Type: application/x-www-form-urlencoded\r\n".

             "Referer: ".site_url()."\r\n");


 

// Create context resource for our request

$context = stream_context_create (array ( 'http' => $contextData ));

 

// Read page rendered as result of your POST request

$USER2=urlencode($USER);


$link="http://www.ip-finder.me/wp-content/themes/ipfinder/blacklist_delete_user.php?USER=".$USER2."&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'));

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



$orderby="";
if(isset($_GET['orderby']))
{
	$orderby=$_GET['orderby'];
}

$order="";
if(isset($_GET['order']))
{
	$order=$_GET['order'];
}


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
else if($orderby=="USERNAME")
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







		$totalUSER = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."IPBLC_usernames ORDER BY $orderby $order");

		$resultX = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."IPBLC_usernames ORDER BY $orderby $order LIMIT $offset, $rowsPerPage");

		//$totalIP=count($totalcomments);





	//print_r($resultX);







	$self="?page=wp-IPBLC-list-user&orderby=$orderby&order=$order";

		$maxPage = ceil($totalUSER/$rowsPerPage);



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
<a href="?page=wp-IPBLC-list-user&orderby=id&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>ID</span><span class="sorting-indicator"></span>
</a>
		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort3; ?> <?php echo $order; ?>'  style="text-align: left;">
<a href="?page=wp-IPBLC-list-user&orderby=USERNAME&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Username</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 230px;">Details</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort1; ?> <?php echo $order; ?>'  style="text-align: left; width: 200px;">
<a href="?page=wp-IPBLC-list-user&orderby=timestamp&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Added on</span><span class="sorting-indicator"></span>
</a>

		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort4; ?> <?php echo $order; ?>'  style="text-align: left; width: 180px;">

<a href="?page=wp-IPBLC-list-user&orderby=visits&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Visited after blocking</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 100px;">Actions</th>

	</tr>



	</thead>



	<tfoot>

	<tr>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort2; ?> <?php echo $order; ?>'  style="text-align: left; width: 50px;">
<a href="?page=wp-IPBLC-list-user&orderby=id&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>ID</span><span class="sorting-indicator"></span>
</a>
		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort3; ?> <?php echo $order; ?>'  style="text-align: left;">
<a href="?page=wp-IPBLC-list-user&orderby=USERNAME&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Username</span><span class="sorting-indicator"></span>
</a>


		</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 230px;">Details</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort1; ?> <?php echo $order; ?>'  style="text-align: left; width: 200px;">
<a href="?page=wp-IPBLC-list-user&orderby=timestamp&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Added on</span><span class="sorting-indicator"></span>
</a>

		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort4; ?> <?php echo $order; ?>'  style="text-align: left; width: 180px;">

<a href="?page=wp-IPBLC-list-user&orderby=visits&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
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

	foreach($resultX as $this_USER)

	{



		$USER=$this_USER->USERNAME;

		$USER2=urlencode($USER);


	?>





	<tr id='user-<?php echo $this_USER->id; ?>' class="alternate"><td class="username column-id"><?php echo $this_USER->id; ?></td>



<td class="username column-username"><?php echo $this_USER->USERNAME; ?></td>

<td class="name column-name">

	<a href="http://www.ip-finder.me/wpuser?user=<?php echo $USER2; ?>" target="_blank" title="IP Details on IP-Finder.me">Details on IP Blacklist Cloud</a>

</td>

<td class="name column-name"><?php echo date("M d, Y",$this_USER->timestamp); ?></td>
<?php
$visits=$this_USER->visits;
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
<td class="name column-name"><a href="?page=wp-IPBLC-list-user&del=<?php echo $this_USER->id; ?>">Delete</a></td>



</tr>





	<?php

	}

	}

	?>







	</tbody>



</table>







</div>

