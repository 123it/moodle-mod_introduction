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

$module->version   = 2011102402;              
$module->requires  = 2010112400;    		//Originally developed for Moodle 2.x  
$module->cron      = 0;               
$module->component = 'mod_introduction';
$module->maturity = MATURITY_ALPHA;      	// [MATURITY_STABLE | MATURITY_RC | MATURITY_BETA | MATURITY_ALPHA]
$module->release  = '0.0.1'; 

