<?php
namespace SAV\SavLibraryKickstarter\Parser;
/***************************************************************
*  Copyright notice
*
*  (c) 2014 Laurent Foulloy <yolf.typo3@orange.fr>
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
 * Template Parser
 *
 * @package     SavLibraryKickstarter
 * @subpackage  Parser
 */
class ContentParser {

	/**
	 * @var \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext
	 */
  protected static $controllerContext = NULL;	
	
	/**
	 * Parses a content
	 *
	 * @param string $content The content to parse.
	 * @param array $arguments The arguments for the parser.
	 * @param string $nameSpace The name space.
	 * @return string The parsed content
	 */
  public static function parse($content, $arguments = array(), $nameSpace = '{namespace sav=SAV\\SavLibraryKickstarter\\ViewHelpers}') {
	
    $templateParser = \SAV\SavLibraryKickstarter\Compatibility\TemplateParserBuilder::build();

    // Builds the rendering context
		$renderingContext = self::buildRenderingContext($arguments);

		// Parses the content
    $parsedTemplate = $templateParser->parse($nameSpace . $content);
		return trim($parsedTemplate->render($renderingContext));		
  }	
  
	/**
	 * Builds the rendering context
	 *
	 * @param array $arguments The arguments for the parser.
	 * @return \TYPO3\CMS\Fluid\CoreRendering\RenderingContext The rendering
	 */  
	protected static function buildRenderingContext($arguments) {
		$objectManager = \SAV\SavLibraryKickstarter\Compatibility\TemplateParserBuilder::getObjectManager(); 
		
		// Builds the variable container
    $variableContainer = $objectManager->get('TYPO3\\CMS\\Fluid\\Core\\ViewHelper\\TemplateVariableContainer', $arguments);
		
    // Builds the rendering context    
		$renderingContext = $objectManager->get('TYPO3\\CMS\\Fluid\\Core\\Rendering\\RenderingContext');

    // Adds the controller context
  	if (self::$controllerContext !== NULL) {
  		$renderingContext->setControllerContext(self::$controllerContext);
  	}
		
		//Injects the variable container
		$renderingContext->injectTemplateVariableContainer($variableContainer);
			
		return $renderingContext;
	}		

	/**
	 * Sets the controller context
	 *
	 * @param Tx_Extbase_MVC_Controller_ControllerContext $controllerContext The controller context.
	 * @return none
	 */
   public function setControllerContext($controllerContext) {
    self::$controllerContext = $controllerContext;
  }
  	
}
?>
