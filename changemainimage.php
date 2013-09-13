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
	# * FILE: /changemainimage.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("./conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------

	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");

	$domain_id = $_GET["domain_id"];
	$image_id = $_GET["image_id"];
	$thumb_id = $_GET["thumb_id"];
	$item_id = $_GET["item_id"];
	$temp = $_GET["temp"];
	$gallery_id = $_GET["gallery_id"];
	$item_type = ucfirst($_GET["item_type"]);
	$level = $_GET["level"];
	$sess_id = $_GET["gallery_hash"];

	$dbMain = db_getDBObject(DEFAULT_DB, true);
	$dbObj = db_getDBObjectByDomainID($domain_id, $dbMain);
	$sql = "SELECT COUNT(*) FROM Gallery_Temp WHERE image_default = 'n' AND sess_id = '".$sess_id."'";
	$r = $dbObj->query($sql);

	if ($item_type=='Listing') {
		$listingLevelGallery = new ListingLevel();
		$maxImages = $listingLevelGallery->getImages($level);
	}elseif ($item_type=='Article') {
		$articleLevelGallery = new ArticleLevel();
		$maxImages = $articleLevelGallery->getImages($level);
	}elseif ($item_type=='Classified') {
		$classifiedLevelGallery = new ClassifiedLevel();
		$maxImages = $classifiedLevelGallery->getImages($level);
	}elseif ($item_type=='Event') {
		$eventLevelGallery = new EventLevel();
		$maxImages = $eventLevelGallery->getImages($level);
	}

	while ($row_aux = mysql_fetch_array($r)) {
		$cont_temp = $row_aux[0];
	} 
	if ($gallery_id){
		$gallery = new Gallery($gallery_id, $domain_id);
		$cont_gal = count($gallery->image);
	}

	if (($cont_temp+$cont_gal)>=$maxImages){
		echo "error";
	}else{
		if ($temp=='y'){
			$sql = "Update Gallery_Temp SET image_default = 'n' WHERE image_id = $image_id";
			$dbObj->query($sql);
		}else{
			$sql = "SELECT	image_caption,
							thumb_caption
					FROM Gallery_Image WHERE image_id = $image_id";
			$r = $dbObj->query($sql);
			$aux = mysql_fetch_array($r);

			$sql = "DELETE FROM Gallery_Image WHERE image_id = $image_id";
			$dbObj->query($sql);
			unset($gallery);
			$gallery = new Gallery($gallery_id, $domain_id);

			$row["image_id"] = $image_id;
			$row['image_caption'] = $aux["image_caption"];
			$row['thumb_id'] = $thumb_id;
			$row['thumb_caption'] = $aux["thumb_caption"];
			$row['image_default'] = 'n';
			$gallery->AddImage($row, $domain_id);
			$gallery->save();

			$sql = "UPDATE $item_type SET image_id = '', thumb_id = '' WHERE id = $item_id";
			$dbObj->query($sql);
		}
	}
?>