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
 * Database upgrade script.
 *
 * @package   block_course_recent
 * @copyright 2014 The Regents of the University of California
 * @copyright 2010 Remote Learner - http://www.remote-learner.net/
 * @author    Carson Tam <carson.tam@ucsf.edu>, Justin Filip <jfilip@remote-learner.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrades this plugin's schema from a given older plugin version.
 *
 * @param int $oldversion The old plugin version.
 * @return bool TRUE if success, FALSE otherwise.
 * @throws ddl_exception
 * @throws ddl_field_missing_exception
 * @throws ddl_table_missing_exception
 * @throws dml_exception
 */
function xmldb_block_course_recent_upgrade($oldversion = 0): bool {
    global $CFG, $THEME, $DB;

    $result = true;

    if ($result && $oldversion < 2010071300) {
        // Look for any duplicate records for a user and let's take the first one created to keep and delete the rest.
        if ($rs = $DB->get_recordset('block_course_recent', null, 'userid ASC, id ASC', 'id, userid')) {
            $curuserid = 0;
            $deleteids = [];

            foreach ($rs as $record) {
                if ($record->userid != $curuserid) {
                    $curuserid = $record->userid;
                } else {
                    $deleteids[] = $record->id;
                }
            }

            $rs->close();

            if (!empty($deleteids)) {
                if (count($deleteids) > 1) {
                    $result = $result && $DB->delete_records_select(
                        'block_course_recent',
                        'id IN (' . implode(', ', $deleteids) . ')'
                    );
                } else {
                    $result = $result && $DB->delete_records('block_course_recent', ['id' => current($deleteids)]);
                }
            }
        }

        // Now we remove the 'blockid' field from the table.
        $table = new XMLDBTable('block_course_recent');
        $field = new XMLDBField('blockid');
        $index = new XMLDBIndex('blockid');

        $dbman = $DB->get_manager();
        $result = $result && $dbman->drop_field($table, $field);
        $result = $result && $dbman->drop_index($table, $index);
    }

    return $result;
}
