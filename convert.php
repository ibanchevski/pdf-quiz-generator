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
$PAGE->set_url(new moodle_url('/local/pdfquizgenerator/convert.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Convert tests to PDF');

echo $OUTPUT->header();

// Get all questions
$questions = $DB->get_records('question', $conditions=null, $sort='id', 'id,name,category');
$parsedQuestions = array();

foreach($questions as $question) {
    var_dump($question);
    
    // Create object
    $parsedQuestions[] = (object)[
        'id' => $question->id,
        'name' => $question->name,
        'category' => $question->category
    ];
}
var_dump($parsedQuestions);

$templatecontext = (object)[
    'texttodisplay' => 'A test text to display.',
    'questions' => $parsedQuestions
];

echo $OUTPUT->render_from_template('local_pdfquizgenerator/convert', $templatecontext);

echo $OUTPUT->footer();
