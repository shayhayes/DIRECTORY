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
	# * FILE: /theme/default/body/listing/index.php
	# ----------------------------------------------------------------------------------------------------
        
?>

	<div class="contentLeft"></div>
	<div class="document">
	<div class="content">
		<? include(system_getFrontendPath("breadcrumb.php")); ?>
		<? include(THEMEFILE_DIR."/".EDIR_THEME."/layout/navbuttons.php");?>
		<div class="content-top">
			<? include(system_getFrontendPath("sitecontent_top.php")); ?>
			<? include(system_getFrontendPath("featured.php", "frontend", false, LISTING_EDIRECTORY_ROOT)); ?>
		</div>
		<div class="content-main">
			<? include(system_getFrontendPath("browsebycategory.php", "frontend", false, LISTING_EDIRECTORY_ROOT));  ?>
			<? include(system_getFrontendPath("featured_listing_review.php")); ?>
		</div>
		<? include(system_getFrontendPath("sitecontent_bottom.php")); ?>
		<? include(system_getFrontendPath("banner_bottom.php")); ?>
	</div>

	<div class="sidebar">
		<? include(system_getFrontendPath("join.php", "frontend", false, LISTING_EDIRECTORY_ROOT)); ?>
		<? //setting_get("domain".SELECTED_DOMAIN_ID."_filter", $is_filter_on);
		//if($is_filter_on=="on")
		//{ 
			include(system_getFrontendPath("result_filters.php"));
		//}?>
		<? include(system_getFrontendPath("browsebylocation.php", "frontend", false, LISTING_EDIRECTORY_ROOT)); ?>
		<? include(system_getFrontendPath("banner_featured.php")); ?>
		<? include(system_getFrontendPath("banner_sponsoredlinks.php")); ?>
		<? include(system_getFrontendPath("googleads.php")); ?>
	</div>
</div>
<div class="contentRight"></div>