<?php





//---start admin options

	?>

<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<h2>Username Blacklist</h2>

<?php

global $wpdb;



$USER_ID=$_GET['del'];



	if($USER_ID)
	{



		$USER=$wpdb->get_var("SELECT USERNAME FROM ".$wpdb->prefix."IPBLC_usernames WHERE id='$USER_ID'");



		$wpdb->query("DELETE FROM ".$wpdb->prefix."IPBLC_usernames WHERE id='$USER_ID'");



		echo "<div id='setting-error-settings_updated' class='updated settings-error'> 

<p><strong>Username \"$USER\" Deleted from Blacklist.</strong></p></div>";





//---post data to ip-finder.me

$contextData = array ( 

                'method' => 'POST',

                'header' => "Connection: close\r\n". 

             "Referer: ".site_url()."\r\n");

 

// Create context resource for our request

$context = stream_context_create (array ( 'http' => $contextData ));

 

// Read page rendered as result of your POST request

$USER2=urlencode($USER);


$link="http://ip-finder.me/wp-content/themes/ipfinder/blacklist_delete_user.php?USER=$USER2&website=".urlencode(site_url())."&website_name=".urlencode(get_bloginfo('name'));

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







		$totalUSER = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."IPBLC_usernames ORDER BY timestamp DESC");

		$resultX = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."IPBLC_usernames ORDER BY timestamp DESC LIMIT $offset, $rowsPerPage");

		//$totalIP=count($totalcomments);





	//print_r($resultX);







	$self="?page=wp-IPBLC-list-user";

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
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Username</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Details</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Added on</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Visited after blocking</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Actions</th>
	</tr>



	</thead>



	<tfoot>
	<tr>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">ID</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;">Username</th>
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

	foreach($resultX as $this_USER)

	{



		$USER=$this_USER->USERNAME;

		$USER2=urlencode($USER);


	?>





	<tr id='user-<?php echo $this_USER->id; ?>' class="alternate"><td class="username column-id"><?php echo $this_USER->id; ?></td>



<td class="username column-username"><?php echo $this_USER->USERNAME; ?></td>

<td class="name column-name">

	<a href="http://ip-finder.me/wpuser?user=<?php echo $USER2; ?>" target="_blank" title="IP Details on IP-Finder.me">Details on IP Blacklist Cloud</a>

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

