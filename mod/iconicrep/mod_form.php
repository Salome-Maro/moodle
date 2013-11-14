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
 * The main iconicrep configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    iconicrep
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

include('layout.php');
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form
 */
class mod_iconicrep_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {

        $mform = $this->_form;

        //-------------------------------------------------------------------------------
        // Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('iconicrepname', 'iconicrep'), array('size'=>'64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'iconicrepname', 'iconicrep');

        // Adding the standard "intro" and "introformat" fields
        $this->add_intro_editor();

        ?>
                <style>
                <?php include 'iconicrep.css'; ?>
                </style>
        
        <?php
        	               
        //-------------------------------------------------------------------------------
        // Adding the rest of iconicrep settings, spreeading all them into this fieldset
        // or adding more fieldsets ('header' elements) if needed for better logic
        $mform->addElement('header', 'iconchoose', get_string('iconchoose', 'iconicrep'));
        
        $mform->addElement('html', '<ul class="choose-icons">');
        $mform->addElement('html','<li class="choose-icon assignment">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="assignment">');
        $mform->addElement('html','<label for="assignment"> Assignment </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon chat">');
        $mform->addElement('html', '<input type="checkbox" name="choose-icons" id="chat">');
        $mform->addElement('html','<label for="chat"> Chat </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon choice">');
        $mform->addElement('html', '<input type="checkbox" name="choose-icons" id="choice">');
        $mform->addElement('html','<label for="choice"> Choice </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon forum">');
        $mform->addElement('html', '<input type="checkbox" name="choose-icons" id="forum">');
        $mform->addElement('html','<label for="forum"> Forum </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon lesson">');
        $mform->addElement('html', '<input type="checkbox" name="choose-icons" id="lesson">');
        $mform->addElement('html','<label for="lesson"> Lesson </ label>');
        $mform->addElement('html','</ Li>');
        	
        
        $mform->addElement('html','<li class="choose-icon quiz">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="quiz">');
        $mform->addElement('html','<label for="quiz"> Quiz </ label>');
        $mform->addElement('html','</ Li>');
        	
        $mform->addElement('html','</ ul>');

        

        $mform->addElement('header', 'iconicrepfieldset', get_string('iconicrepfieldset', 'iconicrep'));
        $mform->addElement('static', 'label2', 'iconicrepsetting2', 'Your iconicrep fields go here. Replace me!');
  
      	
      	

        //-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        //-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();
    }
}

?>