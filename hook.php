<?php


/**
 * Install hook
 * 
 * @return boolean
 */
function plugin_djily_install() {
    //Do stuff like instanciating database, default values, ...
    global $DB;

    //Instanciate migration with version
    $migration = new Migration(100);

    //Create table only if it doesn't exist yet
    if(!$DB->tableExists("glpi_plugin_djily_configs")) {
        //Table creation query
        $query = "CREATE TABLE `glpi_plugin_djily_configs` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `solutionmandatory` tinyint(1) default '0',
            PRIMARY KEY  (`id`)
         ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
        $DB->queryOrDie($query, "erreur lors de la création de la table de configuration ".$DB->error());
        

        $query = "INSERT INTO `glpi_plugin_djily_configs`
                       (`id`, `solutionmandatory`)
                VALUES (NULL, '0')";
      $DB->queryOrDie($query,
                        "erreur lors de l'insertion des valeurs par défaut dans la table de configuration ".$DB->error());
    }



    // Création de la table uniquement lors de la première installation
    if (!$DB->tableExists("glpi_plugin_djily_profiles")) {

        // requete de création de la table    
        $query2 = "CREATE TABLE `glpi_plugin_djily_profiles` (
                    `id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_profiles (id)',
                    `right` char(1) collate utf8_unicode_ci default NULL,
                    PRIMARY KEY  (`id`)
                    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
        $DB->queryOrDie($query2, $DB->error());


        //creation du premier accès nécessaire lors de l'installation du plugin
        include_once(GLPI_ROOT."/plugins/djily/inc/profile.class.php");
        PluginDjilyProfile::createAdminAccess($_SESSION['glpiactiveprofile']['id']);


        $DB->query($query) or die($DB->error());
    }
    //Execute the whole migration
    $migration->executeMigration();

    return true;
}

/**
 * Uninstall hook
 * 
 * @return boolean
 */
function plugin_djily_uninstall() {
    //Do stuff like removing tables, generated files, ... 
    global $DB;

    $tables = [
        'configs',
        'profiles',
    ];

    foreach($tables as $table) {
        $tablename = 'glpi_plugin_djily_' . $table;
        //Create table only if it doesn't exist yet
        if($DB->tableExists($tablename)) {
            $DB->queryOrDie(
                "DROP TABLE `$tablename`",
                $DB->error()
            );
        }
    }

    return true;
}

