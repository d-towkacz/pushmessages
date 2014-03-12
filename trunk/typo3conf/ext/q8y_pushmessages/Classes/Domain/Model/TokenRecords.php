<?php
namespace TYPO3\Q8yPushmessages\Domain\Model;

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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class TokenRecords extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * token
	 *
	 * @var \string
	 */
	protected $token;

	/**
	 * timestamp
	 *
	 * @var \DateTime
	 */
	protected $timestamp;

	/**
	 * active
	 *
	 * @var boolean
	 */
	protected $active = FALSE;

	/**
	 * feuseruid
	 *
	 * @var \integer
	 */
	protected $feuseruid;

	/**
	 * Returns the token
	 *
	 * @return \string $token
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * Sets the token
	 *
	 * @param \string $token
	 * @return void
	 */
	public function setToken($token) {
		$this->token = $token;
	}

	/**
	 * Returns the timestamp
	 *
	 * @return \DateTime $timestamp
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}

	/**
	 * Sets the timestamp
	 *
	 * @param \DateTime $timestamp
	 * @return void
	 */
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
	}

	/**
	 * Returns the active
	 *
	 * @return boolean $active
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * Sets the active
	 *
	 * @param boolean $active
	 * @return void
	 */
	public function setActive($active) {
		$this->active = $active;
	}

	/**
	 * Returns the boolean state of active
	 *
	 * @return boolean
	 */
	public function isActive() {
		return $this->getActive();
	}

	/**
	 * Returns the feuseruid
	 *
	 * @return \integer $feuseruid
	 */
	public function getFeuseruid() {
		return $this->feuseruid;
	}

	/**
	 * Sets the feuseruid
	 *
	 * @param \integer $feuseruid
	 * @return void
	 */
	public function setFeuseruid($feuseruid) {
		$this->feuseruid = $feuseruid;
	}

}
?>