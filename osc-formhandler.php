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
        global $wpdb;

        $table_name = $wpdb->prefix . "OSC_Form_";

        $charset_collate = $wpdb->get_charset_collate();
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        $sql = "CREATE TABLE `" . $table_name . "contact` (
	`kontaktID` INT NOT NULL AUTO_INCREMENT,
	`mobile` VARCHAR(32),
	`telephone` VARCHAR(32),
	`email` VARCHAR(32) ,
	PRIMARY KEY (`kontaktID`)
    );";

        dbDelta($sql);
        $sql = "CREATE TABLE `" . $table_name . "submits` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`kontaktInfoID` BINARY NOT NULL,
	`peopleID` BINARY NOT NULL,
	`adresseID` BINARY NOT NULL,
	`statusID` BINARY NOT NULL,
	PRIMARY KEY (`id`)
);";
        dbDelta($sql);
        $sql = "CREATE TABLE `" . $table_name . "people` (
	`navnID` INT NOT NULL AUTO_INCREMENT,
	`parentName` VARCHAR(32) NOT NULL,
	`childName` VARCHAR(32) NOT NULL,
	`childAge` INT(32) NOT NULL,
	`comment` TEXT(264) NOT NULL,
	PRIMARY KEY (`navnID`)
);";
        dbDelta($sql);
        $sql = "CREATE TABLE `" . $table_name . "adresser` (
	`addressID` INT NOT NULL AUTO_INCREMENT,
	`address` VARCHAR(256) NOT NULL,
	PRIMARY KEY (`addressID`)
);";
        dbDelta($sql);
        $sql = "CREATE TABLE `" . $table_name . "status` (
	`statusID` INT NOT NULL AUTO_INCREMENT,
	`status` VARCHAR(256) NOT NULL,
	PRIMARY KEY (`statusID`)
);";
        dbDelta($sql);
        $sql = "ALTER TABLE `" . $table_name . "submits` ADD CONSTRAINT `" . $table_name . "submits_fk0` FOREIGN KEY (`kontaktInfoID`) REFERENCES `" . $table_name . "contact`(`kontaktID`);";
        dbDelta($sql);
        $sql = "ALTER TABLE `" . $table_name . "submits` ADD CONSTRAINT `" . $table_name . "submits_fk1` FOREIGN KEY (`peopleID`) REFERENCES `" . $table_name . "people`(`navnID`);";
        dbDelta($sql);
        $sql = "ALTER TABLE `" . $table_name . "submits` ADD CONSTRAINT `" . $table_name . "submits_fk2` FOREIGN KEY (`adresseID`) REFERENCES `" . $table_name . "adresser`(`addressID`);";
        dbDelta($sql);
        $sql = "ALTER TABLE `" . $table_name . "submits` ADD CONSTRAINT `" . $table_name . "submits_fk3` FOREIGN KEY (`statusID`) REFERENCES `" . $table_name . "status`(`statusID`);";
        dbDelta($sql);

    }

    function deactive()
    {

    }

    function uninstall()
    {

    }

    function addForm()
    {
        if (isset($_GET['elementor-preview']))
        {
            echo "ELEMENTOR PREVIEW IS BROKEN";
        }
        else
        {
            echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/osc-formhandler/theForm.html");
        }
    }

    function handleDataPost()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "OSC_Form_";
        
        
        //########## wpdb->insert har indbygget escaping, så længe vi selv definere data type i det andet array man ser. Derfor kan vi direkte bruge 
        $wpdb->insert($table_name . 'people', array(
            'parentName' => $_POST['parentName'],
            'childName' => $_POST['BarnNavn'],
            'childAge' => $_POST['barnAlder'],
            'comment' => $_POST['kommentar']
        ) , array(
            '%s',
            '%s',
            '%d',
            '%s'
        ));
        //########## gem id fra den sql vi lige har indstat
        $thePeopleID = $wpdb->insert_id;

        $wpdb->insert($table_name . 'adresser', array(
            'address' => $_POST['adresse']
        ) , array(
            '%s'
        ));
        //########## gem id fra den sql vi lige har indstat
        $adresseID = $wpdb->insert_id;

        $wpdb->insert($table_name . 'contact', array(
            'mobile' => $_POST['mobile'],
            'telephone' => $_POST['telefon'],
            'email' => $_POST['email']
        ) , array(
            '%s',
            '%s',
            '%s'
        ));
        //########## gem id fra den sql vi lige har indstat
        $contactID = $wpdb->insert_id;
        //########## indsæt id'er til den samlet tabel.
        $wpdb->insert($table_name . 'submits', array(
            'kontaktInfoID' => $contactID,
            'peopleID' => $thePeopleID,
            'adresseID' => $adresseID,
            'statusID' => 1,
        ) , array(
            '%d',
            '%d',
            '%d',
            '%d'
        ));
        //########## Herunder kommer vores HTML på "complete" siden. Burde nok rykkes til endnu et dokument.
        ?>
				<section class="elementor-element elementor-element-3dfdee2 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-inner-section" data-id="3dfdee2" data-element_type="section">
						<div class="elementor-container elementor-column-gap-no">
				<div class="elementor-row">
				<div class="elementor-element elementor-element-a736ce9 elementor-column elementor-col-50 elementor-inner-column" data-id="a736ce9" data-element_type="column">
			<div class="elementor-column-wrap  elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div class="elementor-element elementor-element-9f79d40 elementor-widget elementor-widget-heading" data-id="9f79d40" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Sådan! Det var det!:</h2>		</div>
				</div>
						</div>
			</div>
		</div>
				<div class="elementor-element elementor-element-481160e elementor-column elementor-col-50 elementor-inner-column" data-id="481160e" data-element_type="column">
			<div class="elementor-column-wrap  elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div class="elementor-element elementor-element-0d733fb elementor-widget elementor-widget-heading" data-id="0d733fb" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Trin 4 - 4</h2>		</div>
				</div>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
				<div class="elementor-element elementor-element-d765252 elementor-widget elementor-widget-divider" data-id="d765252" data-element_type="widget" data-widget_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
				</div>
				</div>
				<div class="elementor-element elementor-element-155e4d6 elementor-widget elementor-widget-heading" data-id="155e4d6" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Mange tak for din tilmelding! Vi kontakter dig snarest muligt!</h2>		</div>
				</div>
				<div class="elementor-element elementor-element-ca9b9ca elementor-align-center elementor-widget elementor-widget-button" data-id="ca9b9ca" data-element_type="widget" data-widget_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="/" class="elementor-button-link elementor-button elementor-size-md" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">Tilbage til forsiden</span>
		</span>
					</a>
		</div>
				</div>
				</div>

        <?php
    }

    function osc_shortcode()
    {   //########## Hvis vi har data som skal i databasen, så kør funktionen
        if (isset($_POST['parentName']))
        {
            $this->handleDataPost();
        }
        //########## ellers smider vi vores form ind
        else
        {
            $this->addForm();
        }

    }
    function osc_adminpanel()
    {   //########## Har man ikke permission, så wp_die vi her, sådan de ikke kan se noget info.
        if (!current_user_can('manage_options'))
        {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        //########## Her starter vi på html til admin side.
        echo '<div class="wrap">';
        echo "<h1>OSC Tilmeldinger</h1>";
        echo '</div>';
        require ($_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/osc-formhandler/adminPage.php");

    }

}
if (class_exists('osc_formhandler'))
{
    $oscformhandler = new osc_formhandler();
}
//########## Tilføj shortcode, og call vores object funktion
function addOSCFormHandlerUniqueFunctionName()
{
    $oscform = new osc_formhandler();
    $oscform->osc_shortcode();
}

add_shortcode('osc_contact_form', 'addOSCFormHandlerUniqueFunctionName');

//########## Tilføj en admin menu, og call vores object funktion
function addOSCFormHandlerUniqueAdminPanelName()
{
    $oscformhandler = new osc_formhandler();
    $oscformhandler->osc_adminpanel();
}
add_action('admin_menu', 'OSC_plugin_menu');

function OSC_plugin_menu()
{
    add_menu_page('OSC Tilmeldinger', 'OSC Tilmeldinger', 'manage_options', 'osc-tilmeldinger', 'addOSCFormHandlerUniqueAdminPanelName', 'dashicons-email-alt');
}

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

