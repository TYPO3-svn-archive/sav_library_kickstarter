<?php

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * A view helper for sorting the fields in a view.
 *
 * This view helper has exactly the same syntax as the fluid alias viewhelper.
 * The main difference is that obect accessor may contain other object accesor
 * Therefore {a.b.{c.d}.e} is allowed
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
require_once(t3lib_extMgm::extPath('sav_library_kickstarter') . 'Classes/ViewHelpers/SortFieldsViewHelper.php');

class Tx_SavLibraryKickstarter_ViewHelpers_SortFieldsViewHelper extends \SAV\SavLibraryKickstarter\ViewHelpers\SortFieldsViewHelper {
}
?>

