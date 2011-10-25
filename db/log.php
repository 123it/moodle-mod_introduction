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

global $DB;

$logs = array(
    array('module'=>'newmodule', 'action'=>'add', 'mtable'=>'newmodule', 'field'=>'name'),
    array('module'=>'newmodule', 'action'=>'update', 'mtable'=>'newmodule', 'field'=>'name'),
    array('module'=>'newmodule', 'action'=>'view', 'mtable'=>'newmodule', 'field'=>'name'),
    array('module'=>'newmodule', 'action'=>'view all', 'mtable'=>'newmodule', 'field'=>'name')
);
