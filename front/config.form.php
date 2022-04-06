<?php
/*
include('../../../inc/includes.php');

Session::haveRight("config", UPDATE);

Html::header("Djily", $_SERVER["PHP_SELF"], "tools", "plugins");
echo __("This is the plugin config page", 'Djily');

echo Html::submit(_sx('button', 'Save'), array('name' => 'update_user_profile'));
Html::footer();
*/

include("../../../inc/includes.php");
require_once("../inc/config.class.php");

$plugin = new Plugin();
if ($plugin->isActivated("djily")) {
   $config = new PluginDjilyConfig();

   if (isset($_POST["update"])) {
      Session::checkRight("config", UPDATE);
      $config->update($_POST);
      Html::back();

   } else {
      Html::header('Mon Plugin', $_SERVER["PHP_SELF"], "config", "plugins");
      $config->showConfigForm();
   }

} else {
   Html::header('configuration', '', "config", "plugins");
   echo "<div class='center'><br><br>".
         "<img src=\"".$CFG_GLPI["root_doc"]."/pics/warning.png\" alt='warning'><br><br>";
   echo "<b>Merci d'activer le plugin</b></div>";
   Html::footer();
}

Html::footer();