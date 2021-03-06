.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Changelog
=========

.. tabularcolumns:: |r|p{13.7cm}|

=======  ===========================================================================
Version  Changes
=======  ===========================================================================
0.5.0    - Warnings corrected.
         - Documentation converted to the reStructuredText format.
         - Bug when calling context sensitive help corrected.
         - Extension versions are kept and can be managed easily. 
         - Generation of  the "types" field in tca.php for extensions using starttime, 
           endtime or access group  fields corrected.
         - Compatibility with TYPO3 7.x.x added

0.4.1    - Code slighly modified in accordance to the TYPO3 coding guidelines.
         - Compatibility with TYPO3 6.2 improved.
         - New type «Currency» added (Feature #52986).
         - Bug #53253 corrected.

0.4.0    - Compatibility with TYPO3 6.1 and 6.2 added.
         - Subforms can be included into subforms.

0.3.0    - Small improvements in the code generation for sav\_library\_plus and
           in fluid templates.
         - documentation and csh files updated.
         - Compatibility with TYP03 6.0 added.
         - Download button added in the extension list.
         - Flag added in the extension configuration to keep the
           ext\_localconf.php file.  

0.2.2    - Small bug corrected and calls to deprecated functions removed.
         - Documentation updated to the new documentation template.
         - Generation of the language files in the XML Localization Interchange
           File Format (.xlf)
         - Generation of dependencies improved.
         - Bugs #39403, #39832 corrected.   
         - Suggestion #39556 corrected.
         - Feature #40074 added. Table sorting configuration from the SAV Library
           Kickstarter is now working correctly.
         - Context Sensitive Help localization files have been totally
           reorganized to facilitate the translation process.  
         
0.2.1    - New icon to upgrade all extensions which need to be upgraded.
         - Better processing of the extension version.

0.2.0    - Changed to stable.
         - f:form.textbox replaced by f:form.textfield in templates.

0.1.3    - Code generation for the SAV Library Plus added. This new library
           replaces the SAV Library one.
         - New feature added to deal with edit or single views that may change
           depending on a cutif condition.
         - Compatibility with the “Fluid” version for TYPO3 4.6 added.   

0.1.2    - Compatibility with the “Fluid” versions for TYPO3 4.4 and TYPO3 4.5
           added (compatibility with TYPO3 4.3 is no more supported).

0.1.1    - Small bugs corrected and several features improved in the code
           generation.

0.1.0    - Several features were improved.
         - Generation of MVC type extension working with extbase and fluid was
           added. The generated extensions require SAV Library MVC
           (sav\_library\_mvc) to be loaded.

0.0.2    - Parser modified to work with fluid 1.2.0 (TYPO3 4.4.0) and fluid 1.0.2
           (TYPO3 4.3.3).
         - Templates modified to display a message when an extension is not
           loaded. 
         - Small bug corrected in the code generation.

0.0.1    - 1st public release.
=======  ===========================================================================