'type' => 'check',
'cols' => 4,
'items' => array (
<f:for each="{field.items}" as="item" key="itemKey">
  array('LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xml:{model}.{field.fieldname}.I.{itemKey}', ''),
</f:for>
),
