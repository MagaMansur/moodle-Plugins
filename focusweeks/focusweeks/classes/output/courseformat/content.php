<?php
// Organisiert den Code so, dass er eindeutig zu diesem Moodle-Format gehört.
namespace format_focusweeks\output\courseformat;

//Sicherheitscheck: Stellt sicher, dass das Skript nur innerhalb von Moodle ausgeführt wird
defined('MOODLE_INTERNAL') || die();

// Import von Klassen:
use core_courseformat\output\local\content as content_base;
use renderer_base;


class content extends content_base { //eine neue Klasse content, die das Verhalten von content_base erbt.

    public function export_for_template(renderer_base $output): array { 
        // Diese Funktion wird von Moodle aufgerufen, wenn der Kursinhalt für das Template vorbereitet werden soll.


        $data = (array) parent::export_for_template($output);

        $format = $this->format;
        $course = $format->get_course();
        $modinfo = get_fast_modinfo($course);
        $sections = $modinfo->get_section_info_all();
        
        //$format aktuelles Kursformat
        //$course Kursobjekt
        //$modinfo schnelle Übersicht aller Module/Abschnitte im Kurs
        

        $weekseconds = WEEKSECS; // 604800 sekunden
        $currentweek = floor((time() - ($course->startdate)) / $weekseconds) + 1; 
        // floor() rundet

        $options = $this->format->get_format_options();
        $offset = $options['weekoffset']; 
        $currentweek -= $offset;

        $general = $older = $future = $current = [];

        foreach ($sections as $sectionnum => $section) {
            if (!$section->uservisible) continue;

            if ($sectionnum == 0) {
                $general[] = $section;
                continue;
            }

            if ($sectionnum == $currentweek) $current[] = $section;
            else if ($sectionnum < $currentweek) $older[] = $section;
            else if ($sectionnum > $currentweek) $future[] = $section;
        }

        // Reihenfolge:
        $sorted = array_merge($general, $current, $future, $older);

        $sectionclassname = \format_focusweeks\output\local\content\section::class;
        $sectionsdata = [];

        foreach ($sorted as $section) {
            $sectionclass = new $sectionclassname($this->format, $section);
            $sectionsdata[] = $sectionclass->export_for_template($output);
        }

        $data['sections'] = $sectionsdata;
        return $data;
    }
}
