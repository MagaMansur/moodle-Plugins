<?php
defined('MOODLE_INTERNAL') || die();

// Neues Modul hinzufügen
function roulette_add_instance($data, $mform = null) {
    global $DB;

    // Zeitstempel setzen
    $data->timemodified = time();

    return $DB->insert_record('roulette', $data);
}

function roulette_update_instance($data, $mform = null) {
    global $DB;

    $data->timemodified = time();
    $data->id = $data->instance;
    return $DB->update_record('roulette', $data);
}


// Modul löschen
function roulette_delete_instance($id) {
    global $DB;
    return $DB->delete_records('roulette', ['id' => $id]);
}

function roulette_supports() { return false; }