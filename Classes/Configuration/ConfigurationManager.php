<?php
namespace SAV\SavLibraryKickstarter\Configuration;
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Laurent Foulloy <yolf.typo3@orange.fr>
*  All rights reserved
*
*  This class is a backport of the corresponding class of FLOW3. 
*  All credits go to the v5 team.
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
 * Configuration manager
 *
 * @package     Kickstarter
 * @subpackage  Configuration
 */
class ConfigurationManager {

  /**
   * Constants
   */
  const CONFIGURATION_DIRECTORY = 'Configuration/Kickstarter/';
  const CONFIGURATION_FILE_NAME = 'Kickstarter.json';
  const LIBRARY_TYPE_FILE_NAME = 'LibraryType.txt';
  const UGRADE_DIRECTORY = 'Classes/Upgrade/';
  const UPGRADE_ROOT_CLASS_NAME = 'Tx_SavLibraryKickstarter_Upgrade_Upgrade';

  const TYPE_SAV_LIBRARY = 0;
  const TYPE_SAV_LIBRARY_PLUS = 1;
  const TYPE_SAV_LIBRARY_MVC = 2;
  
	/**
	 * @var string
	 */
  protected $extensionKey;

  /**
	 * @var \SAV\SavLibraryKickstarter\Configuration\SectionManager
	 */
  protected $sectionManager;
  
  /**
	 * @var \SAV\SavLibraryKickstarter\CodeGenerator\AbstractCodeGenerator
	 */
	protected $codeGenerator = NULL;
	
		/**
	 * @var \SAV\SavLibraryKickstarter\Compatibility\ExtensionManager
	 */
	protected $extensionManager = NULL;
	
  /**
	 * @var array
	 */
  protected $upgradeFiles = NULL;
  
	/**
	 * Constructor.
	 *
	 * @return none
	 */
  public function __construct($extensionKey) {
    $this->extensionKey = $extensionKey;
    $this->sectionManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('SAV\\SavLibraryKickstarter\\Utility\\ItemManager');
  }

	/**
	 * Sets the extension key.
	 *
	 * @param string $extensionKey The extension key
	 * @return none
	 */
  public function setExtensionKey($extensionKey) {
    $this->extensionKey = $extensionKey;
  }

	/**
	 * Gets the section manager.
	 *
	 * @param none
	 * @return \SAV\SavLibraryKickstarter\Configuration\SectionManager
	 */
  public function getSectionManager() {
    return $this->sectionManager;
  }

	/**
	 * Gets the code generator.
	 *
	 * @param none
	 * @return \SAV\SavLibraryKickstarter\CodeGenerator
	 */
  public function getCodeGenerator() {
    if ($this->codeGenerator === NULL) {
      $type = 'CodeGeneratorFor' . $this->getCurrentLibraryName();
      $this->codeGenerator = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('SAV\\SavLibraryKickstarter\\CodeGenerator\\' . $type, $this->getSectionManager());
    }
    return $this->codeGenerator;
  }

	/**
	 * Gets the code generator.
	 *
	 * @param none
	 * @return \SAV\SavLibraryKickstarter\Compatibility\ExtensionManager
	 */
  public function getExtensionManager() {
    if ($this->extensionManager === NULL) {
      $this->extensionManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('SAV\\SavLibraryKickstarter\\Compatibility\\ExtensionManager', $this->extensionKey);
    }
    return $this->extensionManager;
  }

	/**
	 * Gets the configuration.
	 *
	 * @param none
	 * @return array The configuration
	 */
  public function getConfiguration() {
    return $this->getSectionManager()->getItemsAsArray();
  }

	/**
	 * Gets the SAV Library Kickstarter Version.
	 *
	 * @param none
	 * @return string The SAV Library Kickstarter Version
	 */
  public static function getSavLibraryKickstarterVersion() {
    return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sav_library_kickstarter']['version'];
  }

	/**
	 * Gets the SAV Library Version.
	 *
	 * return string The SAV Library  Version
	 */
  public static function getSavLibraryVersion() {
    return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sav_library']['version'];
  }

	/**
	 * Gets the SAV Library Plus Version.
	 *
	 * @return string The SAV Library  Version
	 */
  public static function getSavLibraryPlusVersion() {   
    return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sav_library_plus']['version'];
  }

	/**
	 * Gets the SAV Library MVC Version.
	 *
	 * @return string The SAV Library MVC Version
	 */
  public static function getSavLibraryMvcVersion() {
    return $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sav_library_mvc']['version'];
  }

