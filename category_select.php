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

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/pdfquizgenerator/classes/form/category_select.php');

$PAGE->set_url(new moodle_url('/local/pdfquizgenerator/category_select.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Select question bank category');

$mform = new category_select();

echo $OUTPUT->header();

if ($mform->is_cancelled()) {
    echo "Form is cancelles \n";
} else if ($formdata = $mform->get_data()) {
    $selectedCategory = $formdata->categoryid;
    echo "You have selected category: $selectedCategory \n";

    $questions = $DB->get_records('question', array('category' => (int)$selectedCategory), 'id', 'id, name, category');

    echo "<ol>";
    foreach ($questions as $question) {
        echo "<li>" . $question->id . " - " . $question->name . "</li>";
        echo "<ul>";
        $question_answers = $DB->get_records('question_answers', array('question' => $question->id), 'id', 'id, answer');
        foreach ($question_answers as $answer) {
            echo "<li>" . $answer->answer . "</li>";
        }
        echo "</ul>";
    }
    echo "</ol>";
} else {
    $mform->display();
}


echo $OUTPUT->footer();
