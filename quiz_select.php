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
require_once($CFG->dirroot . '/local/pdfquizgenerator/classes/form/quiz_select.php');

$PAGE->set_url(new moodle_url('/local/pdfquizgenerator/quiz_select.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Select questions from created quiz');

$mform = new quiz_select();

echo $OUTPUT->header();

if ($mform->is_cancelled()) {
    echo "Cancelled quiz form \n";
} else if ($quizFormData = $mform->get_data()) {
    // Get the selected quiz
    $selectedQuizId = $quizFormData->selectedQuizId;
    $selectedQuiz = $DB->get_record('quiz', array('id' => $selectedQuizId), 'id, name, course');

    echo "Selected quiz: $selectedQuiz->name ($selectedQuizId)\n";

    // Print the quiz questions with answers;
    $quizQuestions = $DB->get_records('quiz_slots', array('quizid' => $selectedQuizId), 'questionid', 'questionid');
    // var_dump($quizQuestions);

    $questionsAnswers = array();

    foreach($quizQuestions as $question) {
        $question = $DB->get_record('question', array('id' => $question->questionid), 'id, name, questiontext');
        $questionName = $question->questiontext;

        $questionAnswers = $DB->get_records('question_answers', array('question' => $question->id), 'id', 'id, answer');

        $questionsAnswers[$questionName] = $questionAnswers;
    }
} else {
    $mform->display();
}

echo $OUTPUT->footer();