	/**
	 * Gets the extension directory.
	 *
	 * @param string $extensionKey The extension key
	 * @return string The directory
	 */
  public static function getExtensionDir($extensionKey) {
    return PATH_typo3conf . 'ext/' . $extensionKey . '/';
  }

	/**
	 * Gets the extension version.
	 *
	 * @param string $extensionKey The extension key
	 * @return string The version
	 */
  public function getExtensionVersion($extensionKey) {
  	if (empty($extensionKey)) {
  		return NULL;  		
 		} else {
 			if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($extensionKey)) {
 				$extensionConfigurationFileName = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extensionKey) . 'ext_emconf.php';
 			} else {
 				// Tries a default name
 				$extensionConfigurationFileName = self::getExtensionsRootDir(). $extensionKey . '/ext_emconf.php'; 				
 			}
 			
 			// Opens the file if it exists
 			if (file_exists($extensionConfigurationFileName)) {
    		$_EXTKEY = $extensionKey;
    		require($extensionConfigurationFileName);
    		return($EM_CONF[$_EXTKEY]['version']); 				
 			} else {
 				return NULL;
 			}				
 		}
  }  
  
	/**
	 * Gets the root directory for extensions.
	 *
	 * @param none
	 * @return string The directory
	 */
  public static function getExtensionsRootDir() {
    return PATH_typo3conf . 'ext/';
  }

	/**
	 * Creates the root directory for the extension.
	 *
	 * @param string $extensionKey The extension key
	 * @return none
	 */
  public static function createConfigurationDir($extensionKey) {
    $configurationDirectory = self::getExtensionDir($extensionKey) . self::CONFIGURATION_DIRECTORY;
    if (!is_dir($configurationDirectory)) {
      \TYPO3\CMS\Core\Utility\GeneralUtility::mkdir_deep(self::getExtensionsRootDir(), $extensionKey . '/' . self::CONFIGURATION_DIRECTORY);
    }
  }

	/**
	 * Checks if the extension was created with the SAV Library Kickstarter.
	 *
	 * @param none
	 * @return boolean
	 */
  public function isSavLibraryKickstarterExtension() { 	
    return file_exists($this->getConfigurationFileName());
  }

	/**
	 * Checks if the extension was created with the Kickstarter.
	 *
	 * @param string $extensionKey The extension key
	 * @return boolean
	 */
  public function isKickstarterExtension($extensionKey = NULL) {
    if ($extensionKey === NULL) {
      $extensionKey = $this->extensionKey;
    }
    $extensionDirectory = self::getExtensionDir($extensionKey);

    if (file_exists($extensionDirectory . 'doc/wizard_form.dat')) {
      $wizardFormFileName = $extensionDirectory . 'doc/wizard_form.dat';
      $wizardFormFileContent = \TYPO3\CMS\Core\Utility\GeneralUtility::getURL($wizardFormFileName);
      $configuration = unserialize($wizardFormFileContent);
      // Checks if the extension was generated with sav_library
      if ($configuration['savext'][1]['generateForm']) {
        return TRUE;
      } else {
        return FALSE;
      }
    } else {
      return FALSE;
    }
  }

  
	/**
	 * Checks if the configuration file exists for a given extension and a given library type.
	 *
	 * @param integer $libraryName The library type
	 * @return boolean
	 */
  public function configurationFileExists($extensionKey, $libraryName) {
  	$extensionDirectory = self::getExtensionDir($extensionKey);
    $configurationFileName = $extensionDirectory . self::CONFIGURATION_DIRECTORY . $libraryName. '/' . self::CONFIGURATION_FILE_NAME;

    return file_exists($configurationFileName);
  }
  
	/**
	 * Checks if the extension is loaded.
	 *
	 * @param string $extensionKey The extension key
	 * @return boolean
	 */
  public function isLoadedExtension($extensionKey = NULL) {
    if ($extensionKey === NULL) {
      $extensionKey = $this->extensionKey;
    }
    return \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($extensionKey);
  }
  
	/**
	 * Loads the configuration.
	 *
	 * @param none
	 * @return none
	 */
  public function loadConfiguration($version = '') {
    // Checks if the file exists
    if ($this->isSavLibraryKickstarterExtension()) {
      if ($this->getSectionManager()->count() == 0) {
      	if ($version != '') {
        	$sections = json_decode(\TYPO3\CMS\Core\Utility\GeneralUtility::getURL($this->getConfigurationFileName($this->extensionKey, $version)), TRUE);
      	} else {
        	$sections = json_decode(\TYPO3\CMS\Core\Utility\GeneralUtility::getURL($this->getConfigurationFileName()), TRUE);
      	}
        if ($GLOBALS['LANG']->charSet == 'iso-8859-1') {
          array_walk_recursive($sections, 'self::utf8_decode');
        }

        foreach($sections as $key => $section) {
          if (is_array($section)) {
            $this->getSectionManager()->addItem(array($key => $section));
          } else {
            $this->getSectionManager()->addItem($key);
          }
        }
      }
    }
  }

	/**
	 * Saves the configuration.
	 *
	 * @param none
	 * @return none
	 */
  public function saveConfiguration() {
  	$version = $this->getSectionManager()->getItem('emconf')->getItem(1)->getItem('version');
		// Saves the configuration with a version
		$this->saveConfigurationVersion($version);
		// Saves the working configuration	
		$this->saveConfigurationVersion();				
  }

	/**
	 * Method called by array_walk_recursive to encode fields in utf8 (required by json_encode).
	 *
	 * @param mixed $item The item
	 * @return string The rendered view
	 */
  public static function utf8_encode(&$item) {
    if (is_string($item)) {
      $item = utf8_encode($item);
    }
    return $item;
  }

	/**
	 * Method called by array_walk_recursive to encode fields in utf8 (required by json_encode).
	 *
	 * @param mixed $item The item
	 * @return string The rendered view
	 */
  public static function utf8_decode(&$item) {
    if (is_string($item)) {
      $item = utf8_decode($item);
    }
    return $item;
  }

	/**
	 * Saves the configuration.
	 *
	 * @param string The version
	 * @return none
	 */
  public function saveConfigurationVersion($version = '') {
    $configuration = $this->getConfiguration();
    if ($GLOBALS['LANG']->charSet == 'iso-8859-1') {
      array_walk_recursive($configuration, 'self::utf8_encode');
    }
    $jsonContent = json_encode($configuration);
    $fileName = $this->getConfigurationFileName($this->extensionKey, $version);
    \TYPO3\CMS\Core\Utility\GeneralUtility::writeFile($fileName, $jsonContent);
  }

	/**
	 * Gets the current library version depending on the library type.
	 *
	 * @param none
	 * @return integer The library version
	 */
  public function getCurrentLibraryVersion() {
    $libraryType = $this->getSectionManager()->getItem('general')->getItem(1)->getItem('libraryType');      
    switch($libraryType) {
      case self::TYPE_SAV_LIBRARY:
        return self::getSavLibraryVersion();
      case self::TYPE_SAV_LIBRARY_PLUS:
        return self::getSavLibraryPlusVersion();
      case self::TYPE_SAV_LIBRARY_MVC:
        return self::getSavLibraryMVCVersion();
      default:
        throw new RuntimeException('The library type "' . $libraryType . '" is not known !');
    }
  }

	/**
	 * Gets the current library name depending on the library type.
	 *
	 * @param none
	 * @return integer The library name
	 */
  public function getCurrentLibraryName() {
    $libraryType = $this->getSectionManager()->getItem('general')->getItem(1)->getItem('libraryType');
    return self::getLibraryName($libraryType); 
  }

	/**
	 * Gets the library name depending on the library type.
	 *
	 * @param integer $libraryType
	 * @return integer The library name
	 */
  public static function getLibraryName($libraryType) {

    switch($libraryType) {
      case self::TYPE_SAV_LIBRARY:
        return 'SavLibrary';
      case self::TYPE_SAV_LIBRARY_PLUS:
        return 'SavLibraryPlus';
      case self::TYPE_SAV_LIBRARY_MVC:
        return 'SavLibraryMvc';
      default:
        throw new \RuntimeException('The library type "' . $libraryType . '" is not known !');
    }
  }  
  
	/**
	 * Gets the library type file name.
	 *
	 * @param string $extensionKey The extension key
	 * @return string The configuration file name
	 */
  public function getLibraryTypeFileName($extensionKey = NULL) {
    if ($extensionKey === NULL) {
      $extensionKey = $this->extensionKey;
    }
    $extensionDirectory = self::getExtensionDir($extensionKey);
    return $extensionDirectory . self::CONFIGURATION_DIRECTORY . self::LIBRARY_TYPE_FILE_NAME;
  }
  
	/**
	 * Builds the configuration directory if needed.
	 *
	 * @param string $extensionKey The extension key
	 * @param integer $libraryType The library type
	 * @return none
	 */
  public function buildConfigurationDirectory($extensionKey, $libraryType) {
  	
	  // Builds the new configuration directory  
		$extensionDirectory = self::getExtensionDir($extensionKey);  
		$libraryName = self::getLibraryName($libraryType);  
		$configurationDirectory =  $extensionDirectory . self::CONFIGURATION_DIRECTORY . $libraryName . '/';

		if (!is_dir($configurationDirectory)) {
		   \TYPO3\CMS\Core\Utility\GeneralUtility::mkdir_deep(self::getExtensionsRootDir(), $extensionKey . '/' . self::CONFIGURATION_DIRECTORY . $libraryName . '/');
		}
  }  
  
	/**
	 * Gets the configuration file name.
	 *
	 * @param string $extensionKey The extension key
	 * @return string The configuration file name
	 */
  public function getConfigurationFileName($extensionKey = NULL, $version = '') {

    if ($extensionKey === NULL) {
      $extensionKey = $this->extensionKey;
    }
    $extensionDirectory = self::getExtensionDir($extensionKey);
    $libraryName = trim(\TYPO3\CMS\Core\Utility\GeneralUtility::getURL(self::getLibraryTypeFileName($extensionKey)));  

    // Builds the version if any
    if ($version != '') {
			$version = '_' . str_replace('.', '_', $version);    	
    }
    
    // Builds the file name
    $configurationFileNameParts = pathinfo(self::CONFIGURATION_FILE_NAME);
    $fileName = $configurationFileNameParts['filename'] . $version . '.' . $configurationFileNameParts['extension'];    
  
    return $extensionDirectory . self::CONFIGURATION_DIRECTORY . $libraryName. '/' . $fileName;
  }
 
	/**
	 * Checks if an extension should be upgraded.
	 *
	 * @param none
	 * @return none
	 */
  public function checkForUpgrade() {

    if ($this->isSavLibraryKickstarterExtension()) {
      // Gets the files
      if ($this->upgradeFiles === NULL) {
        $files = \TYPO3\CMS\Core\Utility\GeneralUtility::getFilesInDir(self::getExtensionDir('sav_library_kickstarter') . self::UGRADE_DIRECTORY);
        foreach($files as $file) {
          if (preg_match('/^UpgradeTo([A-Za-z]+)([0-9]+)\.php$/', $file, $match)) {
            $version = $match[2];
            $this->upgradeFiles[$match[1]][$version] = $file;
          }
        }
      }
      
      $this->loadConfiguration();
      $currentLibraryVersion =  \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger($this->getCurrentLibraryVersion());
      $currentLibraryName = $this->getCurrentLibraryName();
      
      if (is_array($this->upgradeFiles[$currentLibraryName])) {
	      ksort($this->upgradeFiles[$currentLibraryName]);
	
	      foreach($this->upgradeFiles[$currentLibraryName] as $version => $fileInformation) {
	        $libraryVersion = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger($this->getSectionManager()->getItem('general')->getItem(1)->getItem('libraryVersion'));
	        if ($libraryVersion < $currentLibraryVersion && $libraryVersion < $version) {
	            $this->upgradeExtension('To' . $currentLibraryName . $version);
	        }
	      }
	    }
      
      // Upgrades the library version
      $this->getSectionManager()->getItem('general')->getItem(1)->replace(array('libraryVersion' => $this->getCurrentLibraryVersion()));

      // Sets extensionMustbeUpgraded to TRUE
      $this->getSectionManager()->getItem('general')->getItem(1)->replace(array('extensionMustbeUpgraded' => TRUE));

      $this->saveConfiguration();
    } elseif ($this->isKickstarterExtension()) {
      $version = 'FromKickstarter';
      $this->upgradeExtension($version);

      // Sets extensionMustbeUpgraded to TRUE
      $this->getSectionManager()->getItem('general')->getItem(1)->replace(array('extensionMustbeUpgraded' => TRUE));

      $this->saveConfiguration();
    }
  }
  
	/**
	 * Upgrades an extension to a new version.
	 *
	 * @param string $version The new version
	 * @return none
	 */
  public function upgradeExtension($version) {
    $upgradeManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(self::UPGRADE_ROOT_CLASS_NAME . $version, $this->extensionKey);
    $upgradeManager->preProcessing();

    if ($this->isSavLibraryKickstarterExtension()) {
      $this->loadConfiguration();
      foreach($this->getSectionManager()->getItems() as $sectionName => $section) {
        $method = 'upgrade' . ucfirst($sectionName) . 'Section';
        if (method_exists($upgradeManager, $method) && $section->getItems()->count() > 0) {
          $section->replace($upgradeManager->$method($section));
        } 
      }
      $upgradeManager->postProcessing($this->getSectionManager());
      $this->saveConfigurationVersion($version);
    }
  }
  
}
?>
