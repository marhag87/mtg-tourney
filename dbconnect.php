<?PHP
			//---------------------------------------------------------------------------------------------------------------
			// err - Displays nicely formatted error and exits
			//---------------------------------------------------------------------------------------------------------------
			
			function err ($errmsg,$hdr='') {
					if (!empty($hdr)) {
								echo($hdr);
					}
					print "<p><span class=\"err\">Serious Error: <br><i>$errmsg</i>.<p>";
					print "</span><p>\n";
					exit;
			}
			
			//---------------------------------------------------------------------------------------------------------------
			// dbConnect - Makes database connection
			//---------------------------------------------------------------------------------------------------------------
			
			function dbConnect() {
				
				$printHeaderFunction=0;
				
				// send header info to err()?
				if ($printHeaderFunction) {
					$hdr = 'Database Connect Error';
				} else {
					$hdr = '';
				}

				// Connect to DB server
				$OC_db = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or err("could not connect to database ".mysql_errno(),$hdr);
			
				// Select DB
				mysql_select_db(DB_NAME) or err("could not select database \"".DB_NAME."\" error code".mysql_errno(),$hdr);
				
			}

			define("DB_USER","mtgtourney");
			define("DB_PASSWORD","mtg");
			define("DB_HOST","localhost");
			define("DB_NAME","mtgtourney");
			
?>
