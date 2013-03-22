<?php



global $wpdb;


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




	$current_order="asc";
	if($order=="asc")
	{
		$current_order="desc";
	}







	global $wpdb;







		$totalIP = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."IPBLC_login_failed ORDER BY $orderby $order");

		$resultX = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."IPBLC_login_failed ORDER BY $orderby $order LIMIT $offset, $rowsPerPage");

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
<a href="?page=wp-IPBLC-failed-login&orderby=id&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>ID</span><span class="sorting-indicator"></span>
</a>
		</th>
		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort3; ?> <?php echo $order; ?>'  style="text-align: left; width: 100px;">
<a href="?page=wp-IPBLC-failed-login&orderby=IP&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>IP</span><span class="sorting-indicator"></span>
</a>


		</th>

		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 150px;">User Agent</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 130px;">Query Vars</th>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort1; ?> <?php echo $order; ?>'  style="text-align: left; width: 90px;">
<a href="?page=wp-IPBLC-failed-login&orderby=timestamp&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Server Time</span><span class="sorting-indicator"></span>
</a>

		</th>

		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 90px;">IP Status</th>

		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 50px;">Actions</th>

	</tr>



	</thead>



	<tfoot>

	<tr>

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

		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 150px;">User Agent</th>
		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 130px;">Query Vars</th>

		<th scope='col' id='posts' class='manage-column column-posts  <?php echo $sort1; ?> <?php echo $order; ?>'  style="text-align: left; width: 90px;">
<a href="?page=wp-IPBLC-failed-login&orderby=timestamp&order=<?php echo $current_order; ?>&page_num=<?php echo $page_num; ?>">
<span>Server Time</span><span class="sorting-indicator"></span>
</a>

		</th>

		<th scope='col' id='posts' class='manage-column column-posts num'  style="text-align: left;  width: 90px;">IP Status</th>

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





	<tr id='user-<?php echo $this_IP->id; ?>' class="alternate"><td class="username column-id"><?php echo $this_IP->id; ?></td>



<td class="username column-username"><a href="http://ip-finder.me/<?php echo $this_IP->IP; ?>/" title="<?php echo $this_IP->IP; ?>"><?php echo $this_IP->IP; ?></a></td>

<td class="name column-name">
<?php echo $this_IP->useragent; ?>
</td>

<td class="name column-name">
<?php echo $this_IP->variables; ?>
</td>

<td class="name column-name"><?php echo date("M d, Y",$this_IP->timestamp); ?></td>


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

	echo '<a href="javascript: blacklist_IP(\''.$IP.'\','.$failedID.');" title="Blacklist IP">Blacklist IP</a>';

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
