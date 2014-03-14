<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_q8ypushmessages_domain_model_tokenrecords'] = array(
	'ctrl' => $TCA['tx_q8ypushmessages_domain_model_tokenrecords']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, token, last_login, active, feuseruid',
	),
	'types' => array(
		'1' => array('showitem' => ';;;;1-1-1, hidden;;1, token, last_login, active, feuseruid,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'token' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:q8y_pushmessages/Resources/Private/Language/locallang_db.xlf:tx_q8ypushmessages_domain_model_tokenrecords.token',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'last_login' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:q8y_pushmessages/Resources/Private/Language/locallang_db.xlf:tx_q8ypushmessages_domain_model_tokenrecords.last_login',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'active' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:q8y_pushmessages/Resources/Private/Language/locallang_db.xlf:tx_q8ypushmessages_domain_model_tokenrecords.active',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'feuseruid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:q8y_pushmessages/Resources/Private/Language/locallang_db.xlf:tx_q8ypushmessages_domain_model_tokenrecords.feuseruid',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
	),
);

?>