<?php
namespace format_focusweeks\output\local\content;

defined('MOODLE_INTERNAL') || die();

use core_courseformat\output\local\content\section as section_base;
use renderer_base;
use stdClass;

/**
 * Custom section renderer for FocusWeeks.
 */
class section extends section_base {

    public function export_for_template(renderer_base $output): stdClass {
        $data = parent::export_for_template($output);

        /*
        // Entferne die Moodle-Standard-Markierung "current"
        if (isset($data->iscurrent)) {
            $data->iscurrent = false;
        }

        // Wenn du willst, kannst du auch das Label komplett löschen:
        if (isset($data->currentsection)) {
            unset($data->currentsection);
        }
        */
        


        return $data;
    }
}
