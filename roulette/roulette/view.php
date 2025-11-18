<?php
require_once('../../config.php'); // Moodle-Basis-Konfiguration laden
require_once('lib.php'); // Plugin-spezifische Funktionen laden

$id = required_param('id', PARAM_INT); // Kursmodul-ID aus URL-Parameter holen, zwingend erforderlich

// Kursmodul und Kontext laden
$cm = get_coursemodule_from_id('roulette', $id, 0, false, MUST_EXIST); // Kursmodul aus DB laden, sonst Fehler
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST); // Kursdaten holen
$roulette = $DB->get_record('roulette', ['id' => $cm->instance], '*', MUST_EXIST); // Plugin-Instanz holen

require_login($course, true, $cm); // Sicherstellen, dass der Benutzer angemeldet ist und Zugriff hat

$context = context_module::instance($cm->id); // Kontext für Berechtigungen holen

// Seite konfigurieren
$PAGE->set_url('/mod/roulette/view.php', ['id' => $cm->id]); // URL der Seite
$PAGE->set_title(format_string($roulette->name)); // Seitentitel setzen
$PAGE->set_heading(format_string($course->fullname)); // Überschrift setzen
$PAGE->set_context($context); // Kontext der Seite setzen

// Teilnehmer laden
$users = get_enrolled_users(
    $context, // Kontext, in dem Teilnehmer eingeschrieben sind
    '',       // Rollenfilter (leer = alle)
    0,        // Nur aktive Nutzer (0 = alle)
    'u.id, u.firstname, u.lastname, u.firstnamephonetic, u.lastnamephonetic, u.middlename, u.alternatename' // Felder
);

// Vollständige Namen der Teilnehmer erstellen
$names = array_map(function($u) {
    return fullname($u); // Moodle-Funktion für vollständigen Namen
}, $users);

// Teilnehmernamen als JSON für JavaScript vorbereiten
$namesjson = json_encode(array_values($names));

// JavaScript- und CSS-Dateien einbinden
$PAGE->requires->js(new moodle_url('/mod/roulette/js/winwheel.min.js')); // Winwheel Bibliothek für Rad
$PAGE->requires->js(new moodle_url('/mod/roulette/js/TweenMax.min.js')); // TweenMax für Animationen
$PAGE->requires->js(new moodle_url('/mod/roulette/js/roulette.js'));     // eigenes JS für das Roulette
$PAGE->requires->css(new moodle_url('/mod/roulette/styles.css'));        // eigenes CSS

// Header ausgeben
echo $OUTPUT->header();

// HTML für Roulette anzeigen
echo html_writer::tag('h3', 'Zufallsrad', ['class' => 'mb-3']); // Überschrift
echo html_writer::div('', 'roulette-container', ['id' => 'roulette-container']); // Container fürs Rad

// Button zum Drehen des Rads
echo html_writer::tag('button', 'Drehen', [
    'id' => 'spin-button',
    'class' => 'btn btn-primary mt-3'
]);

// Teilnehmernamen an JavaScript übergeben
echo "<script>var participants = $namesjson;</script>";

// Footer ausgeben
echo $OUTPUT->footer();
