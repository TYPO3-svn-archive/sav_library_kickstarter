<?php

/***************************************************************
*  Copyright notice
*
*  (c) <f:format.date format="Y">now</f:format.date> {extension.emconf.1.author} <{extension.emconf.1.author_email}>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(t3lib_extMgm::extPath('sav_library').'class.tx_savlibrary.php');

<f:alias map="{extensionName: '{sav:function(name:\'removeUnderscore\', arguments:\'{extension.general.1.extensionKey}\')}'}">
/**
 * Plugin '{extension.emconf.1.title}' for the '{extension.general.1.extensionKey}' extension.
 *
 * @author	{extension.emconf.1.author} <{extension.emconf.1.author_email}>
 * @package	TYPO3
 * @subpackage	tx_{extensionName}
 */
class tx_{extensionName}_pi1 extends tslib_pibase  {
	public $prefixId = 'tx_{extensionName}_pi1';		// Same as class name
	public $scriptRelPath = 'pi1/class.tx_{extensionName}_pi1.php';	// Path to this script relative to the extension dir.
	public $extKey = '{extension.general.1.extensionKey}';	// The extension key.
	public $pi_checkCHash = false;
	
	public $extConfig;   // Extension configuration
	            
	public function main($content,$conf) {
	  			
	  // Initialisation
	  $this->pi_setPiVarDefaults();
	  $this->pi_loadLL();
		$this->pi_USER_INT_obj = 1;	// Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!
	          
	  // Initialize the configuration
	  $this->initExtConfig();
	  // Create the savlibrary object and set the reference to the extension object
	  $savlibrary = t3lib_div::makeInstance('tx_savlibrary');
	  $savlibrary->initVars($this);
	
	  // Set the debug variable. Use debug ONLY for development
	  $savlibrary->debug = {f:if(condition:extension.general.1.debug, then:extension.general.1.debug, else:0)};
	          
								
	  // Generate the form
	  $out = $savlibrary->generateForm($conf);
	          
	    return $out;
	  }
	      			
	  /**
	  * Initialize the configuration variable
	  * 
	  * @return none                  			
	  **/
	  public function initExtConfig() {
	    $this->extConfig = t3lib_div::xml2array($this->cObj->fileResource('EXT:{extension.general.1.extensionKey}/pi1/tx_{extensionName}_pi1.xml'), 'sav_library_pi');
	  } 
	      			
	  /**
	  * Additional methods
	  **/
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/{extension.general.1.extensionKey}/pi1/class.tx_{extensionName}_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/{extension.general.1.extensionKey}/pi1/class.tx_{extensionName}_pi1.php']);
}
</f:alias>
?>
