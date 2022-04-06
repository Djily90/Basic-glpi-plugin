<?php

/**
 * Init the hooks of the plugin - Needed
 * 
 * @return void
 */
function plugin_init_djily() {
        // déclarer les variables globales dont on a besoin 
        global $PLUGIN_HOOKS;

        //required!
        //Un plugin CSRF_COMPLIANT est un plugin qui contient des formulaires fermés avec Html::closeForm() et qui ne passe aucune variable de type GET
        $PLUGIN_HOOKS['csrf_compliant']['djily'] = true;

        // PluginDjilyConfig est le nom de la class
        //Plugin::registerClass('PluginDjilyConfig'); 
        if (Session::haveRight('config', UPDATE)) {
         $PLUGIN_HOOKS['config_page']['djily'] = 'front/config.form.php';
        }
        
        // Class profil: droit, new user, cfreer form des droits
        Plugin::registerClass('PluginDjilyProfile');
        // Gérer les droits dans les profils du coeur 
        Plugin::registerClass('PluginDjilyProfile', array('addtabon' => array('Profile')));
        // Fonction pour changer mon profil
        $PLUGIN_HOOKS['change_profile']['djily'] = array('PluginDjilyProfile','changeProfile');
        
        $PLUGIN_HOOKS['menu_toadd']['djily']['tools'] = 'PluginDjilyDjily';

}


/**
* Get the name and the version of the plugin - Needed
*/
function plugin_version_djily() {
return array('name'           => "Plugin Djily",
                'version'        => '1.0.0',
                'author'         => 'Djily SARR',
                'license'        => 'GPLv2+',
                'homepage'       => '',
                'minGlpiVersion' => '9.5.7'
              );
}




/**
 * Check if the prerequisites of the plugin are satisfied - Needed
 */
function plugin_djily_check_prerequisites() {
 
    // Check that the GLPI version is compatible
    if (version_compare(GLPI_VERSION, '9.5.7', 'lt')) {
        echo "This plugin Requires GLPI >= 9.5.7";
        return false;
    }
 
    return true;
}


/**
 *  Check if the config is ok - Needed
 */
function plugin_djily_check_config() {
    return true;
}
 