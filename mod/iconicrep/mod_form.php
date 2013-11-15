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
        
        $mform->addElement('html','<li class="choose-icon database">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="database">');
        $mform->addElement('html','<label for="database"> Database </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon externalTool">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="externalTool">');
        $mform->addElement('html','<label for="externalTool"> ExternalTool </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon glossary">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="glossary">');
        $mform->addElement('html','<label for="glossary"> Glossary </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon lesson">');
        $mform->addElement('html', '<input type="checkbox" name="choose-icons" id="lesson">');
        $mform->addElement('html','<label for="lesson"> Lesson </ label>');
        $mform->addElement('html','</ Li>');
        	       
        $mform->addElement('html','<li class="choose-icon quiz">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="quiz">');
        $mform->addElement('html','<label for="quiz"> Quiz </ label>');
        $mform->addElement('html','</ Li>');

        $mform->addElement('html','<li class="choose-icon scorm">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="scorm">');
        $mform->addElement('html','<label for="scorm"> Scorm </ label>');
        $mform->addElement('html','</ Li>');

        $mform->addElement('html','<li class="choose-icon survey">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="survey">');
        $mform->addElement('html','<label for="survey"> Survey </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon wiki">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="wiki">');
        $mform->addElement('html','<label for="wiki"> Wiki </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon workshop">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="workshop">');
        $mform->addElement('html','<label for="workshop"> Workshop </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon book">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="book">');
        $mform->addElement('html','<label for="book"> Book </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon file">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="file">');
        $mform->addElement('html','<label for="file"> File </ label>');
        $mform->addElement('html','</ Li>');
       
        $mform->addElement('html','<li class="choose-icon ims">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="ims">');
        $mform->addElement('html','<label for="ims"> IMS </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','<li class="choose-icon label">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="label">');
        $mform->addElement('html','<label for="label"> Label </ label>');
        $mform->addElement('html','</ Li>');
    
        $mform->addElement('html','<li class="choose-icon url">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="url">');
        $mform->addElement('html','<label for="url"> URL </ label>');
        $mform->addElement('html','</ Li>');

        $mform->addElement('html','<li class="choose-icon page1">');
        $mform->addElement('html','<input type="checkbox" name="choose-icons" id="page1">');
        $mform->addElement('html','<label for="page1"> Page </ label>');
        $mform->addElement('html','</ Li>');
        
        $mform->addElement('html','</ ul>');
   	
      
        //-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        //-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();
    }
}

?>