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
	# * FILE: /controller/listing/rewrite.php
	# ----------------------------------------------------------------------------------------------------
        
        
    $failure = false;
    $dbObj = db_getDBObject();

    $browsebylocation   = false;
    $browsebycategory   = false;
    $browsebyitem       = false;
   
    /**
    * Preparing URL 
    */
    
  
    if ($_GET["url_full"] && !$fromRSS) { 
        $_GET["url_full"] = $_SERVER["REQUEST_URI"];
    }
    
    if ($_GET["url_full"] && (string_strpos($_GET["url_full"], ALIAS_CATEGORY_URL_DIVISOR.'/') !== false || string_strpos($_GET["url_full"], ALIAS_LOCATION_URL_DIVISOR) !== false || string_strpos($_GET["url_full"], ALIAS_REVIEW_URL_DIVISOR) !== false || string_strpos($_GET["url_full"], ALIAS_CHECKIN_URL_DIVISOR) !== false)) {
        $url = string_replace_once(EDIRECTORY_FOLDER."/".ALIAS_LISTING_MODULE."/", "", $_GET["url_full"]);
        $parts = explode("/", $url);
        if (string_strpos($_GET["url_full"], ALIAS_CATEGORY_URL_DIVISOR) !== false) {
            
            $browsebycategory = true;
            $auxFullFriendlyUrl = "";
            for ($i = 1; $i < count($parts); $i++) {
                $_GET["category" . $i] = $parts[$i];
                
            }
        } else if (string_strpos($_GET["url_full"], ALIAS_LOCATION_URL_DIVISOR) !== false) {
            $browsebylocation = true;

            for ($i = 1; $i < count($parts); $i++) {
                $_GET["friendLoc" . $i] = $parts[$i];
            }
        } else if (string_strpos($_GET["url_full"], ALIAS_REVIEW_URL_DIVISOR) !== false) {
            $browsebyitem = true;

            $_GET["listing"] = $parts[1];
            
             for ($i = 1; $i < count($parts); $i++) {
                $_GET["category" . $i] = $parts[$i];
            }
        } else if (string_strpos($_GET["url_full"], ALIAS_CHECKIN_URL_DIVISOR) !== false) {
            $browsebyitem = true;

            $_GET["listing"] = $parts[1];

            for ($i = 1; $i < count($parts); $i++) {
                $_GET["category" . $i] = $parts[$i];
            }
        }else {

            if (!$parts[1] && !$parts[3]) {
                header("Location: " . LISTING_DEFAULT_URL . "/results.php");
                exit;
            }

            if ($parts[1] != "empty") {
                $_GET["keyword"] = $parts[1];
                $_GET["keyword"] = str_replace("|2F", "/", $_GET["keyword"]);
                $_GET["keyword"] = str_replace("|3F", "\\", $_GET["keyword"]);
            } else {
                $_GET["keyword"] = "";
            }

            if ($parts[3] != "empty") {
                $_GET["where"] = $parts[3];
                $_GET["where"] = str_replace("|2F", "/", $_GET["where"]);
                $_GET["where"] = str_replace("|3F", "\\", $_GET["where"]);
            } else {
                $_GET["where"] = "";
            }

            for ($i == 2; $i < count($parts); $i++) {
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
    }  else {
        $url = string_replace_once(EDIRECTORY_FOLDER."/".ALIAS_LISTING_MODULE."/", "", $_GET["url_full"]);
        $parts = explode("/", $url);
        if(count($parts)>=2){
            $searchbycategory = true;
            $searchbylocation = true;
            $auxFullFriendlyUrl = "";
            $_GET["category"] = $parts[0];
            $_GET["location"] = $parts[1];
            for ($i == 2; $i < count($parts); $i++) {
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
    
    if ($browsebycategory || $browsebyitem) {
       
        for ($i = 1; $i < count($parts); $i++) {
            $aux = $_GET["category" . $i];
            if ($aux == "page") {
                $_GET["category" . $i] = "";
                $_GET["page"] = $_GET["category" . ($i + 1)];
                $_GET["category" . ($i + 1)] = "";
                
                $i++;
            } else if ($aux == "letter") {
                $_GET["category" . $i] = "";
                $_GET["letter"] = $_GET["category" . ($i + 1)];
                $_GET["category" . ($i + 1)] = "";
                $i++;
            } else if ($aux == "orderby") {
                $_GET["category" . $i] = "";
                $_GET["orderby"] = $_GET["category" . ($i + 1)];
                $_GET["category" . ($i + 1)] = "";
                $i++;
            } else {
                if ($aux)
                    $auxFullFriendlyUrl .= $aux . "/";
            }
        }
        
    } else if ($browsebylocation) {
        for ($i = 1; $i < count($parts); $i++) {
            $aux = $_GET["friendLoc" . $i];
            if ($aux == "page") {
                $_GET["friendLoc" . $i] = "";
                $_GET["page"] = $_GET["friendLoc" . ($i + 1)];
                $_GET["friendLoc" . ($i + 1)] = "";
                $i++;
            } else if ($aux == "letter") {
                $_GET["friendLoc" . $i] = "";
                $_GET["letter"] = $_GET["friendLoc" . ($i + 1)];
                $_GET["friendLoc" . ($i + 1)] = "";
                $i++;
            } else if ($aux == "orderby") {
                $_GET["friendLoc" . $i] = "";
                $_GET["orderby"] = $_GET["friendLoc" . ($i + 1)];
                $_GET["friendLoc" . ($i + 1)] = "";
                $i++;
            }
        }
    }else if($searchbycategory && $searchbylocation){
      
        $sql = "SELECT id FROM ListingCategory WHERE full_friendly_url = '" . $_GET["category"] . "' AND enabled = 'y' LIMIT 1";
	$result = $dbObj->query($sql);
        if (mysql_num_rows($result) > 0) {
            $aux = mysql_fetch_assoc($result);
            $_GET["category_id"] = $aux["id"];
        }
        if (!$_GET["category_id"]) {
            $failure = true;
        }
        
        $sqlLocation = "SELECT id FROM location_3 WHERE friendly_url LIKE '".$_GET["location"]."'";
        $dbObj_main = db_getDBObject(DEFAULT_DB, true);
        $result = $dbObj_main->query($sqlLocation);

        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_assoc($result);
            $_GET["location_3"] = $row["id"];
        
        }
    }
    
    ##################################################
    ##################################################
    # LISTING
    ##################################################
    
    
	
    if ($_GET["listing"]) { 
        $browsebyitem = true;

        $db = db_getDBObject();
        $sql = "SELECT Listing.id as id FROM Listing WHERE Listing.friendly_url = " . db_formatString($_GET["listing"]) . " LIMIT 1";
        $result = $db->query($sql);
        $aux = mysql_fetch_assoc($result);
        $_GET["id"] = $aux["id"];
        $_GET["listing_id"] = $aux["id"];
        if (!$_GET["id"])
            $failure = true;
    }


    ##################################################
    # LOCATION
    ##################################################
    if ($_GET["friendLoc1"]) {
        unset($sqlLoc);

        $edir_loc = explode(",", EDIR_LOCATIONS);
		
        // Writing SQL Select Command Into Array
        foreach ($edir_loc as $k => $loc) {
            if ($_GET["friendLoc" . ($k + 1)]) {
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
                $friendlyUrlLoc = $_GET["friendLoc" . ($k + 1)];
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
        $dbObj_main = db_getDBObject(DEFAULT_DB, true);
        $result = $dbObj_main->query($sql);

        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_assoc($result);
            foreach ($edir_loc as $k => $loc) {
                if ($_GET["friendLoc" . ($k + 1)]) {
                    $_GET["location_" . $loc] = $row["l_$loc"];
                    if (!$_GET["location_" . $loc])
                        $failure = true;
                    else
                        $mod_rewrite_have_location = true;
                }
            }
        }
    } else { 
        $mod_rewrite_have_location = false;
        for ($i = 1; $i <= 5; $i++) {
            if ($_GET["location_" . $i]) {
                $mod_rewrite_have_location = true;
                break;
            }
        }
    }
    ##################################################
    ##################################################
    # CATEGORY
    ##################################################

    /*
    * Get all path of category
    */
    
    if ($auxFullFriendlyUrl && string_strpos($_GET["url_full"], ALIAS_CATEGORY_URL_DIVISOR)) {
         
        if (string_substr($auxFullFriendlyUrl, -1) == "/")
            $auxFullFriendlyUrl = string_substr($auxFullFriendlyUrl, 0, -1);
			
        $aux_url_full = $auxFullFriendlyUrl;
		$sql = "SELECT id FROM ListingCategory WHERE full_friendly_url = '" . $aux_url_full . "' AND enabled = 'y' LIMIT 1";
		

        $result = $dbObj->query($sql);
        if (mysql_num_rows($result) > 0) {
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
    # CLAIM
    ##################################################
    if ($_GET["claim"]) {
        $_GET["claim"] = str_replace("/", "", $_GET["claim"]);
        $db = db_getDBObject();
        $sql = "SELECT Listing.id as id FROM Listing WHERE Listing.friendly_url = " . db_formatString($_GET["claim"]) . " LIMIT 1";
        $result = $db->query($sql);
        $aux = mysql_fetch_assoc($result);
        $_GET["claimlistingid"] = $aux["id"];
        if (!$_GET["claimlistingid"])
            $failure = true;
    }



    ##################################################
    ##################################################
    # UNSETTING MODREWRITE TERMS
    ##################################################
    if ($failure) {
        header("Location: " . LISTING_DEFAULT_URL . "/");
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
        unset($_GET["template"]);
        unset($_GET["listing"]);

        /*
        * Removing wrong spaces on url
        */
        if (string_strpos($_GET["keyword"], ",")) {
            unset($aux_keywords, $array_keywords);
            $aux_keywords = explode(",", $_GET["keyword"]);
            for ($i = 0; $i < count($aux_keywords); $i++) {
                $array_keywords[] = trim($aux_keywords[$i]);
            }
            $_GET["keyword"] = implode("", $array_keywords);
        }

        if (string_strpos($_GET["where"], ",")) {
            unset($aux_where, $array_where);
            $aux_where = explode(",", $_GET["where"]);
            for ($i = 0; $i < count($aux_where); $i++) {
                $array_where[] = trim($aux_where[$i]);
            }
            $_GET["where"] = implode(", ", $array_where);
        }
    }
?>