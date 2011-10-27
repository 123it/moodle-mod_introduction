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
require_once($CFG->dirroot.'/calendar/lib.php');

/** example constant */
//define('introduction_ULTIMATE_ANSWER', 42);

////////////////////////////////////////////////////////////////////////////////
// Moodle core API                                                            //
////////////////////////////////////////////////////////////////////////////////

/**
 * Returns the information on whether the module supports a feature
 *
 * @see plugin_supports() in lib/moodlelib.php
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed true if the feature is supported, null if unknown
 */
function introduction_supports($feature) {
    switch($feature) {
        case FEATURE_IDNUMBER:                return true;
        case FEATURE_GROUPS:                  return true;
        case FEATURE_GROUPINGS:               return false;
        case FEATURE_GROUPMEMBERSONLY:        return false;
        case FEATURE_MOD_INTRO:               return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return true;
        case FEATURE_GRADE_HAS_GRADE:         return false;
        case FEATURE_GRADE_OUTCOMES:          return false;
        // case FEATURE_MOD_ARCHETYPE:           return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_BACKUP_MOODLE2:          return true;

        default: return null;
    }
}

/**
 * Saves a new instance of the introduction into the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $introduction An object from the form in mod_form.php
 * @param mod_introduction_mod_form $mform
 * @return int The id of the newly inserted introduction record
 */
function introduction_add_instance(stdClass $introduction, mod_introduction_mod_form $mform = null) {
    global $DB;

    $introduction->timecreated = time();

	$introduction->key = introduction_rand_string( 16 );

    $returnid = $DB->insert_record('introduction', $introduction);
    
    if ($bigbluebuttonbn->timeavailable ){
        $event = NULL;
        $event->name        = $bigbluebuttonbn->name;
        $event->description = format_module_intro('bigbluebuttonbn', $bigbluebuttonbn, $bigbluebuttonbn->coursemodule);
        $event->courseid    = $bigbluebuttonbn->course;
        $event->groupid     = 0;
        $event->userid      = 0;
        $event->modulename  = 'bigbluebuttonbn';
        $event->instance    = $returnid;
        $event->timestart   = $bigbluebuttonbn->timeavailable;

        if ( $bigbluebuttonbn->timedue ){
            $event->timeduration = $bigbluebuttonbn->timedue - $bigbluebuttonbn->timeavailable;
        } else {
            $event->timeduration = 0;
        }
        
        calendar_event::create($event);
    }
    
    return $returnid;
    
}

/**
 * Updates an instance of the introduction in the database
 *
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param object $introduction An object from the form in mod_form.php
 * @param mod_introduction_mod_form $mform
 * @return boolean Success/Fail
 */
function introduction_update_instance(stdClass $introduction, mod_introduction_mod_form $mform = null) {
    global $DB;

    $introduction->timemodified = time();
    $introduction->id = $introduction->instance;

    # You may have to add extra stuff in here #

    return $DB->update_record('introduction', $introduction);
}

/**
 * Removes an instance of the introduction from the database
 *
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function introduction_delete_instance($id) {
    global $DB;

    if (! $introduction = $DB->get_record('introduction', array('id' => $id))) {
        return false;
    }

    # Delete any dependent records here #

    $DB->delete_records('introduction', array('id' => $introduction->id));

    return true;
}

/**
 * Returns a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @return stdClass|null
 */
function introduction_user_outline($course, $user, $mod, $introduction) {

    $return = new stdClass();
    $return->time = 0;
    $return->info = '';
    return $return;
}

/**
 * Prints a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @return string HTML
 */
