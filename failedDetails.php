<?php

if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );


global $this_plugin_url;

?>


<?php

if(!filter_var($IP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
{
	exit();

}
if(!$manage)
{
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<title><?php echo $IP; ?> Failed Login Details</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo $this_plugin_url."bootstrap.css"; ?>" rel="stylesheet">
    <link href="<?php echo $this_plugin_url."bootstrap-responsive.css"; ?>" rel="stylesheet">
</head>
<body>
<div class="container">


<h2><?php echo $IP; ?> Failed Login Details</h2>
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


$totalIP = $wpdb->query($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."IPBLC_login_failed  WHERE IP=%s  ORDER BY timestamp desc",$IP));


$resultX = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."IPBLC_login_failed  WHERE IP=%s ORDER BY timestamp desc LIMIT $offset, $rowsPerPage",$IP));








	$self="?action=failedDetails&IP=$IP";

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
   {		if($page<$pageNum & $page>$pageNum-10)
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

?>

<div id="page1" style="font-size: 16px;"><?php echo $nav; ?><BR></div>


<table class="table table-bordered table-hover table-condensed">
    <thead style="background-color: #EEEEEE; ">
         <tr>
	      <th style="width: 40px;">id</th>
	      <th style="max-width: 240px;">User Agent</th>
	      <th style="width: 250px;">Query Vars</th>
	      <th style="width: 100px;">Server Time</th>
	</tr>
    </thead>
	<tbody id="domainsTableBody">
<?php

if($resultX)
{

	foreach($resultX as $this_IP)
	{

		$userAgent=$this_IP->useragent;
		$vars=$this_IP->variables;
		$idd=$this_IP->id;
		$timeX=date("M d, Y",$this_IP->timestamp);

		echo "<tr><td>$idd</td><td>$userAgent</td><td>$vars</td><td>$timeX</td></tr>";
	}



}
?>

	</tbody>


    <tfoot style="background-color: #EEEEEE; ">
         <tr>
	      <th style="width: 40px;">id</th>
	      <th style="max-width: 240px;">User Agent</th>
	      <th style="width: 250px;">Query Vars</th>
	      <th style="width: 100px;">Server Time</th>
	</tr>
    </tfoot>
</table>



<div id="page2" style="font-size: 16px;"><BR><?php echo $nav; ?></div>
<BR><BR><BR><BR>

</div>
</body>
</html>
