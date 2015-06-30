<?php

//
// Convert our json DB (e.g. firebase) to CSV 
// So you can work with it in other DBs or Google sheets, excel etc'
//
// @author: Ido Green | @greenido
// @date: 30/6/2015
//

if (empty($argv[1])) {
  die("The json file name or URL cannot be found. Are you drunk?\n");
}
$jsonFilename = $argv[1];

$json = file_get_contents($jsonFilename);
$array = json_decode($json, true);
$f = fopen('output.csv', 'w');

// TODO: change your-high-level-key to the current key that hold all your data. 
foreach ($array['your-high-level-key'] as $key => $palyer) {
  foreach ($palyer as $value) {
    fputcsv($f, $value);
  }
}
