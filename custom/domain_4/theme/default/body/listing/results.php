<?
	$includeUrl = EDIRECTORY_ROOT."/custom/domain_".SELECTED_DOMAIN_ID."/theme/default/body/extra/";
	
	$editCoreUrl = $includeUrl.EDIR_CORE_FOLDER_NAME."/".LISTING_FEATURE_FOLDER;
	
	$frontEndUrl = $includeUrl."frontend/";
	
	//include($editCoreUrl."/searchresults.php");
	include(LISTING_EDIRECTORY_ROOT."/searchresults.php");
?>
<div class="contentLeft"></div>
<div class="document">
	<div class="upper-section">
		<? include(system_getFrontendPath("results_search_info.php")); ?>
	</div>
	<div class="side-bar">
        <? include(system_getFrontendPath("results_left_section.php"));?>
        <!--<div style="border-bottom:3px solid #fff"></div>-->
        <? include(system_getFrontendPath("results_maps.php")); ?>
         
        <? //include(system_getFrontendPath("relatedcategories.php", "frontend", false, LISTING_EDIRECTORY_ROOT)); ?>
        <? include($frontEndUrl."featured_listing_review.php"); ?>
        
        <? include($frontEndUrl."banner_featured.php"); ?>
		<? include(system_getFrontendPath("banner_sponsoredlinks.php")); ?>
        <? include(system_getFrontendPath("googleads.php")); ?>
	</div>
	<div class="content">
		<? //include(system_getFrontendPath("breadcrumb.php")); ?>
		<div class="content-top">
			<? include(system_getFrontendPath("sitecontent_top.php")); ?>
			<? include($frontEndUrl."results_info.php"); ?>
		</div>
		<? include(system_getFrontendPath("category_banner.php")); ?>
                <? include(system_getFrontendPath("results_info.php")); ?>
		<div class="content-main">
			<? include(LISTING_EDIRECTORY_ROOT."/results_listings.php"); ?>
		</div>
		<? include($frontEndUrl."results_pagination.php");?>
		<? include($frontEndUrl."results_filter.php"); ?>
		<? include(system_getFrontendPath("sitecontent_bottom.php")); ?>
		<? include(system_getFrontendPath("banner_bottom.php")); ?>
	</div>
</div>
<div class="contentRight"></div>