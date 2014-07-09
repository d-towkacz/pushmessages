<?php
namespace TYPO3\Q8yPushmessages\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package q8y_pushmessages
 * @author d.towkacz@quintinity.de
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
require_once (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('direct_mail').'mod3/class.tx_directmail_recipient_list.php');
class DmailRepository extends \tx_directmail_recipient_list {
 
 	
 	
 	public function showDmailRecipientLists($dmail_folder) {
 		
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'uid,pid,title,description,type',
			'sys_dmail_group',
			'pid = '.intval($dmail_folder).
				\TYPO3\CMS\Backend\Utility\BackendUtility::deleteClause('sys_dmail_group'),
			'',
			$GLOBALS['TYPO3_DB']->stripOrderBy($GLOBALS['TCA']['sys_dmail_group']['ctrl']['default_sortby'])
		);
		
		$out_array = array();
		$array_count = 0;
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$this->queryGenerator = \t3lib_div::makeInstance('mailSelect');
			
			$this->id = intval($dmail_folder);
			@$result = $this->cmd_compileMailGroup(intval($row['uid']));
			 			
			$count = 0;
			$idLists = $result['queryInfo']['id_lists'];
			
			$out_array[$array_count]['editLink'] = $this->editLink('sys_dmail_group',$row['uid']);
			$out_array[$array_count]['title'] = '<strong>'.htmlspecialchars(\TYPO3\CMS\Core\Utility\GeneralUtility::fixed_lgd_cs($row['title'],30)).'</strong>&nbsp;&nbsp;';
			$out_array[$array_count]['users_count'] = count($idLists['fe_users']);
			$out_array[$array_count]['active_array'] = "-";
			
			@$users_comma = implode(',',$idLists['fe_users']);
			if ($users_comma != '')
			{
				$array_active = $this->selectActiveUsers($users_comma);
				$count_active = count($array_active);
				if ($count_active > 0) {
					$out_array[$array_count]['active_array'] = "<span style='color:green;'>".$count_active."</span>";
					$out_array[$array_count]['active_comma'] = implode(',',$array_active);
				}
				
				
				
			}	
			
			$array_count++;
			

		}
		

		return $out_array;
	}
	
	
	
	public function selectActiveUsers($comma_array)
	{
	
		
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'feuseruid,token',
			'tx_q8ypushmessages_domain_model_tokenrecords',
			'active = 1 AND feuseruid IN ('.$comma_array.')'
		);
		
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		
		   $out[] = $row['feuseruid']; 
		
		}
		return 	$out;
		
	}
	
	public function selectActiveTokens($users_array)
	{
		$out = array();
		if (count($users_array) > 0)
		{
		$users_array = array_unique($users_array);
		$comma_array = implode(",", $users_array);
		
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'feuseruid,token',
			'tx_q8ypushmessages_domain_model_tokenrecords',
			'active = 1 AND feuseruid IN ('.$comma_array.')'
		);
		
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		
		   $out[] = $row['token'];
		   
		
		}
		}
		return 	$out;
		
	}
    
	 
 }

?>