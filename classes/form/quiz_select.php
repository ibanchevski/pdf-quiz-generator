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
 * @package   local_pdfquizgenerator
 * @copyright 2021, Ivaylo
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->libdir/formslib.php");

class quiz_select extends moodleform {
    public function definition() {
        global $DB;

        $mform = $this->_form;

        // TODO: Handle different coursers
        // A course should be selected before selecting quizes.
        // We should know from what course we are selecting a course.
        // $mform->addElement(
        //     'select',
        //     'quizid',
        //     'Select quiz',
        //     $DB->get_records('quiz', array(), 'id')
        // );

        $quizes = $DB->get_records('quiz', array(), 'id', 'id,name');
        $options = array();
        foreach ($quizes as $quiz) {
            $options[$quiz->id] = $quiz->name;
        }

        $mform->addElement('select', 'selectedQuizId', 'Select quiz', $options);

        $this->add_action_buttons(false);
    }
}