function introduction_user_complete($course, $user, $mod, $introduction) {
    return '';
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in introduction activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @return boolean
 */
function introduction_print_recent_activity($course, $viewfullnames, $timestart) {
    return false;  //  True if anything was printed, otherwise false
}

/**
 * Returns all activity in introductions since a given time
 *
 * @param array $activities sequentially indexed array of objects
 * @param int $index
 * @param int $timestart
 * @param int $courseid
 * @param int $cmid
 * @param int $userid defaults to 0
 * @param int $groupid defaults to 0
 * @return void adds items into $activities and increases $index
 */
function introduction_get_recent_mod_activity(&$activities, &$index, $timestart, $courseid, $cmid, $userid=0, $groupid=0) {
}

/**
 * Prints single activity item prepared by {@see introduction_get_recent_mod_activity()}

 * @return void
 */
function introduction_print_recent_mod_activity($activity, $courseid, $detail, $modnames, $viewfullnames) {
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @return boolean
 * @todo Finish documenting this function
 **/
function introduction_cron () {
    return true;
}

/**
 * Returns an array of users who are participanting in this introduction
 *
 * Must return an array of users who are participants for a given instance
 * of introduction. Must include every user involved in the instance,
 * independient of his role (student, teacher, admin...). The returned
 * objects must contain at least id property.
 * See other modules as example.
 *
 * @param int $introductionid ID of an instance of this module
 * @return boolean|array false if no participants, array of objects otherwise
 */
function introduction_get_participants($introductionid) {
    return false;
}

/**
 * Returns all other caps used in the module
 *
 * @example return array('moodle/site:accessallgroups');
 * @return array
 */
function introduction_get_extra_capabilities() {
    return array();
}

////////////////////////////////////////////////////////////////////////////////
// Gradebook API                                                              //
////////////////////////////////////////////////////////////////////////////////

/**
 * Is a given scale used by the instance of introduction?
 *
 * This function returns if a scale is being used by one introduction
 * if it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $introductionid ID of an instance of this module
 * @return bool true if the scale is used by the given introduction instance
 */
function introduction_scale_used($introductionid, $scaleid) {
    global $DB;

    /** @example */
    if ($scaleid and $DB->record_exists('introduction', array('id' => $introductionid, 'grade' => -$scaleid))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Checks if scale is being used by any instance of introduction.
 *
 * This is used to find out if scale used anywhere.
 *
 * @param $scaleid int
 * @return boolean true if the scale is used by any introduction instance
 */
function introduction_scale_used_anywhere($scaleid) {
    global $DB;

    /** @example */
    if ($scaleid and $DB->record_exists('introduction', array('grade' => -$scaleid))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Creates or updates grade item for the give introduction instance
 *
 * Needed by grade_update_mod_grades() in lib/gradelib.php
 *
 * @param stdClass $introduction instance object with extra cmidnumber and modname property
 * @return void
 */
function introduction_grade_item_update(stdClass $introduction) {
    global $CFG;
    require_once($CFG->libdir.'/gradelib.php');

    /** @example */
    $item = array();
    $item['itemname'] = clean_param($introduction->name, PARAM_NOTAGS);
    $item['gradetype'] = GRADE_TYPE_VALUE;
    $item['grademax']  = $introduction->grade;
    $item['grademin']  = 0;

    grade_update('mod/introduction', $introduction->course, 'mod', 'introduction', $introduction->id, 0, null, $item);
}

/**
 * Update introduction grades in the gradebook
 *
 * Needed by grade_update_mod_grades() in lib/gradelib.php
 *
 * @param stdClass $introduction instance object with extra cmidnumber and modname property
 * @param int $userid update grade of specific user only, 0 means all participants
 * @return void
 */
function introduction_update_grades(stdClass $introduction, $userid = 0) {
    global $CFG, $DB;
    require_once($CFG->libdir.'/gradelib.php');

    /** @example */
    $grades = array(); // populate array of grade objects indexed by userid

    grade_update('mod/introduction', $introduction->course, 'mod', 'introduction', $introduction->id, 0, $grades);
}

////////////////////////////////////////////////////////////////////////////////
// File API                                                                   //
////////////////////////////////////////////////////////////////////////////////

/**
 * Returns the lists of all browsable file areas within the given module context
 *
 * The file area 'intro' for the activity introduction field is added automatically
 * by {@link file_browser::get_file_info_context_module()}
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @return array of [(string)filearea] => (string)description
 */
function introduction_get_file_areas($course, $cm, $context) {
    return array();
}

/**
 * Serves the files from the introduction file areas
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @return void this should never return to the caller
 */
function introduction_pluginfile($course, $cm, $context, $filearea, array $args, $forcedownload) {
    global $DB, $CFG;

    if ($context->contextlevel != CONTEXT_MODULE) {
        send_file_not_found();
    }

    require_login($course, true, $cm);

    send_file_not_found();
}

////////////////////////////////////////////////////////////////////////////////
// Navigation API                                                             //
////////////////////////////////////////////////////////////////////////////////

/**
 * Extends the global navigation tree by adding introduction nodes if there is a relevant content
 *
 * This can be called by an AJAX request so do not rely on $PAGE as it might not be set up properly.
 *
 * @param navigation_node $navref An object representing the navigation tree node of the introduction module instance
 * @param stdClass $course
 * @param stdClass $module
 * @param cm_info $cm
 */
function introduction_extend_navigation(navigation_node $navref, stdclass $course, stdclass $module, cm_info $cm) {
}

/**
 * Extends the settings navigation with the introduction settings
 *
 * This function is called when the context for the page is a introduction module. This is not called by AJAX
 * so it is safe to rely on the $PAGE.
 *
 * @param settings_navigation $settingsnav {@link settings_navigation}
 * @param navigation_node $introductionnode {@link navigation_node}
 */
function introduction_extend_settings_navigation(settings_navigation $settingsnav, navigation_node $introductionnode=null) {
}
