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
	# * FILE: /sitemgr/custominvoices/index.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# VALIDATE FEATURE
	# ----------------------------------------------------------------------------------------------------
	if (PAYMENT_FEATURE != "on") { 
        header("Location:".DEFAULT_URL."/".SITEMGR_ALIAS.""); 
        exit; 
    }
	if ((CREDITCARDPAYMENT_FEATURE != "on") && (INVOICEPAYMENT_FEATURE != "on")) { 
        header("Location:".DEFAULT_URL."/".SITEMGR_ALIAS.""); 
        exit; 
    }
	if (CUSTOM_INVOICE_FEATURE != "on") { 
        header("Location:".DEFAULT_URL."/".SITEMGR_ALIAS.""); 
        exit; 
    }

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSMSession();
	permission_hasSMPerm();

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	extract($_GET);
	extract($_POST);

	//increases frequently actions
	if (!isset($message)) system_setFreqActions('custominvoice_manage', 'CUSTOM_INVOICE_FEATURE');
    
    $url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	$url_redirect = "".DEFAULT_URL."/".SITEMGR_ALIAS."/custominvoices";
	$url_base = "".DEFAULT_URL."/".SITEMGR_ALIAS."";
	$sitemgr = 1;

    # ----------------------------------------------------------------------------------------------------
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
    include(INCLUDES_DIR."/code/transaction_manage.php");

	// Page Browsing /////////////////////////////////////////

	$pageObj  = new pageBrowsing("CustomInvoice", $screen, RESULTS_PER_PAGE, "date DESC", "", "");
	$custominvoices = $pageObj->retrievePage();

	$paging_url = DEFAULT_URL."/".SITEMGR_ALIAS."/custominvoices/index.php";

	# PAGES DROP DOWN ----------------------------------------------------------------------------------------------
	$pagesDropDown = $pageObj->getPagesDropDown($_GET, $paging_url, $screen, system_showText(LANG_SITEMGR_PAGING_GOTOPAGE), "this.form.submit();");
	# --------------------------------------------------------------------------------------------------------------
	
	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/header.php");

	# ----------------------------------------------------------------------------------------------------
	# NAVBAR
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/navbar.php");

?>
    <div id="main-right">
        
        <div id="top-content">
            <div id="header-content">
                <h1><?=string_ucwords(system_showText(LANG_SITEMGR_CUSTOMINVOICE_PLURAL))?></h1>
            </div>
        </div>
        
        <div id="content-content">
            <div class="default-margin">

                <? require(EDIRECTORY_ROOT."/".SITEMGR_ALIAS."/registration.php"); ?>
                <? require(EDIRECTORY_ROOT."/includes/code/checkregistration.php"); ?>
                <? require(EDIRECTORY_ROOT."/frontend/checkregbin.php"); ?>

                <? include(INCLUDES_DIR."/tables/table_custominvoice_submenu.php"); ?>		

                <? 	if ($custominvoices) { ?>
                
                    <? include(INCLUDES_DIR."/tables/table_custominvoice.php"); ?>
                
                <? } else { ?>
                
                    <? include(INCLUDES_DIR."/tables/table_paging.php"); ?>

                    <p class="informationMessage">
                        <?=system_showText(LANG_SITEMGR_CUSTOMINVOICE_NORECORD)?>
                    </p>
                    
                <? } ?>
            </div>
        </div>
        
        <div id="bottom-content">&nbsp;</div>
        
    </div>
<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>