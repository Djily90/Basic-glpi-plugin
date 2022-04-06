<?php



if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}
class PluginDjilyConfig  extends CommonDBTM {
/*
   static function canCreate() {
      return plugin_djily_haveRight('config', 'w');
   }

   static function canView() {
      return plugin_djily_haveRight('config', 'r');
   }
*/

   /**
    * Configuration form
   **/

   function showConfigForm() {

      $id = $this->getFromDB(1);
      echo "<form method='post' action='./config.form.php' method='post'>";
      echo "<table class='tab_cadre' cellpadding='5'>";
      echo "<tr><th colspan='2'>Configuration de mon plugin</th></tr>";

      echo "<tr class='tab_bg_1'>";
      echo "<td>Solution oligatoire</td>";
      echo "<td><select name='solution'>";
      echo "<option value='0' ".(($this->fields["solution"] == 0)?" selected ":"").">Non</option>";
      echo "<option value='1' ".(($this->fields["solution"] == 1)?" selected ":"").">Oui</option>";
      echo "</select></td></tr>";

      echo "<tr class='tab_bg_1'><td class='center' colspan='2'>";
      echo "<input type='hidden' name='id' value='1' class='submit'>";
      echo "<input type='submit' name='update' value='modifier' class='submit'>";
      echo "</td></tr>";
      echo "</table>";
      Html::closeForm();
   }
}