<?php

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

class PushWooshCaller {
	
	
   public $AUTH_KEY;
   public $PW_APPLICATION;
   public $url_api;
   public $date;
   public $text_de;
   public $text_en;
   public $devices = array();
   
    #define('PW_AUTH', '3UJMiWGR2Y87aSikeSz/3jrlxrmQdS2AlnNYNTFY/w6bS5j83XGMGNq1vVThvDMcovnVMm8DswV2CzqnZDm2');
    #define('PW_APPLICATION', 'FB1B0-99CCD');
 
 
   public function init()
   {
	   
   }
   
   
   public function doPostRequest($url, $data, $optional_headers = null) {
        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => $data
            ));
        if ($optional_headers !== null)
            $params['http']['header'] = $optional_headers;
 
        $ctx = stream_context_create($params);
        $fp = fopen($url, 'rb', false, $ctx);
        if (!$fp)
            throw new Exception("Problem with $url, $php_errmsg");
 
        $response = @stream_get_contents($fp);
        if ($response === false)
            return false;
        return $response;
    }
 
    public function pwCall( $action, $data = array() ) {
        $url = $this->url_api.$action;
        $json = json_encode( array( 'request' => $data ) );
        $res = $this->doPostRequest( $url, $json, 'Content-Type: application/json' );
        return @json_decode( $res, true );
    }
 
    public function sendPush() {
		return $this->pwCall( 'createMessage', array(
        	'application' => $this->PW_APPLICATION,
        	'auth' => $this->AUTH_KEY,
        	'notifications' => array(
                    array(
                        'send_date' => $this->date,
                        'content' => $this->text_de,
                        	//"en" => $this->text_en,
                        	//"de" => $this->text_de
                        //),
                        'ios_trim_content' => 0,
                        //'ios_badges' => 3,
                        'data' => array( 'custom' => 'q8y_pushwoosh' ),
                        //'link' => 'http://pushwoosh.com/',
                        'devices' => $this->devices,
                    )
                )
            )
        );
		
    }
        
	
} 


?>