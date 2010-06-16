<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Laurent Foulloy <yolf.typo3@orange.fr>
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
class Tx_SavLibraryKickstarter_Parser_TemplateParser {

	/**
	 * @var Tx_Extbase_MVC_Controller_ControllerContext
	 */
  protected $controllerContext;
  
	/**
	 * @var Tx_Fluid_Core_ViewHelper_ViewHelperVariableContainer
	 */
  protected $viewHelperVariableContainer;
  
	/**
	 * Parses a template
	 *
	 * @param string $template The template to parse.
	 * @param array $arguments The arguments for the parser.
	 * @param string $nameSpace The name space.
	 * @return string The parsed content
	 */
  public function parseTemplate($template, $arguments = array(), $nameSpace = '{namespace sav=Tx_SavLibraryKickstarter_ViewHelpers}') {

    $templateParser = Tx_Fluid_Compatibility_TemplateParserBuilder::build();
		$objectFactory = t3lib_div::makeInstance('Tx_Fluid_Compatibility_ObjectFactory');
		$variableContainer = $objectFactory->create('Tx_Fluid_Core_ViewHelper_TemplateVariableContainer', $arguments);

		$renderingConfiguration = $objectFactory->create('Tx_Fluid_Core_Rendering_RenderingConfiguration');
		$renderingContext = $objectFactory->create('Tx_Fluid_Core_Rendering_RenderingContext');
		if ($this->controllerContext !== NULL) {
			$renderingContext->setControllerContext($this->controllerContext);
		}
    $renderingContext->setTemplateVariableContainer($variableContainer);
		$renderingContext->setRenderingConfiguration($renderingConfiguration);
		
    if ($this->viewHelperVariableContainer !== NULL) {
		  $viewHelperVariableContainer = $this->viewHelperVariableContainer;
    } else {
		  $viewHelperVariableContainer = $objectFactory->create('Tx_Fluid_Core_ViewHelper_ViewHelperVariableContainer');
    }
		$renderingContext->setViewHelperVariableContainer($viewHelperVariableContainer);

		$parsedTemplate = $templateParser->parse($nameSpace . $template);

    return $parsedTemplate->render($renderingContext);
  }

	/**
	 * Sets the viewHelper variable container
	 *
	 * @param Tx_Fluid_Core_ViewHelper_ViewHelperVariableContainer $viewHelperVariableContainer The viewHelper variable container.
	 * @return none
	 */
	public function setViewHelperVariableContainer($viewHelperVariableContainer) {
    $this->viewHelperVariableContainer = $viewHelperVariableContainer;
  }

	/**
	 * Sets the controller context
	 *
	 * @param Tx_Extbase_MVC_Controller_ControllerContext $controllerContext The controller context.
	 * @return none
	 */
   public function setControllerContext($controllerContext) {
    $this->controllerContext = $controllerContext;
  }
  
}
?>