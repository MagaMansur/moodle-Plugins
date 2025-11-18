<?php
require_once(__DIR__ . '/../../config.php');

$id = required_param('id', PARAM_INT); // Kurs-ID
$course = $DB->get_record('course', ['id' => $id], '*', MUST_EXIST);

require_login($course);

$PAGE->set_url('/mod/roulette/index.php', ['id' => $id]);
$PAGE->set_title('Roulette Activities');
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();
echo html_writer::tag('h2', 'Alle Roulette-Aktivitäten in diesem Kurs');
echo $OUTPUT->footer();
