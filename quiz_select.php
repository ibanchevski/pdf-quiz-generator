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
    $selectedQuizID = $quizFormData->quizid;
    $quiz = $DB->get_record('quiz', array('id' => $selectedQuizID), 'id, name, course');
    echo "Selected quiz: $quiz->name ($selectedQuizID)\n";

    // Display quiz questions with answers
    $questionsWithAnswersQuery = 'select mdl_quiz_slots.id as slotid,slot,quizid,page,questionid, mdl_question.name as questionname, mdl_question_answers.answer as questionanswer from mdl_quiz_slots join mdl_question on mdl_question.id=questionid join mdl_question_answers on mdl_question_answers.question=questionid where quizid=2;';
    $questionsWithAnswers = $DB->get_records_sql($questionsWithAnswersQuery);
    var_dump($questionsWithAnswers);
    foreach($questionsWithAnswers as $question) {
        echo "<ul>";
        echo "<li>$question->questionname</li>";
        echo "<p>$question->questionanswer</p>";
        echo "</ul>";
    }

} else {
    $mform->display();
}

echo $OUTPUT->footer();