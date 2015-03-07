<?php

if ( !defined('ABSPATH') )
    die ( 'No direct script access allowed' );



?>


<?php


		update_option('IPBLC_fixes','1');



//---start admin options

	?>

<div class="wrap">

<div id="icon-options-general" class="icon32"><br /></div>  

<?php

global $wpdb;

		if(isset($_POST['fix_all']))
		{
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames CHANGE  `USERNAME` `USERNAME` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames ENGINE = MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist ENGINE = MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_login_failed ENGINE = MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames ADD  `visits` INT( 50 ) NOT NULL");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist ADD  `visits` INT( 50 ) NOT NULL");

		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames CHANGE `visits`  `visits` INT( 50 ) NOT NULL");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist CHANGE `visits`  `visits` INT( 50 ) NOT NULL");

		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames ADD  `lastvisit` INT( 50 ) NOT NULL");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist ADD  `lastvisit` INT( 50 ) NOT NULL");

		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames CHANGE `lastvisit`  `lastvisit` INT( 50 ) NOT NULL");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist CHANGE `lastvisit`  `lastvisit` INT( 50 ) NOT NULL");

		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames ADD  `timestamp` INT( 30 ) NOT NULL");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist ADD  `timestamp` INT( 30 ) NOT NULL");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_login_failed ADD  `timestamp` INT( 30 ) NOT NULL");

		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_usernames CHANGE `timestamp`  `timestamp` INT( 30 ) NOT NULL");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist CHANGE `timestamp`  `timestamp` INT( 30 ) NOT NULL");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_login_failed CHANGE `timestamp`  `timestamp` INT( 30 ) NOT NULL");



		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_blacklist CHANGE `IP`  `IP` VARCHAR( 25 ) NOT NULL");
		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_login_failed CHANGE `IP`  `IP` VARCHAR( 25 ) NOT NULL");

		$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_login_failed CHANGE `useragent`  `useragent` VARCHAR( 225 ) NOT NULL");
	$wpdb->query( "ALTER TABLE  ".$wpdb->prefix."IPBLC_login_failed CHANGE `variables`  `variables` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");



			echo "<div id='setting-error-settings_updated' class='updated settings-error'>

				<p><strong>Tables fixed!</strong></p></div>";

		}

		if(isset($_POST['fix_DB']))
		{




			$wpdb->query( "CREATE INDEX ipIndex on ".$wpdb->prefix."IPBLC_blacklist(`IP`,`visits`,`timestamp`)");
			$wpdb->query( "CREATE INDEX uIndex1 on ".$wpdb->prefix."IPBLC_usernames(`visits`,`timestamp`)");
			$wpdb->query( "CREATE INDEX uIndex1 on ".$wpdb->prefix."IPBLC_login_failed(`IP`,`timestamp`)");
			$wpdb->query( "CREATE FULLTEXT INDEX uIndex2 on ".$wpdb->prefix."IPBLC_usernames(`USERNAME`)");
			$wpdb->query( "CREATE FULLTEXT INDEX uIndex2 on ".$wpdb->prefix."IPBLC_login_failed(`variables`)");


			echo "<div id='setting-error-settings_updated' class='updated settings-error'>

				<p><strong>Tables fixed!</strong></p></div>";


		}

		if(isset($_POST['fix_DB2']))
		{


			$wpdb->query( "CREATE INDEX ipIndexV on ".$wpdb->prefix."IPBLC_blacklist(`lastvisit`,`timestamp`)");
			$wpdb->query( "CREATE INDEX uIndexV on ".$wpdb->prefix."IPBLC_usernames(`lastvisit`,`timestamp`)");


			echo "<div id='setting-error-settings_updated' class='updated settings-error'>

				<p><strong>Tables fixed!</strong></p></div>";


		}



			$cc=$wpdb->get_results( "SHOW FIELDS from `".$wpdb->prefix."IPBLC_blacklist`");

			$blc_fields=array();
			$blc_fields_found=array();
			$blc_fields[]="IP";
			$blc_fields[]="timestamp";
			$blc_fields[]="visits";
			$blc_fields[]="lastvisit";

			$blc_type_ok=1;

