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
 * Capability definitions.
 *
 * @package   block_course_recent
 * @copyright 2014 The Regents of the University of California
 * @copyright 2010 Remote Learner - http://www.remote-learner.net/
 * @author    Carson Tam <carson.tam@ucsf.edu>, Akin Delamarre <adelamarre@remote-learner.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'block/course_recent:myaddinstance' => [
    'captype' => 'write',
    'contextlevel' => CONTEXT_SYSTEM,
    'archetypes' => [
          'user' => CAP_ALLOW,
          ],

        'clonepermissionsfrom' => 'moodle/my:manageblocks',
    ],

    'block/course_recent:addinstance' => [
     'riskbitmask' => RISK_SPAM | RISK_XSS,

     'captype' => 'write',
     'contextlevel' => CONTEXT_BLOCK,
     'archetypes' => [
         'editingteacher' => CAP_ALLOW,
         'manager' => CAP_ALLOW,
         ],

     'clonepermissionsfrom' => 'moodle/site:manageblocks',
     ],

    'block/course_recent:changelimit' => [
     'captype' => 'write',
     'contextlevel' => CONTEXT_BLOCK,
     'archetypes' => [
         'user' => CAP_ALLOW,
         'student' => CAP_ALLOW,
         'teacher' => CAP_ALLOW,
         'editingteacher' => CAP_ALLOW,
         'manager' => CAP_ALLOW,
         ],
     ],

    'block/course_recent:showall' => [
     'captype' => 'read',
     'contextlevel' => CONTEXT_BLOCK,
     'archetypes' => [
         'manager' => CAP_ALLOW,
         ],
    ],
];
