<?php 

if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );


$commentID="";
if(isset($_POST['comment_ID']))
{
	$commentID=$_POST['comment_ID'];
}


$reff="";
$host="";

if(isset($_SERVER['HTTP_REFERER']))
{
	$reff=$_SERVER['HTTP_REFERER'];
}
if(isset($_SERVER['HTTP_HOST']))
{
	$host=$_SERVER['HTTP_HOST'];
}

//echo "$reff<BR>";


//echo "$host<BR>";
$check=str_replace($host,"",$reff);
if($check==$ref)
{
	//echo "exiting....";
	exit();
}
$commentData=get_comment($commentID);

//print_r($commentData);

$comment_author=$commentData->comment_author;
$comment_email=$commentData->comment_author_email;
$comment_content=$commentData->comment_content;
$comment_website=site_url();

$comment_author_website=$commentData->comment_author_url;

if($comment_author!="admin")
{

$url="http://www.ip-finder.me/spamcheck3/";


$handle = curl_init($url);
 curl_setopt($handle, CURLOPT_POSTFIELDS,"Cauthor=$comment_author&Cversion=3.2&Cid=$commentID&Cemail=$comment_email&Curl=$comment_website&Ccomment=$comment_content&author_url=".urlencode($comment_author_website));



 curl_setopt($handle, CURLOPT_POST, 1);
 curl_setopt($handle,CURLOPT_REFERER,$comment_website);
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($handle, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt( $handle, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $handle, CURLOPT_ENCODING, "" );
curl_setopt( $handle, CURLOPT_AUTOREFERER, true );
curl_setopt( $handle, CURLOPT_MAXREDIRS, 10 );

$header_info = curl_getinfo( $handle );
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
$response = curl_exec($handle);
$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
curl_close($handle);

	echo $response;

}
else
{
	echo "no reports for admin";
}

exit();
?>	