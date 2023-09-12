<?php
/**
 * ---------------------------------------------------------------------
 * GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2015-2022 Teclib' and contributors.
 *
 * http://glpi-project.org
 *
 * based on GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2003-2014 by the INDEPNET Development Team.
 *
 * ---------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of GLPI.
 *
 * GLPI is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * GLPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 * ---------------------------------------------------------------------
 */

include ('../inc/includes.php');

Session::checkCentralAccess();

if (!isset($_REQUEST["action"])) {
   exit;
}

if ($_REQUEST["action"] == "get_events") {
   header("Content-Type: application/json; charset=UTF-8");
   echo json_encode(PluginPlanningPlanning::constructEventsArray($_REQUEST));
   exit;
}

if (($_POST["action"] ?? null) == "update_event_times") {
   echo PluginPlanningPlanning::updateEventTimes($_POST);
   exit;
}

if (($_POST["action"] ?? null) == "view_changed") {
   echo PluginPlanningPlanning::viewChanged($_POST['view']);
   exit;
}

if (($_POST["action"] ?? null) == "clone_event") {
   echo PluginPlanningPlanning::cloneEvent($_POST['event']);
   exit;
}

if (($_POST["action"] ?? null) == "delete_event") {
   echo PluginPlanningPlanning::deleteEvent($_POST['event']);
   exit;
}

if ($_REQUEST["action"] == "get_externalevent_template") {
   $key = 'planningexternaleventtemplates_id';
   if (isset($_POST[$key])
       && $_POST[$key] > 0) {
      $template = new PlanningExternalEventTemplate();
      $template->getFromDB($_POST[$key]);

      $template->fields = array_map('html_entity_decode', $template->fields);
      $template->fields['rrule'] = json_decode($template->fields['rrule'], true);
      header("Content-Type: application/json; charset=UTF-8");
      echo json_encode($template->fields, JSON_NUMERIC_CHECK);
      exit;
   }
}

Html::header_nocache();
header("Content-Type: text/html; charset=UTF-8");

if ($_REQUEST["action"] == "add_event_fromselect") {
   PluginPlanningPlanning::showAddEventForm($_REQUEST);
}

if ($_REQUEST["action"] == "add_event_sub_form") {
   PluginPlanningPlanning::showAddEventSubForm($_REQUEST);
}

if ($_REQUEST["action"] == "add_planning_form") {
   PluginPlanningPlanning::showAddPlanningForm();
}

if ($_REQUEST["action"] == "add_user_form") {
   PluginPlanningPlanning::showAddUserForm();
}

if ($_REQUEST["action"] == "add_group_users_form") {
   PluginPlanningPlanning::showAddGroupUsersForm();
}

if ($_REQUEST["action"] == "add_group_form") {
   PluginPlanningPlanning::showAddGroupForm();
}

if ($_REQUEST["action"] == "add_external_form") {
   PluginPlanningPlanning::showAddExternalForm();
}

if ($_REQUEST["action"] == "add_event_classic_form") {
   PluginPlanningPlanning::showAddEventClassicForm($_REQUEST);
}

if ($_REQUEST["action"] == "edit_event_form") {
   PluginPlanningPlanning::editEventForm($_REQUEST);
}

if ($_REQUEST["action"] == "get_filters_form") {
   PluginPlanningPlanning::showPlanningFilter();
}

if (($_POST["action"] ?? null) == "toggle_filter") {
   PluginPlanningPlanning::toggleFilter($_POST);
}

if (($_POST["action"] ?? null) == "color_filter") {
   PluginPlanningPlanning::colorFilter($_POST);
}

if (($_POST["action"] ?? null) == "delete_filter") {
   PluginPlanningPlanning::deleteFilter($_POST);
}

Html::ajaxFooter();
