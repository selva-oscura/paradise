<?php
///////////////////////////////////////////////////
// PPAGES ~ centerkey.com/ppages                 //
// GPLv3 ~ Copyright (c) individual contributors //
///////////////////////////////////////////////////

// Library
// Constants and general utilities

$version =    "v0.0.5";
$dataFolder = "../data";

date_default_timezone_set("UTC");

function getProperty($map, $key) {
   return is_array($map) && isset($map[$key]) ? $map[$key] :
      (is_object($map) && isset($map->{$key}) ? $map->{$key} : null);
   }

function appClientData() {
   $data = array(
      "version" =>         $version,
      "user-list-empty" => empty(readAccountsDb()->users)
      );
   return json_encode($data);
   }

function readDb($dbFilename) {
   $dbStr = file_get_contents($dbFilename);
   if ($dbStr === false)
      exit("Error reading database: {$dbFilename}");
   return json_decode($dbStr);
   }

function saveDb($dbFilename, $db) {
   if (!file_put_contents($dbFilename, json_encode($db)))
      exit("Error saving database: {$dbFilename}");
   return $db;
   }

function readGalleryDb() {
   global $galleryDbFile;
   return readDb($galleryDbFile);
   }

function saveGalleryDb($db) {
   global $galleryDbFile;
   return saveDb($galleryDbFile, $db);
   }

function readPortfolioDb() {
   global $portfolioFolder;
   $portfolioDb = array_map("readDb", glob("{$portfolioFolder}/*-db.json"));
   usort($portfolioDb, function($a, $b) { return $a->sort < $b->sort ? -1 : 1; });
   return $portfolioDb;
   }

function readPortfolioImageDb($id) {
   global $portfolioFolder;
   $dbFilename = "{$portfolioFolder}/{$id}-db.json";
   logEvent("readPortfolioImageDb", $dbFilename);
   return is_file($dbFilename) ? readDb($dbFilename, $db) : false;
   }

function savePortfolioImageDb($db) {
   global $portfolioFolder;
   logEvent("{$portfolioFolder}/{$db->id}-db.json", $db);
   return saveDb("{$portfolioFolder}/{$db->id}-db.json", $db);
   }

function readSettingsDb() {
   global $settingsDbFile;
   return readDb($settingsDbFile);
   }

function saveSettingsDb($db) {
   global $settingsDbFile;
   return saveDb($settingsDbFile, $db);
   }

function readAccountsDb() {
   global $accountsDbFile;
   return readDb($accountsDbFile);
   }

function saveAccountsDb($db) {
   global $accountsDbFile;
   logEvent("save-accounts-db", count($db->users), count($db->invites));
   return saveDb($accountsDbFile, $db);
   }

function displayTrue($imageDb) { return $imageDb->display; }
function convert($imageDb) {
   return array(
      "id" =>          $imageDb->id,
      "caption" =>     $imageDb->caption,
      "description" => $imageDb->description,
      "badge" =>       $imageDb->badge
      );
   }
function generateGalleryDb() {
   return saveGalleryDb(array_map("convert", array_values(
      array_filter(readPortfolioDb(), "displayTrue"))));
   }

function formatMsg($msg) {
   return is_null($msg) ? "[null]" : ($msg === true ? "[true]" : ($msg === false ? "[false]" :
      (empty($msg) ? "[empty]" : (is_object($msg) || is_array($msg) ? json_encode($msg) : $msg))));
   }

function logEvent() {  //any number of parameters to log
   global $installKey, $dataFolder;
   $delimiter = " | ";
   $logFilename =     "{$dataFolder}/log-{$installKey}.txt";
   $archiveFilename = "{$dataFolder}/log-archive-{$installKey}.txt";
   $milliseconds = substr(explode(" ", microtime())[0], 1, 4);
   $event = array(date("Y-m-d H:i:s"), $milliseconds, $delimiter, formatMsg($_SESSION["user"]));
   foreach (func_get_args() as $msg) {
      $event[] = $delimiter;
      $event[] = formatMsg($msg);
      }
   $event[] = PHP_EOL;
   file_put_contents($logFilename, $event, FILE_APPEND);
   if (filesize($logFilename) > 100000)  //approximate file size limit: 100 KB
      rename($logFilename, $archiveFilename);
   }

function httpJsonResponse($data) {
   header("Cache-Control: no-cache");
   header("Content-Type:  application/json");
   echo json_encode($data);
   logEvent("http-json-response", $data);
   }

?>
