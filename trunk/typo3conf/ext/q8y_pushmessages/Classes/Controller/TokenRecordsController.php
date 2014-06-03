<?php
namespace TYPO3\Q8yPushmessages\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 
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

include_once(PATH_site.'typo3conf/ext/q8y_pushmessages/Classes/Util/PushWooshCaller.php'); 
 
class TokenRecordsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	
	
	
	protected $pageRenderer;
	public $extensionSettings;
	

	/**
	 * action list
	 *
	 * @return void
	 */
	
	protected function initializeAction()
	{
		# Settings from Extension manager conf.
		$this->extensionSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['q8y_pushmessages']);
	}
	 
	public function listAction() {
		//$tokenRecordss = $this->tokenRecordsRepository->findAll();
		
		# Init DirectMail utility
		$dmail_folder = $this->extensionSettings['derectMailPID'];
	    $dmail_comma = explode(",", $dmail_folder);
	    $dmail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\Q8yPushmessages\Domain\Repository\DmailRepository"); 
		
		$out_array = array();
		foreach ($dmail_comma as $folder)
		{
			$tokenRecordss = $dmail->showDmailRecipientLists($folder);
			$out_array = array_merge($out_array, $tokenRecordss); 
		}
		
		
		
		
		$this->view->assign('tokenRecordss', $out_array);
	}

	/**
	 * action show
	 *
	 * @param \TYPO3\Q8yPushmessages\Domain\Model\TokenRecords $tokenRecords
	 * @return void
	 */
	public function showAction(\TYPO3\Q8yPushmessages\Domain\Model\TokenRecords $tokenRecords) {	
		$this->view->assign('tokenRecords', $tokenRecords);
		
	}

	/**
	 * action sendMessages
	 *
	 * @return void
	 */
	public function sendMessagesAction() {
		
	   # Clear inactive	tokens
		
		
	   $pushwoosh = new \PushWooshCaller;
	   $POSTvars = $this->request->getArguments();
	   
	   if (count($POSTvars['active']) < 1)
	   {
		   $this->flashMessageContainer->add('','No selected active users. Please, select from list.', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR );
		   $this->redirect('list');    
	   }
	   
	   
	   $dmail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\Q8yPushmessages\Domain\Repository\DmailRepository");
	   $devices = $dmail->selectActiveTokens($POSTvars['active']); 
	   

	   # Set PushWoosh settings
	   $pushwoosh->AUTH_KEY = $this->extensionSettings['authKey'];
	   $pushwoosh->PW_APPLICATION = $this->extensionSettings['appCode'];
	   $pushwoosh->url_api = $this->extensionSettings['apiUrl'];
	   $pushwoosh->text_en = $POSTvars['nachricht_en'];
	   $pushwoosh->text_de = $POSTvars['nachricht_de'];
	   $pushwoosh->devices = $devices;
	   if ($POSTvars['datetime'])
	   {
	   		$date = new \DateTime($POSTvars['datetime']);
	   		$date->setTimezone(new \DateTimeZone($this->extensionSettings['apiTimezone']));
	   		$message_date = $date->format($this->extensionSettings['apiFormatDate']);
	   }		
	   else $message_date = 'now';
	   $pushwoosh->date = $message_date;
	   
	   $result_push = $pushwoosh->sendPush();
	   if ($result_push['status_code'] == 200)
	   {
		   $this->flashMessageContainer->add('Your message has been sent to '.count($devices).' users. ','Ok!', \TYPO3\CMS\Core\Messaging\FlashMessage::OK );
	   } else
	   {
		   $this->flashMessageContainer->add($result_push['status_message'],'Error code: '.$result_push['status_code'], \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR );
	   }
	   
       $this->redirect('list');    
	}

	/**
	 * action clearTokens
	 *
	 * @return void
	 */
	public function clearTokensAction() {

	}

	/**
	 * action
	 *
	 * @return void
	 */
	public function Action() {

	}

}
?>