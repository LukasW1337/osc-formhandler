<?php
/*
 * @package OSCFormHandler
 */
/*
Plugin Name: OSC Form handler
Plugin URI: http://osc.wiwihosting.dk
Description: Form handler for OSC website. This handels form and submit.
Version: 0.0.1
Author: Lukas Wiinholt
Author URI: http://lukasw.dk
License: GPLv2 or later
Text Domain: osc-formhandler
*/

//ABSPATH er kun tilgængelig når Wordpress bruger filen. Derfor hvis en person prøver at få direkte adgang til filen udenom Wordpress - slå funktionen ihjel.
defined('ABSPATH') or die('I\'m sorry Dave, I\'m afraid I can\'t do that');

class osc_formhandler
{
    function activate()
    {
        /*global $wpdb;
        
        $table_name = $wpdb->prefix . "oscformsubmits"; 
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name tinytext NOT NULL,
        text text NOT NULL,
        url varchar(55) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        
        */
    }
    
    function deactive()
    {
        
    }
    
    function uninstall()
    {
        
    }
    
    function addForm()
    {
        if(isset($_GET['elementor-preview'])){
            echo "ELEMENTOR PREVIEW IS BROKEN";
        }else {   
        echo file_get_contents ($_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/osc-formhandler/theForm.html");
        }
    }
    
    function osc_shortcode()
    {
        
        $this->addForm();
        
    }
    
}
if (class_exists('osc_formhandler')) {
    $oscformhandler = new osc_formhandler();
}
function addOSCFormHandlerUniqueFunctionName()
{
    $oscform = new osc_formhandler();
    $oscform->osc_shortcode();
}

add_shortcode('osc_contact_form', 'addOSCFormHandlerUniqueFunctionName');

// activate
register_activation_hook(__FILE__, array(
    $oscformhandler,
    'activate'
));

// deactivate
register_deactivation_hook(__FILE__, array(
    $oscformhandler,
    'deactive'
));

// uninstall