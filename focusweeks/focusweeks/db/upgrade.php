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
 * Upgrade scripts for course format "Weeks"
 *
 * @package    format_weeks
 * @copyright  2017 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade script for format_weeks
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
// This file is part of Moodle - http://moodle.org/

defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade script for the focusweeks course format
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool
 */
function xmldb_format_focusweeks_upgrade($oldversion) {
    global $DB;

    // Beispiel: bisher keine Änderungen, nur Version setzen
    if ($oldversion < 2025101600) {
        // Upgrade-Schritte hier einfügen, falls nötig

        // Standard-Upgrade: Version setzen
        upgrade_plugin_savepoint(true, 2025101600, 'format', 'focusweeks');
    }

    return true;
}

