<?php 
/**
 * Introduction is a Moodle Activity Module designed to simplify that common first assignment for student introductions. 
 *
 * Author:
 *      Jesus Federico (jesus [at] 123it [dt] ca)
 *
 * @package		mod
 * @subpackage	introduction
 * @copyright	2011 123IT Consulting, http://www.123it.ca/
 * @license		http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once('locallib.php');

/**
 * Module instance settings form
 */
class mod_introduction_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {

        $mform = $this->_form;
        $current_activity =& $this->current;

        //-------------------------------------------------------------------------------
        // Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('config_activityname', 'introduction'), array('size'=>'64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'config_activityname', 'introduction');

        // Adding the standard "intro" and "introformat" fields
        //$this->add_intro_editor();

        //-------------------------------------------------------------------------------
        // Adding the rest of introduction settings
        $mform->addElement('header', 'config_assignmentdirections', get_string('config_assignmentdirections', 'introduction'));

        if ( !isset($current_activity->add) ){ 
	        $mform->addElement('textarea', 'requirement1', get_string('config_requirement','introduction').' 1', 'wrap="virtual" rows="5" cols="60"');
			$mform->addElement('button', 'addrequirement', get_string('config_addrequirement_button','introduction'));
		} else {
	        $mform->addElement('textarea', 'requirement1', get_string('config_requirement','introduction'), 'wrap="virtual" rows="5" cols="60"');
            $mform->addElement('static', 'label1', '',  get_string('config_addrequirement_warning', 'introduction'));
		}


        //-------------------------------------------------------------------------------
        // Third block starts here
        //-------------------------------------------------------------------------------
        if ( $current_activity->section > 0 ) {  //This is not a general activity, it is part of a week, so it can have schedule 
            $mform->addElement('header', 'general', get_string('config_block_schedule', 'bigbluebuttonbn'));

            $mform->addElement('date_time_selector', 'timeavailable', get_string('config_field_availabledate', 'bigbluebuttonbn'), array('optional'=>true));
            $mform->setDefault('timeavailable', time());
            $mform->addElement('date_time_selector', 'timedue', get_string('config_field_duedate', 'bigbluebuttonbn'), array('optional' => true));
            $mform->setDefault('timedue', time()+3600);
          
        }
        //-------------------------------------------------------------------------------
        // Third block ends here
        //-------------------------------------------------------------------------------

        //-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        //-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();
    }
}
