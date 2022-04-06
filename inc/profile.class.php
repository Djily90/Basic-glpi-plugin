<?php


class PluginDjilyProfile extends CommonDBTM {

   static function canCreate() {

      if (isset($_SESSION["glpi_plugin_djily_profile"])) {
        return ($_SESSION["glpi_plugin_djily_profile"]['djily'] == 'w');
      }
      return false;
   }

   static function canView() {

      if (isset($_SESSION["glpi_plugin_djily_profile"])) {
        return ($_SESSION["glpi_plugin_djily_profile"]['djily'] == 'w'
                || $_SESSION["glpi_plugin_djily_profile"]['djily'] == 'r');
      }
      return false;
   }



   static function createAdminAccess($ID) {

      $myProf = new self();
    // si le profile n'existe pas déjà dans la table profile de mon plugin
      if (!$myProf->getFromDB($ID)) {
    // ajouter un champ dans la table comprenant l'ID du profil d la personne connecté et le droit d'écriture
         $myProf->add(array('id' => $ID,
                            'right'       => 'w'));
      }
   }
   
   function createAccess($ID) {
      $this->add(array('id' => $ID));
   }


   static function changeProfile() {

      $prof = new self();
      if ($prof->getFromDB($_SESSION['glpiactiveprofile']['id'])) {
         $_SESSION["glpi_plugin_djily_profile"] = $prof->fields;
      } else {
         unset($_SESSION["glpi_plugin_djily_profile"]);
      }
   }

   // Définition du nom de l'objet dans Profile du coeur
   function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {
      
      if (Session::haveRight("profile", UPDATE)) 
      {
         if ($item->getType() == 'Profile') {
            return "Djily";
         }
      }
      return '';
   }

   // Définition du contenu de l'onglet 
   static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {
        global $CFG_GLPI;

        if ($item->getType() == 'Profile') {
            
            $ID = $item->getID();
            $prof = new self();
            //si le profil n'existe pas dans la base, je l'ajoute
            if (!$prof->GetfromDB($ID)) {
               $prof->createAccess($ID);
            }

            // j'affiche le formulaire
            $prof->showForm($ID);
        }
        return true;
   }

   

    
    function getRightsGeneral()
   {
      $rights = [
          ['itemtype'  => 'PluginDjilyProfile',
                'label'     => 'Djily_label',
                'field'     => 'self::$rightname',
                'rights'    =>  [CREATE  => __('Create'),
                                      READ    => __('Read'),
                                      PURGE   => ['short' => __('Purge'),
                                      'long' => _x('button', 'Delete permanently')]],
                'default'   => 21]];
      return $rights;
   }


      /**
   * Show profile form
   *
   * @param $items_id integer id of the profile
   * @param $target value url of target
   *
   * @return nothing
   **/
   function showForm($profiles_id = 0, $openform = true, $closeform = true) {
      global $DB, $CFG_GLPI;
      

      if (!Session::haveRight("profile",READ)) {
         return false;
      }
      
      echo "<div class='firstbloc'>";
      $canedit = Session::haveRightsOr(self::$rightname, [CREATE, UPDATE, PURGE]);
      $profile = new Profile();
      echo "<form method='post' action='".$profile->getFormURL()."'>";
      
    
      $profile = new Profile();
      $profile->getFromDB($profiles_id);
      if ($profile->getField('interface') == 'central') {
         $rights = $this->getRightsGeneral();
         $profile->displayRightsChoiceMatrix($rights, ['default_class' => 'tab_bg_2',
                                                         'title'         => __('General')]);
      }

      if (!$canedit) {
         echo "<div class='center'>";
         echo Html::hidden('id', ['value' => $profiles_id]);
         echo Html::submit(_sx('button', 'Save'), ['name' => 'update']);
         echo "</div>\n";
         Html::closeForm();
      }
      echo "</div>";
   }


   /*
   function showForm($id, $options=[]) {

      $target = $this->getFormURL();
      if (isset($options['target'])) {
        $target = $options['target'];
      }

      if (!Session::haveRight("profile", READ)) {
         return false;
      }

      $canedit = Session::haveRight("profile", UPDATE);
      $prof = new Profile();
      if ($id){
         $this->getFromDB($id);
         $prof->getFromDB($id);
      }

      echo "<form action='".$target."' method='post'>";
      echo "<table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='2' class='center b'>".sprintf(__('%1$s %2$s'), __('gestion des droits :'),
                                                           Dropdown::getDropdownName("glpi_profiles",
                                                                                     $this->fields["id"]));
      echo "</th></tr>";

      echo "<tr class='tab_bg_2'>";
      echo "<td>Utiliser Mon Plugin</td><td>";
      Profile::dropdownRight("right",
                             ['value'   => $this->fields["right"],
                              'nonone'  => 0,
                              'noread'  => 0,
                              'nowrite' => 0]);
     // Profile::dropdownNoneReadWrite("right", $this->fields["right"], 1, 1, 1);
      echo "</td></tr>";

      if ($canedit) {
         echo "<tr class='tab_bg_1'>";
         echo "<td class='center' colspan='2'>";
         echo "<input type='hidden' name='id' value=$id>";
         echo "<input type='submit' name='update_user_profile' value='"._sx('button', 'Update')."'
                class='submit'>";
         echo "</td></tr>";
      }
      echo "</table>";
      Html::closeForm();
   }
 */








}