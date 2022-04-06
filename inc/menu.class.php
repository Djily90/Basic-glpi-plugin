<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

/**
 * class plugin_treeview_preference
 * Load and store the preference configuration from the database
**/
class PluginDjilyDjily extends CommonDBTM {
    static function getMenuContent() {
        $menu          = [];
        $menu['title'] = __('Djily');
        $menu['page']  = '/' . Plugin::getWebDir('djily', false) . '/index.php';
        $menu['icon']  = 'fas fa-sitemap';
        return $menu;
   }

}