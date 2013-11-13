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
 * Prints a particular instance of iconicrep
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_iconicrep
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$i  = optional_param('i', 0, PARAM_INT);  // iconicrep instance ID - it should be named as the first character of the module

if ($id) {
    $cm         = get_coursemodule_from_id('iconicrep', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $iconicrep  = $DB->get_record('iconicrep', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($i) {
    $iconicrep  = $DB->get_record('iconicrep', array('id' => $i), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $iconicrep->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('iconicrep', $iconicrep->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

add_to_log($course->id, 'iconicrep', 'view', "view.php?id={$cm->id}", $iconicrep->name, $cm->id);

/// Print the page header

$PAGE->set_url('/mod/iconicrep/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($iconicrep->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

// other things you may want to set - remove if not needed
//$PAGE->set_cacheable(false);
//$PAGE->set_focuscontrol('some-html-id');
//$PAGE->add_body_class('iconicrep-'.$somevar);

// Output starts here
echo $OUTPUT->header();

if ($iconicrep->intro) { // Conditions to show the intro can change to look for own settings or whatever
    echo $OUTPUT->box(format_module_intro('iconicrep', $iconicrep, $cm->id), 'generalbox mod_introbox', 'iconicrepintro');
}

// Replace the following lines with you own code
echo $OUTPUT->heading('Yay! It works!');

// Finish the page
echo $OUTPUT->footer();
