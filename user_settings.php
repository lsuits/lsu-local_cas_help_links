<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
 
/**
 * @package   local_cas_help_links
 * @copyright 2016, Louisiana State University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
// defined('MOODLE_INTERNAL') || die();

require_once('../../config.php');

$user_id = required_param('id', PARAM_INT);

$context = context_system::instance();

global $PAGE, $USER, $CFG;

$PAGE->set_url($CFG->wwwroot . '/local/cas_help_links/user_settings.php', ['user_id' => $user_id]);
$PAGE->set_context($context);

require_login();

// make sure that the user being referenced is the auth user
if ($USER->id != $user_id) {
    echo 'sorry, no';
    // redirect (SOME URL HERE); ??
    die;
}

//////////////////////////////////////////////////////////
/// 
/// HANDLE FORM SUBMISSION
/// 
//////////////////////////////////////////////////////////
if ($data = data_submitted() and confirm_sesskey()) {
    
    try {
        
        \local_cas_help_links_input_handler::handle_user_settings_input($data, $user_id);

    } catch (Exception $e) {
        
        var_dump($e);die; // @TODO: make this really do something, validation? errors?

    }

}

//////////////////////////////////////////////////////////
/// 
/// RENDER PAGE
///
/// (NOTE: it is assumed this is a primary instructor or site admin)
/// 
//////////////////////////////////////////////////////////

// get all data
$courseSettingsData = \local_cas_help_links_utility::get_primary_instructor_course_settings($user_id);

$categorySettingsData = \local_cas_help_links_utility::get_primary_instructor_category_settings($user_id);

$userSettingsData = \local_cas_help_links_utility::get_primary_instructor_user_settings($user_id);

// PAGE RENDERING STUFF
$PAGE->set_context($context);
$PAGE->requires->jquery();
$PAGE->requires->css(new moodle_url($CFG->wwwroot . "/local/cas_help_links/style.css"));
$PAGE->requires->css(new moodle_url($CFG->wwwroot . "/local/cas_help_links/vendor/styles/bootstrap-toggle.min.css"));
// $PAGE->requires->js(new moodle_url($CFG->wwwroot . "/local/cas_help_links/module.js"));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . "/local/cas_help_links/vendor/scripts/bootstrap-toggle.min.js"));

$output = $PAGE->get_renderer('local_cas_help_links');
echo $output->header();
echo $output->cas_help_links($courseSettingsData,$categorySettingsData,$userSettingsData);
echo $output->footer();