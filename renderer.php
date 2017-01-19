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
 * Renderer for local cas_help_links
 *
 * @package    local_cas_help_links
 * @copyright  2016, William C. Mazilly, Robert Russo
 * @copyright  2016, Louisiana State University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
//require_once $CFG->libdir.'/tablelib.php';
require_once $CFG->libdir.'/outputcomponents.php';
require_once($CFG->libdir.'/formslib.php');
require_once 'cas_links_form.php';

class local_cas_help_links_renderer extends plugin_renderer_base {

    public function cas_help_links($courseSettingsData,$categorySettingsData,$userSettingsData) {
        global $USER;
        $mform = new cas_form(null, array('courseSettingsData' => $courseSettingsData,'categorySettingsData' => $categorySettingsData,'userSettingsData' => $userSettingsData));

        $out = $mform->display();
        return $out;
    }
}