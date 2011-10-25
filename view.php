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

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // introduction instance ID - it should be named as the first character of the module

if ($id) {
    $cm         = get_coursemodule_from_id('introduction', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $introduction  = $DB->get_record('introduction', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $introduction  = $DB->get_record('introduction', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $introduction->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('introduction', $introduction->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = get_context_instance(CONTEXT_MODULE, $cm->id);

add_to_log($course->id, 'introduction', 'view', "view.php?id={$cm->id}", $introduction->name, $cm->id);

/// Print the page header

$PAGE->set_url('/mod/introduction/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($introduction->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

// other things you may want to set - remove if not needed
//$PAGE->set_cacheable(false);
//$PAGE->set_focuscontrol('some-html-id');
//$PAGE->add_body_class('introduction-'.$somevar);

// Output starts here
echo $OUTPUT->header();

if ($introduction->intro) { // Conditions to show the intro can change to look for own settings or whatever
    echo $OUTPUT->box(format_module_intro('introduction', $introduction, $cm->id), 'generalbox mod_introbox', 'introductionintro');
}

// Replace the following lines with you own code
echo $OUTPUT->heading('Yay! It works!');

// Finish the page
echo $OUTPUT->footer();