//echo "<pre>";
			foreach($cc as $k)
			{
//				print_r($k);
				$field=$k->Field;
				$blc_fields_found[]=$field;

				if($field=="IP")
				{
					if($k->Type!="varchar(25)")
					{
						$blc_type_ok=0;

					}
				}
				elseif($field=="timestamp")
				{
					if($k->Type!="int(30)")
					{
						$blc_type_ok=0;

					}
				}
				elseif($field=="visits")
				{
					if($k->Type!="int(50)")
					{
						$blc_type_ok=0;

					}
				}
				elseif($field=="lastvisit")
				{
					if($k->Type!="int(50)")
					{
						$blc_type_ok=0;

					}
				}

			}


//			print_r($blc_fields_found);

			$blc_ok=1;

			foreach($blc_fields as $f)
			{
				if(!in_array($f,$blc_fields_found))
				{
					$blc_ok=0;
				}
			}

//echo "</pre>";




			$cc=$wpdb->get_results( "SHOW FIELDS from `".$wpdb->prefix."IPBLC_usernames`");

			$user_fields=array();
			$user_fields_found=array();
			$user_fields[]="USERNAME";
			$user_fields[]="timestamp";
			$user_fields[]="visits";
			$user_fields[]="lastvisit";


			$user_type_ok=1;

//echo "<pre>";
			foreach($cc as $k)
			{
//				print_r($k);
				$field=$k->Field;
				$user_fields_found[]=$field;

				if($field=="USERNAME")
				{
					if($k->Type!="text")
					{
						$user_type_ok=0;

					}
				}
				elseif($field=="timestamp")
				{
					if($k->Type!="int(30)")
					{
						$user_type_ok=0;

					}
				}
				elseif($field=="visits")
				{
					if($k->Type!="int(50)")
					{
						$user_type_ok=0;

					}
				}
				elseif($field=="lastvisit")
				{
					if($k->Type!="int(50)")
					{
						$user_type_ok=0;

					}
				}

			}



//			print_r($user_fields_found);

			$user_ok=1;

			foreach($user_fields as $f)
			{
				if(!in_array($f,$user_fields_found))
				{
//					echo "\n\n-----$f-----\n\n";
					$user_ok=0;
				}
			}

//echo "</pre>";






			$cc=$wpdb->get_results( "SHOW FIELDS from `".$wpdb->prefix."IPBLC_login_failed`");

			$failed_fields=array();
			$failed_fields_found=array();
			$failed_fields[]="IP";
			$failed_fields[]="useragent";
			$failed_fields[]="variables";
			$failed_fields[]="timestamp";

			$failed_type_ok=1;


//echo "<pre>";
			foreach($cc as $k)
			{
//				print_r($k);
				$field=$k->Field;
				$failed_fields_found[]=$field;

				if($field=="IP")
				{
					if($k->Type!="varchar(25)")
					{
						$failed_type_ok=0;

					}
				}
				elseif($field=="useragent")
				{
					if($k->Type!="varchar(225)")
					{
						$failed_type_ok=0;

					}
				}
				elseif($field=="variables")
				{
					if($k->Type!="text")
					{
						$failed_type_ok=0;

					}
				}
				elseif($field=="timestamp")
				{
					if($k->Type!="int(30)")
					{
						$failed_type_ok=0;

					}
				}

			}



//			print_r($failed_fields_found);

			$failed_ok=1;

			foreach($failed_fields as $f)
			{
				if(!in_array($f,$failed_fields_found))
				{
					//echo "\n\n-----$f-----\n\n";
					$failed_ok=0;
				}
			}

//echo "</pre>";







//-----check tables type---


			$cc=$wpdb->get_results( "SHOW TABLE STATUS FROM ".DB_NAME." LIKE '".$wpdb->prefix."IPBLC_blacklist'");

//echo "<pre>";
//		print_r($cc);
			
		$blc_engine_ok=1;
		$blc_collation_ok=1;

		foreach($cc as $k)
		{
			$engine=$k->Engine;
			$collation=$k->Collation;
			if($engine!="MyISAM")
			{
				$blc_engine_ok=0;
				
			}
			if($collation!="utf8_general_ci")
			{
				$blc_collation_ok=0;
				
			}

		}

