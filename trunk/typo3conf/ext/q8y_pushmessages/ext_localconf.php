<?php

/**
* This authentication hook will be used
* to register the pushwoosh token transmitted
* during mobile app login for the logged in user
* 
* @var mixed
*/
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['postUserLookUp'][]
	= 'EXT:' . $_EXTKEY. '/Classes/Hooks/FeUser/RegisterPushwooshToken.php:TYPO3\Q8yPushmessages\Hooks\FeUser\RegisterPushwooshToken->user_registerToken'; ;