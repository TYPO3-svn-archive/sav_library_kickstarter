'type' => 'radio',
'items' => array (
<f:for each="{field.items}" as="item" key="itemKey">
  array('LLL:EXT:{extensionKey}/Resources/Private/Language/locallang_db.xml:{model}.{field.fieldname}.I.{itemKey}', '{sav:function(name:"setZeroIfEmpty",arguments:item.value)}'),
</f:for>
),

