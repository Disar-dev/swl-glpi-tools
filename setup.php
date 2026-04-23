<?php
define('PLUGIN_SWLTOOLS_VERSION', '1.0.0');
//
function plugin_init_swltools() {
   global $PLUGIN_HOOKS;
   global $GLPI_CACHE;

   if (class_exists('Glpi\Content\ITemplateProvider')) {
   $PLUGIN_HOOKS['add_twig_path']['swltools'] = 'templates';

   }
   $PLUGIN_HOOKS['add_css']['swltools'] = 'css/style.css';
   $PLUGIN_HOOKS['add_javascript']['swltools'] = 'js/script.js';
   $PLUGIN_HOOKS['csrf_compliant']['swltools'] = true;
   $PLUGIN_HOOKS['display_login']['swltools'] = 'plugin_swltools_login';
}

function plugin_version_swltools() {
   return [
      'name'           => 'Swisslub Tools',
      'version'        => '1.0.0',
      'author'         => 'Diego Sarmiento',
      'license'        => 'GPLv2+',
      'minGlpiVersion' => '10.0'
   ];
}

function plugin_swltools_check_prerequisites() {
   return true;
}

function plugin_swltools_check_config() {
   return true;
}

function plugin_swltools_install() {
   global $DB;

   $migration = new Migration(100);
   if (!$DB->tableExists('glpi_plugin_swltools_configs')) {
      $query = "CREATE TABLE `glpi_plugin_swltools_configs` (
         `id` INT(11) NOT NULL AUTO_INCREMENT,
         `name` VARCHAR(255) NOT NULL,
         PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC";
      $DB->queryOrDie($query, $DB->error());
   }

   if ($DB->tableExists('glpi_plugin_swltools_configs')) {
      $migration->addField(
         'glpi_plugin_swltools_configs',
         'value',
         'string'
      );

      $migration->addKey(
         'glpi_plugin_swltools_configs',
         'name'
      );
   }
   $migration->executeMigration();
   return true;
}

function plugin_swltools_uninstall() {
   global $DB;

   $tables = [
      'configs'
   ];

   foreach ($tables as $table) {
      $tablename = 'glpi_plugin_swltools_' . $table;
      if ($DB->tableExists($tablename)) {
         $DB->queryOrDie(
            "DROP TABLE `$tablename`",
            $DB->error()   
         );
      }
   }
   return true;
}


?>

