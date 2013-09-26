<?

	/*==================================================================*\
	######################################################################
	#                                                                    #
	# Copyright 2005 Arca Solutions, Inc. All Rights Reserved.           #
	#                                                                    #
	# This file may not be redistributed in whole or part.               #
	# eDirectory is licensed on a per-domain basis.                      #
	#                                                                    #
	# ---------------- eDirectory IS NOT FREE SOFTWARE ----------------- #
	#                                                                    #
	# http://www.edirectory.com | http://www.edirectory.com/license.html #
	######################################################################
	\*==================================================================*/

	# ----------------------------------------------------------------------------------------------------
	# * FILE: /controller/deal/rewrite.php
	# ----------------------------------------------------------------------------------------------------
	
    $failure = false;
	$dbObj = db_getDBObject();

    $browsebylocation = false;
	$browsebycategory = false;
	$browsebyitem = false;
    
	if ($_GET["url_full"] && !$fromRSS) {
		$_GET["url_full"] = $_SERVER["REQUEST_URI"];
	}

	if ($_GET["url_full"] && (string_strpos($_GET["url_full"], 'results.php') !== false || string_strpos($_GET["url_full"], ALIAS_REVIEW_URL_DIVISOR) !== false)) {

		$url = string_replace_once(EDIRECTORY_FOLDER."/".ALIAS_PROMOTION_MODULE."/", "", $_GET["url_full"]);
		$parts = explode("/", $url);

		if (string_strpos($_GET["url_full"], ALIAS_CATEGORY_URL_DIVISOR) !== false && $parts[1] != ALIAS_CATEGORY_URL_DIVISOR){
			$browsebycategory = true;
			$auxFullFriendlyUrl = "";

			for ($i=1; $i<count($parts); $i++){
				$_GET["category".$i] = $parts[$i];
			}
		} else if (string_strpos($_GET["url_full"],ALIAS_LOCATION_URL_DIVISOR) !== false && $parts[1]!=ALIAS_LOCATION_URL_DIVISOR){
			$browsebylocation = true;

			for ($i=1; $i<count($parts); $i++){
				$_GET["friendLoc".$i] = $parts[$i];
			}
		}else if (string_strpos($_GET["url_full"],ALIAS_REVIEW_URL_DIVISOR) !== false && $parts[1]!=ALIAS_REVIEW_URL_DIVISOR) {
			$browsebyitem = true;
			$_GET["promotion"] = $parts[1];

			for ($i=1; $i<count($parts); $i++){
				$_GET["category".$i] = $parts[$i];
			}
		} else {
			if (!$parts[1] && !$parts[3]) {
				header("Location: ".PROMOTION_DEFAULT_URL."/results.php");
				exit;
			}

			if ($parts[1] != "empty"){
				$_GET["keyword"] = $parts[1];
				$_GET["keyword"] = str_replace("|2F","/", $_GET["keyword"]);
				$_GET["keyword"] = str_replace("|3F","\\", $_GET["keyword"]);
			} else {
				$_GET["keyword"] = "";
			}

			if ($parts[3] != "empty"){
				$_GET["where"] = $parts[3];
				$_GET["where"] = str_replace("|2F","/", $_GET["where"]);
				$_GET["where"] = str_replace("|3F","\\", $_GET["where"]);
			} else {
				$_GET["where"] = "";
			}

			for ($i==2; $i<count($parts); $i++){
				switch($parts[$i]) {
					case 'page': $_GET["page"] = $parts[$i+1];
									break;
					case 'letter': $_GET["letter"] = $parts[$i+1];
									break;
					case 'orderby': $_GET["orderby"] = $parts[$i+1];
									break;
				}
			}
		}
	}else if($_GET["url_full"] && string_strpos($_GET["url_full"],'results.php')== FALSE)
        {
            $friendlyurl = true;
            $url = string_replace_once(EDIRECTORY_FOLDER."/".ALIAS_PROMOTION_MODULE."/", "", $_GET["url_full"]);
            $parts = explode("/", $url);
            $tempParts = array();

            for($i = 0; $i < count($parts); $i++)
            {
                if($parts[$i] != 'page' && $parts[$i] != 'letter' && $parts[$i] != 'orderby' && $parts[$i] != ''){
                    $tempParts[] = $parts[$i];
                }else{
                    $i = $i+1;
                }
            }
            $countTempParts = count($tempParts);
            if($tempParts){
                if($countTempParts == 1){
                    $sql = "SELECT id FROM ListingCategory WHERE friendly_url = '" . $tempParts[0] . "' AND enabled = 'y' LIMIT 1";
                    $result = $dbObj->query($sql);
                    if (mysql_num_rows($result) > 0) {
                        $aux = mysql_fetch_assoc($result);
                        $_GET["category_id"] = $aux["id"];
                    }else{
                        $failure = true;
                    }
                }elseif($countTempParts == 2){
                    $sql = "SELECT id FROM ListingCategory WHERE friendly_url = '" . $tempParts[0] . "' AND enabled = 'y' LIMIT 1";
                    $result = $dbObj->query($sql);
                    if (mysql_num_rows($result) > 0) {
                        $aux = mysql_fetch_assoc($result);
                        $_GET["category_id"] = $aux["id"];

                        $sqlLocation = "SELECT id FROM Location_3 WHERE friendly_url LIKE '".$tempParts[1]."'";
                        $dbObj_main = db_getDBObject(DEFAULT_DB, true);
                        $result = $dbObj_main->query($sqlLocation);
                        if (mysql_num_rows($result) > 0) {
                            $row = mysql_fetch_assoc($result);
                            $_GET["location_3"] = $row["id"];
                        }else{
                            unset($_GET["category_id"]);
                            $sql = "SELECT id FROM ListingCategory WHERE friendly_url = '" . $tempParts[1] . "' AND enabled = 'y' LIMIT 1";
                            $result = $dbObj->query($sql);
                            if (mysql_num_rows($result) > 0) {
                                $aux = mysql_fetch_assoc($result);
                                $_GET["category_id"] = $aux["id"];
                            }else{
                                $failure = true;
                            }
                        }
                    }else{
                        $failure = true;
                    }
                }elseif($countTempParts == 3){  
                    $sql = "SELECT id FROM ListingCategory WHERE friendly_url = '" . $tempParts[0] . "' AND enabled = 'y' LIMIT 1";
                    $result = $dbObj->query($sql);
                    if(mysql_num_rows($result) > 0){
                        if (mysql_num_rows($result) > 0) {
                            $aux = mysql_fetch_assoc($result);
                            $_GET["category_id"] = $aux["id"];
                            $sql = "SELECT id FROM ListingCategory WHERE friendly_url = '" . $tempParts[1] . "' AND enabled = 'y' LIMIT 1";
                            $result = $dbObj->query($sql);
                            if (mysql_num_rows($result) > 0) {
                                $aux = mysql_fetch_assoc($result);
                                $_GET["category_id"] = $aux["id"];
                                $sqlLocation = "SELECT id FROM Location_3 WHERE friendly_url LIKE '".$tempParts[2]."'";
                                $dbObj_main = db_getDBObject(DEFAULT_DB, true);
                                $result = $dbObj_main->query($sqlLocation);
                                if (mysql_num_rows($result) > 0) {
                                    $row = mysql_fetch_assoc($result);
                                    $_GET["location_3"] = $row["id"];
                                }else{
                                    $failure = true;
                                }
                            }else{
                                $failure = true;
                            }
                        }
                    }else{
                        $failure = true;
                    }
                }else{
                    $failure = true;
                }


                for ($i = $countTempParts; $i < count($parts); $i++) {
                    switch ($parts[$i]) {
                        case 'page': $_GET["page"] = $parts[$i + 1];
                            break;
                        case 'letter': $_GET["letter"] = $parts[$i + 1];
                            break;
                        case 'orderby': $_GET["orderby"] = $parts[$i + 1];
                            break;
                    }
                }
            }
        }
    
	if ($browsebycategory || $browsebyitem){
		for ($i=1; $i < count($parts); $i++){
			$aux = $_GET["category".$i];
			if ($aux == "page"){
				$_GET["category".$i] = "";
				$_GET["page"] = $_GET["category".($i+1)];
				$_GET["category".($i+1)] = "";
				$i++;
			} else if ($aux == "letter"){
				$_GET["category".$i] = "";
				$_GET["letter"] = $_GET["category".($i+1)];
				$_GET["category".($i+1)] = "";
				$i++;
			} else if ($aux == "orderby"){
				$_GET["category".$i] = "";
				$_GET["orderby"] = $_GET["category".($i+1)];
				$_GET["category".($i+1)] = "";
				$i++;
			} else {
				if ($aux)
					$auxFullFriendlyUrl .= $aux."/";
			}
		}
	} else if ($browsebylocation){
		for ($i=1; $i < count($parts); $i++){
			$aux = $_GET["friendLoc".$i];
			if ($aux == "page"){
				$_GET["friendLoc".$i] = "";
				$_GET["page"] = $_GET["friendLoc".($i+1)];
				$_GET["friendLoc".($i+1)] = "";
				$i++;
			} else if ($aux == "letter"){
				$_GET["friendLoc".$i] = "";
				$_GET["letter"] = $_GET["friendLoc".($i+1)];
				$_GET["friendLoc".($i+1)] = "";
				$i++;
			} else if ($aux == "orderby"){
				$_GET["friendLoc".$i] = "";
				$_GET["orderby"] = $_GET["friendLoc".($i+1)];
				$_GET["friendLoc".($i+1)] = "";
				$i++;
			}
		}

	}

    ##################################################
	# friendlyurl
	##################################################
	if ($_GET["friendly_url"] ) {
		$promotionObj= new Promotion();
		$id=$_GET['id']=$promotionObj->findByFriendlyURL(trim($_GET["friendly_url"]));
		if (!$id){
			header('Location: '.PROMOTION_DEFAULT_URL.'/');
			exit;
		}

		$modRewrited=true;
	}

	##################################################
	# LOCATION
	##################################################
	if ($_GET["friendLoc1"]) { 
		unset($sqlLoc);

		$edir_loc = explode(",", EDIR_LOCATIONS);

		// Writing SQL Select Command Into Array
		foreach($edir_loc as $k=>$loc) {
			if ($_GET["friendLoc".($k+1)]) {
				$browsebylocation = true;

				// Writing Location Fields
				$sqlLoc["fields"][] = "L$loc.id l_$loc";

				if (($k + 1) == 1) {
					// Writing FROM Clause
					$sqlLoc["from"] = "Location_$loc L$loc";
				} else {
					// Writing INNER JOIN Clause
					$loc_id = $edir_loc[$k - 1];
					$sqlLoc["join"][] = "Location_$loc L$loc ON (L$loc.location_$loc_id = L$loc_id.id)";
				}

				// Writing WHERE Clause
				$friendlyUrlLoc = $_GET["friendLoc".($k+1)];
				$sqlLoc["where"][] = "L$loc.friendly_url = '$friendlyUrlLoc'";
			}
		}

		// Writing SQL Command in Text Format
		$sql_fields = implode(", ", $sqlLoc["fields"]);
		$sql_from = $sqlLoc["from"];
		if ($sqlLoc["join"]) {
			$sql_join = implode(" INNER JOIN ", $sqlLoc["join"]);
		}
		$sql_where = implode(" AND ", $sqlLoc["where"]);
		$sql = "SELECT $sql_fields
				FROM $sql_from";
		if ($sql_join) {
			$sql .= " INNER JOIN $sql_join";
		}
		$sql.= " WHERE $sql_where";

		/*
		 * Force connection with main DB
		 */
		$dbObj_main = db_getDBObject(DEFAULT_DB,true);
		$result = $dbObj_main->query($sql);
                
		if (mysql_num_rows($result) > 0) {
			$row = mysql_fetch_assoc($result);
			foreach($edir_loc as $k=>$loc) {
				if ($_GET["friendLoc".($k + 1)]) {
					$_GET["location_".$loc] = $row["l_$loc"];
					if (!$_GET["location_".$loc]) $failure = true;
					else $mod_rewrite_have_location = true;
				}
			}
		} 

	} else {
		$mod_rewrite_have_location = false;
		for ($i = 1; $i <= 5; $i++) {
			if ($_GET["location_".$i]) {
				$mod_rewrite_have_location = true;
				break;
			}
		}
	}
	##################################################


	##################################################
	# PROMOTION
	##################################################
	if ($_GET["promotion"]) {
		$browsebyitem = true;
		/*
		 * Force Connection with main DB
		 */
		$db = db_getDBObject();
		$sql = "SELECT Promotion.id as id FROM Promotion WHERE Promotion.friendly_url = ".db_formatString($_GET["promotion"])." LIMIT 1";
		$result = $db->query($sql);
		$aux = mysql_fetch_assoc($result);
		$_GET["id"] = $aux["id"];
		$_GET["item_id"] = $aux["id"];
		if (!$_GET["id"]) $failure = true;
	}

	##################################################
	# CATEGORY
	##################################################

	/*
	 * Get all path of category
	 */
	if ($auxFullFriendlyUrl && string_strpos($_GET["url_full"], ALIAS_CATEGORY_URL_DIVISOR)) {

		if (string_substr($auxFullFriendlyUrl, -1) == "/") {
			$auxFullFriendlyUrl = string_substr($auxFullFriendlyUrl, 0, -1);
        }

		$aux_url_full = $auxFullFriendlyUrl;

		$sql = "SELECT id FROM ListingCategory WHERE full_friendly_url = '".$aux_url_full."' AND enabled = 'y' LIMIT 1";
		$result = $dbObj->query($sql);
		if(mysql_num_rows($result) > 0){
			$browsebycategory = true;
			$aux = mysql_fetch_assoc($result);
			$_GET["category_id"] = $aux["id"];
		}
		if (!$_GET["category_id"]) {
			$failure = true;
		}
	}

	##################################################

	##################################################
	# UNSETTING MODREWRITE TERMS
	##################################################
	if ($failure) {
		header("Location: ".PROMOTION_DEFAULT_URL."/");
		exit;
	} else {
		unset($failure);
		unset($dbObj);
		unset($sql);
		unset($result);
		unset($aux);
		unset($_GET["friendLoc1"]);
		unset($_GET["friendLoc2"]);
		unset($_GET["friendLoc3"]);
		unset($_GET["friendLoc4"]);
		unset($_GET["friendLoc5"]);
		unset($_GET["category1"]);
		unset($_GET["category2"]);
		unset($_GET["category3"]);
		unset($_GET["category4"]);
		unset($_GET["category5"]);
		
		/*
		 * Removing wrong spaces on url
		 */
		if (string_strpos($_GET["keyword"],",")) {
			unset($aux_keywords,$array_keywords);
			$aux_keywords = explode(",",$_GET["keyword"]);
			for ($i=0;$i<count($aux_keywords);$i++) {
				$array_keywords[] = trim($aux_keywords[$i]);
			}
			$_GET["keyword"] = implode("",$array_keywords);
			
		}
		
		if (string_strpos($_GET["where"],",")) {
			unset($aux_where,$array_where);
			$aux_where = explode(",",$_GET["where"]);
			for ($i=0;$i<count($aux_where);$i++) {
				$array_where[] = trim($aux_where[$i]);
			}
			$_GET["where"] = implode(", ",$array_where);
		}
	}
	##################################################
?>