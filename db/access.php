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

$capabilities = array(

/***************************** remove these comment marks and modify the code as needed
    'mod/introduction:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
            'guest' => CAP_ALLOW,
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'admin' => CAP_ALLOW
        )
    ),

    'mod/introduction:submit' => array(
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
            'student' => CAP_ALLOW
        )
    ),
******************************/
);

