<?php

if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );



?>


<?php





//---start admin options

	?>

<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<?php

global $wpdb;
		if(isset($_POST['fix_DB']))
		{


			//$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames CHANGE `visits`  `visits` INT( 50 ) NOT NULL");

			$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist CHANGE `visits`  `visits` INT( 50 ) NOT NULL");
			$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist CHANGE `IP`  `IP` VARCHAR( 25 ) NOT NULL");
			$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist CHANGE `timestamp`  `timestamp` INT( 30 ) NOT NULL");

			$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames CHANGE `visits`  `visits` INT( 50 ) NOT NULL");
			$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames CHANGE `timestamp`  `timestamp` INT( 30 ) NOT NULL");

			$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_login_failed CHANGE `timestamp`  `timestamp` INT( 25 ) NOT NULL");
			$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_login_failed CHANGE `useragent`  `useragent` VARCHAR( 225 ) NOT NULL");
			$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_login_failed CHANGE `IP`  `IP` VARCHAR( 25 ) NOT NULL");


			$wpdb->query("CREATE INDEX ipIndex on ".$wpdb->prefix."IPBLC_blacklist(`IP`,`visits`,`timestamp`)");
			$wpdb->query("CREATE INDEX uIndex1 on ".$wpdb->prefix."IPBLC_usernames(`visits`,`timestamp`)");
			$wpdb->query("CREATE INDEX uIndex1 on ".$wpdb->prefix."IPBLC_login_failed(`IP`,`timestamp`)");
			$wpdb->query("CREATE FULLTEXT INDEX uIndex2 on ".$wpdb->prefix."IPBLC_usernames(`USERNAME`)");
			$wpdb->query("CREATE FULLTEXT INDEX uIndex2 on ".$wpdb->prefix."IPBLC_login_failed(`variables`)");


			echo "<div id='setting-error-settings_updated' class='updated settings-error'>

				<p><strong>Database fixed!</strong></p></div>";


		}

		if(isset($_POST['fix_DB2']))
		{


			//$wpdb->query("ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames CHANGE `visits`  `visits` INT( 50 ) NOT NULL");


			$wpdb->query("CREATE INDEX ipIndexV on ".$wpdb->prefix."IPBLC_blacklist(`lastvisit`,`timestamp`)");
			$wpdb->query("CREATE INDEX uIndexV on ".$wpdb->prefix."IPBLC_usernames(`lastvisit`,`timestamp`)");


			echo "<div id='setting-error-settings_updated' class='updated settings-error'>

				<p><strong>Database fixed!</strong></p></div>";


		}

?>



<BR>

<h2>Fix Database</h2>
<h3>Fix Database - 1</h3>

<BR>
<?php

			$foundIndex=0;

			$results=$wpdb->get_results("SHOW INDEX FROM ".$wpdb->prefix."IPBLC_blacklist");


			//print_r($results);

			if($results)
			{
				foreach($results as $indexes)
				{
					if($indexes->Key_name=="ipIndex")
					{
						$foundIndex=1;
					}
				}

			}

			if($foundIndex==0)
			{
				echo "Indexes not found for Database Tables!";


				?>
				<form method="POST">
					

				<input type="submit" name="fix_DB" id="fix_DB" value="Apply Fix!" class="button-primary">

				</form>

				<?php



			}	
			else
			{
				echo "<b style=\"color: #009900;\">Indexes Found on tables!</b>";

			}		
?>


<h3>Fix Database - 2</h3>
<BR>
<?php

			$foundIndex=0;

			$results=$wpdb->get_results("SHOW INDEX FROM ".$wpdb->prefix."IPBLC_blacklist");


			//print_r($results);

			if($results)
			{
				foreach($results as $indexes)
				{
					if($indexes->Key_name=="ipIndexV")
					{
						$foundIndex=1;
					}
				}

			}

			if($foundIndex==0)
			{
				echo "Last Visit Indexes not found for Database Tables!";


				?>
				<form method="POST">
					

				<input type="submit" name="fix_DB2" id="fix_DB2" value="Apply Fix!" class="button-primary">

				</form>

				<?php



			}	
			else
			{
				echo "<b style=\"color: #009900;\">Last Visit Indexes Found on tables!</b>";

			}		
?>

</div>

