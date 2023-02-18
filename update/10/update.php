<?php
//Build 10 add inactive limit config and new langs

Updater::getLanguageService()->importPrefixFromZip(dirname(__FILE__).DS.'langs.zip', 'emaillists');

$config = OW::getConfig();

if(!$config->configExists('emaillists', 'sql_limit')){
	$config->addConfig('emaillists', 'sql_limit', "50", 'Set select limit to avoid Exhausting Memory');
}
