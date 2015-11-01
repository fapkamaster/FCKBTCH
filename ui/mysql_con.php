<?php

$con = mysqli_connect("server", "user", "password") or die ("Keine Verbindung zur Datenbank.");
mysqli_select_db($con, "eule") or die ("Die Datenbank existiert nicht.");

@array_map('mysqli_real_escape_string', $_GET);
@array_map('mysqli_real_escape_string', $_POST);
@array_map('mysqli_real_escape_string', $_REQUEST);
@array_map('mysqli_real_escape_string', $_COOKIE);
@array_map('mysqli_real_escape_string', $_SERVER);

mysqli_query($con, "SET NAMES SET 'utf8'");
mysqli_query($con, "SET character_set_client = 'utf8'");
mysqli_query($con, "SET character_set_connection = 'utf8'");
mysqli_query($con, "SET character_set_results = 'utf8'");



?>