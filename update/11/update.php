<?php
//Build 11 fix build 10 no var

$config = OW::getConfig();

if(!$config->configExists('emaillists', 'sql_limit')){
	$config->addConfig('emaillists', 'sql_limit', "50", 'Set select limit to avoid Exhausting Memory');
}
