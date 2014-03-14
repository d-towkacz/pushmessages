<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.' . $_EXTKEY,
		'tools',	 // Make module a submodule of 'tools'
		'tokenrecords',	// Submodule key
		'',						// Position
		array(
			'TokenRecords' => 'list, show, sendMessages, clearTokens, ',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tokenrecords.xlf',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Push messages');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_q8ypushmessages_domain_model_tokenrecords', 'EXT:q8y_pushmessages/Resources/Private/Language/locallang_csh_tx_q8ypushmessages_domain_model_tokenrecords.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_q8ypushmessages_domain_model_tokenrecords');
$TCA['tx_q8ypushmessages_domain_model_tokenrecords'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:q8y_pushmessages/Resources/Private/Language/locallang_db.xlf:tx_q8ypushmessages_domain_model_tokenrecords',
		'label' => 'token',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => FALSE,
		'versioning_followPages' => FALSE,
		'origUid' => 't3_origuid',
		//'languageField' => 'sys_language_uid',
		//'transOrigPointerField' => 'l10n_parent',
		//'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'token,last_login,active,feuseruid,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/TokenRecords.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_q8ypushmessages_domain_model_tokenrecords.gif'
	),
);

?>