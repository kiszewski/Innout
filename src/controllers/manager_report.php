<?php
session_start();
requireValidateSession();

loadTeamplateView("manager_report", []);