//echo "</pre>";


			$cc=$wpdb->get_results( "SHOW TABLE STATUS FROM ".DB_NAME." LIKE '".$wpdb->prefix."IPBLC_usernames'");

//echo "<pre>";
//		print_r($cc);
			
		$user_engine_ok=1;
		$user_collation_ok=1;

		foreach($cc as $k)
		{
			$engine=$k->Engine;
			$collation=$k->Collation;
			if($engine!="MyISAM")
			{
				$user_engine_ok=0;
				
			}
			if($collation!="utf8_general_ci")
			{
				$user_collation_ok=0;
				
			}

		}

//echo "</pre>";



			$cc=$wpdb->get_results( "SHOW TABLE STATUS FROM ".DB_NAME." LIKE '".$wpdb->prefix."IPBLC_login_failed'");

//echo "<pre>";
//		print_r($cc);
			
		$failed_engine_ok=1;
		$failed_collation_ok=1;

		foreach($cc as $k)
		{
			$engine=$k->Engine;
			$collation=$k->Collation;
			if($engine!="MyISAM")
			{
				$failed_engine_ok=0;
				
			}
			if($collation!="utf8_general_ci")
			{
				$failed_collation_ok=0;
				
			}

		}

//echo "</pre>";




//-----check tables type end---


		$all_ok=1;
?>



<BR>

<h2>Fix Database</h2>

<h3>IP Blacklist Table</h3>
<?php

	if($blc_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --All fields found!</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> --All fields not found!</span><BR>";
		$all_ok=0;
	}

	if($blc_type_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --All fields types are OK!</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> --All fields types are NOT OK!</span><BR>";
		$all_ok=0;
	}

	if($blc_engine_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --Engine type is 'MyISAM' !</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> --Engine type is NOT 'MyISAM' !</span><BR>";
		$all_ok=0;
	}

	if($blc_collation_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --Collation is 'utf8_general_ci' !</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> ----Collation is NOT 'utf8_general_ci' !</span><BR>";
		$all_ok=0;
	}

?>

<h3>Username Blacklist Table</h3>
<?php

	if($user_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --All fields found!</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> --All fields not found!</span><BR>";

	}


	if($user_type_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --All fields types are OK!</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> --All fields types are NOT OK!</span><BR>";
		$all_ok=0;
	}


	if($user_engine_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --Engine type is 'MyISAM' !</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> --Engine type is NOT 'MyISAM' !</span><BR>";
		$all_ok=0;
	}

	if($user_collation_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --Collation is 'utf8_general_ci' !</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> ----Collation is NOT 'utf8_general_ci' !</span><BR>";
		$all_ok=0;
	}

?>

<h3>Failed Login Blacklist Table</h3>
<?php

	if($failed_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --All fields found!</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> --All fields not found!</span><BR>";
		$all_ok=0;
	}


	if($failed_type_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --All fields types are OK!</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> --All fields types are NOT OK!</span><BR>";
		$all_ok=0;
	}


	if($failed_engine_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --Engine type is 'MyISAM' !</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> --Engine type is NOT 'MyISAM' !</span><BR>";
		$all_ok=0;
	}

	if($failed_collation_ok==1)
	{
		echo "<span style=\"color: #009900;\"> --Collation is 'utf8_general_ci' !</span><BR>";
	}
	else
	{
		echo "<span style=\"color: #FF0000;\"> ----Collation is NOT 'utf8_general_ci' !</span><BR>";
		$all_ok=0;
	}


	if($all_ok==0)
	{
?>
<BR><BR>
	<form method="POST">					
	<input type="submit" name="fix_all" id="fix_all" value="Apply Fix!" class="button-primary"> to all tables!
	</form>
<BR>
<?php

	}
?>

<h3>Indexing</h3>

<BR>
<?php





			$foundIndex=0;

			$results=$wpdb->get_results( "SHOW INDEX FROM ".$wpdb->prefix."IPBLC_blacklist");


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
<BR>
<?php


			$foundIndex=0;

			$results=$wpdb->get_results( "SHOW INDEX FROM ".$wpdb->prefix."IPBLC_blacklist");


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

