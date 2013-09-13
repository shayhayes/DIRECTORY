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
	# * FILE: /sitemgr/article/settings.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# VALIDATE FEATURE
	# ----------------------------------------------------------------------------------------------------
	if (ARTICLE_FEATURE != "on") { exit; }

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSMSession();
	permission_hasSMPerm();

	$url_redirect = "".DEFAULT_URL."/".SITEMGR_ALIAS."/".ARTICLE_FEATURE_FOLDER;
	$url_base = "".DEFAULT_URL."/".SITEMGR_ALIAS."";
	$sitemgr = 1;

	$url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_POST);
	extract($_GET);

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	if ($id) {
		$articleObj = new Article($id);
	} else {
		header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/".ARTICLE_FEATURE_FOLDER."/".(($search_page) ? "search.php" : "index.php")."?message=".$message."&screen=$screen&letter=$letter".(($url_search_params) ? "&$url_search_params" : "")."");
		exit;
	}

	# ----------------------------------------------------------------------------------------------------
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		if ($_POST["amount"]) $_POST["amount"] = format_money($_POST["amount"]);
		else $_POST["amount"] = false;

		if ($hasrenewaldate == "no") {
			unset($_POST['renewal_date']);
		}

		if (validate_form("articlesettings", $_POST, $message_articlesettings)) {

            if ($_POST['status'] == "S") {
                $articleObj->setString("suspended_sitemgr", "y");
            } else {
                $articleObj->setString("suspended_sitemgr", "n");
            }
			$articleObj->setString("status", $_POST['status']);
			$articleObj->setDate("renewal_date", $_POST['renewal_date']);

			if (!$articleObj->hasRenewalDate()) {
				$articleObj->setString("renewal_date", "0000-00-00");
			}

			$articleObj->Save();

			if($_POST["add_transaction"] == 1){

				$accountObj = new Account($_POST["account_id"]);
				$contactObj = new Contact($_POST["account_id"]);

				$log["account_id"]				= $_POST["account_id"];
				$log["username"]				= $accountObj->getString("username");;
				$log["ip"]						= $_SERVER["REMOTE_ADDR"];
				$log["transaction_id"]			= "MAN_".string_strtoupper(uniqid(""));
				$log["transaction_status"]		= MANUAL_STATUS;
				$log["transaction_datetime"]	= date("Y-m-d H:i:s");
				$log["transaction_amount"]		= str_replace(",", "", $_POST["amount"]);
				$log["transaction_currency"]	= MANUAL_CURRENCY;
				$log["system_type"]				= "manual";
				$log["notes"]					= $_POST["notes"];

				$paymentLogObj = new PaymentLog($log);
				$paymentLogObj->Save(SELECTED_DOMAIN_ID);
                
                $levelObj = new ArticleLevel();

				$payment_article_log["payment_log_id"]	= $paymentLogObj->getString("id");
				$payment_article_log["article_id"]		= $articleObj->getString("id");
				$payment_article_log["article_title"]	= $articleObj->getString("title",false);
				$payment_article_log["discount_id"]		= $articleObj->getString("discount_id");
				$payment_article_log["level"]			= $articleObj->getString("level");							
				$payment_article_log["level_label"]		= $levelObj->getName($articleObj->getString("level"));
				$payment_article_log["renewal_date"]	= $articleObj->getString("renewal_date");
				$payment_article_log["amount"]			= str_replace(",", "", $_POST["amount"]);

				$paymentArticleLogObj = new PaymentArticleLog($payment_article_log);
				$paymentArticleLogObj->Save();

			}

			# ------------------------------------------------------------------------------
			# SENDING EMAIL OF ACTIVATION ARTICLE TO MEMBER
			# ------------------------------------------------------------------------------
			if ($_POST['email_notification'] == 1 && $_POST['status'] == "A") {
				if ($articleObj->getNumber("account_id") > 0) {
					$contactObj = new Contact($articleObj->getNumber("account_id"));
					if ($emailNotificationObj = system_checkEmail(SYSTEM_ACTIVE_ARTICLE)) {
						setting_get("sitemgr_send_email", $sitemgr_send_email);
						setting_get("sitemgr_email", $sitemgr_email);
						$sitemgr_emails = explode(",", $sitemgr_email);
						if ($sitemgr_emails[0]) $sitemgr_email = $sitemgr_emails[0];
						$domain = new Domain(SELECTED_DOMAIN_ID);
						$subject = $emailNotificationObj->getString("subject");
						$body 	 = $emailNotificationObj->getString("body");
						$body 	 = system_replaceEmailVariables($body, $articleObj->getNumber('id'), 'article');
						$body	 = str_replace($_SERVER["HTTP_HOST"], $domain->getstring("url"), $body);
						$subject = system_replaceEmailVariables($subject, $articleObj->getNumber('id'), 'article');
						$body = html_entity_decode($body);
						$subject = html_entity_decode($subject);
						system_mail($contactObj->getString("email"), $subject, $body, EDIRECTORY_TITLE." <$sitemgr_email>", $emailNotificationObj->getString("content_type"), "", $emailNotificationObj->getString("bcc"), $error);
					}
				}
			}

			$message = 1;
			header("Location: ".DEFAULT_URL."/".SITEMGR_ALIAS."/".ARTICLE_FEATURE_FOLDER."/".(($search_page) ? "search.php" : "index.php")."?message=".$message."&screen=$screen&letter=$letter".(($url_search_params) ? "&$url_search_params" : "")."");
			exit;

		}

	}

	# ----------------------------------------------------------------------------------------------------
	# FORMS DEFINES
	# ----------------------------------------------------------------------------------------------------
	$renewal_date = $articleObj->getDate("renewal_date");

	// Status Drop Down
	$statusObj = new ItemStatus();
	unset($arrayValue);
	unset($arrayName);
	$arrayValue = $statusObj->getValues();
	$arrayName = $statusObj->getNames();
	unset($arrayValueDD);
	unset($arrayNameDD);
	for ($i=0; $i<count($arrayValue); $i++) {
		if ($arrayValue[$i] != "E") {
			$arrayValueDD[] = string_ucwords($arrayValue[$i]);
			$arrayNameDD[] = string_ucwords($arrayName[$i]);
		}
	}
	$statusDropDown = html_selectBox("status", $arrayNameDD, $arrayValueDD, $articleObj->getString("status"), "", "class='input-dd-form-settings'", "-- ".system_showText(LANG_LABEL_SELECT_ALLSTATUS)." --");

	if(!$_POST["account_id"]) $account_id = $articleObj->getString("account_id");

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
        <div id="header-content"><h1><?=string_ucwords(system_showText(LANG_SITEMGR_ARTICLE))?> <?=system_showText(LANG_SITEMGR_STATUS)?></h1></div>
    </div>

    <div id="content-content">

        <div class="default-margin">

            <? require(EDIRECTORY_ROOT."/".SITEMGR_ALIAS."/registration.php"); ?>
            <? require(EDIRECTORY_ROOT."/includes/code/checkregistration.php"); ?>
            <? require(EDIRECTORY_ROOT."/frontend/checkregbin.php"); ?>

            <? include(INCLUDES_DIR."/tables/table_article_submenu.php"); ?>
            <?if (CUSTOM_ARTICLE_FEATURE != "on"){ ?>
                <p class="informationMessage">
                    <?=system_showText(LANG_SITEMGR_MODULE_UNAVAILABLE)?>
                </p>
            <? }else { ?>
            <br />

            <div class="baseForm">

            <form name="article_setting" action="<?=system_getFormAction($_SERVER["PHP_SELF"])?>" method="post">
                <input type="hidden" name="id" value="<?=$id?>" />

                <? include(INCLUDES_DIR."/forms/form_articlesettings.php"); ?>

                <?=system_getFormInputSearchParams((($_POST)?($_POST):($_GET)));?>
                <input type="hidden" name="letter" value="<?=$letter?>" />
                <input type="hidden" name="screen" value="<?=$screen?>" />
                <button type="submit" value="Submit" class="input-button-form"><?=system_showText(LANG_SITEMGR_SUBMIT)?></button>
                <button type="button" name="back" value="Back" class="input-button-form" onclick="document.getElementById('formarticlesettingscancel').submit();"><?=system_showText(LANG_SITEMGR_BACK)?></button>

            </form>
            <form id="formarticlesettingscancel" action="<?=DEFAULT_URL?>/<?=SITEMGR_ALIAS?>/<?=ARTICLE_FEATURE_FOLDER;?>/<?=(($search_page) ? "search.php" : "index.php");?>" method="post">

                <?=system_getFormInputSearchParams((($_POST)?($_POST):($_GET)));?>
                <input type="hidden" name="letter" value="<?=$letter?>" />
                <input type="hidden" name="screen" value="<?=$screen?>" />

            </form>

            </div>
            <? } ?>

        </div>

    </div>

    <div id="bottom-content">&nbsp;</div>

</div>

<? if ($articleObj->hasRenewalDate()) { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            //DATE PICKER
            <?
            if ( DEFAULT_DATE_FORMAT == "m/d/Y" ) $date_format = "mm/dd/yy";
            elseif ( DEFAULT_DATE_FORMAT == "d/m/Y" ) $date_format = "dd/mm/yy";
            ?>

            $('#renewal_date').datepicker({
                dateFormat: '<?=$date_format?>',
                changeMonth: true,
                changeYear: true,
                yearRange: '<?=date("Y")?>:<?=date("Y")+10?>'
            });

        });
    </script>
<? } ?>

<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>