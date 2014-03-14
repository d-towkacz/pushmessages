<?php

namespace TYPO3\Q8yPushmessages\Hooks\FeUser;

require_once(\t3lib_extMgm::extPath('t3_local').'lib/class.tx_t3local_div.php');

class RegisterPushwooshToken {
	
	/**
	* This authentication hook will be used
	* to register the pushwoosh token transmitted
	* during mobile app login for the logged in user
	* 
	* @var mixed
	* @see /typo3/sysext/core/Classes/Authentication/AbstractUserAuthentication.php:start()
	* @see $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['postUserLookUp']
	*/
	public function user_registerToken($params, &$caller) {
    
		if (is_array($params['pObj']->user) && $params['pObj']->user['uid'] > 0) {
 
			// check for VC header
			$headers = \tx_t3local_div::emu_apache_request_headers(); 
			$pushToken = isset($headers["vc-push-token"]) ? $headers["vc-push-token"] : $headers["push-token"];
			$tokenActive = isset($headers["vc-token-active"]) ? $headers["vc-token-active"] : $headers["active"];

			if ($pushToken > '') {
				
				try {
			
					$table = 'tx_q8ypushmessages_domain_model_tokenrecords';
					$where_clause = "token = '{$pushToken}' AND feuseruid ={$params['pObj']->user['uid']}";
					$dat = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('uid', $table, $where_clause);
					
					if ($dat['uid']) {
						// update
						$updateData = Array(
							'active' => $tokenActive,
							'last_login' => time(),
							'tstamp' => time()
						);
						
						$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, "uid = {$dat['uid']}", $updateData); 					

					} else {
						// insert
						$insertData = Array(
							'pid' => 0,
							'active' => $tokenActive,
							'token' => $pushToken,
							'last_login' => time(),
							'feuseruid' => $params['pObj']->user['uid'],
							'tstamp' => time(),
							'crdate' => time()						
						);
						
						$res = $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $insertData); 	
										
					}
					
					if (!$res) {
						throw new Exception('Token registration for user '.$params['user']['uid'].' failed');
					}
				
				} catch (Exception $e) {
					// !IMPORTANT! only devlog to not disturb login process for the app
					\TYPO3\CMS\Core\Utility\GeneralUtility::devLog($e->getMessage(), 'RegisterPushwooshToken');					
				}
			
			}
			
		}
		
	}   		
	
}