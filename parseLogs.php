<?php

/**
 * Parse the output from Log files and save them in a new file
 * @author Ido Green
 * @date 26/11/2013
 */
define("ZEND_LIB", "/dev-tools/ZendFramework-1.11.6/library/");
set_include_path(get_include_path() . PATH_SEPARATOR . ZEND_LIB);

require_once 'Zend/Loader.php';
$workDir = "/Users/";
$outputFile = "all-results.csv";

/**
 * Getting all the files from a dir into an array
 * @param type $directory
 * @param type $recursive
 * @param $type the file type. E.g. csv
 * @return type
 */
function directoryToArray($directory, $recursive, $fileType = null) {
  $array_items = array();
  if ($handle = opendir($directory)) {
    while (false !== ($file = readdir($handle))) {
      if ($file != "." && $file != "..") {
        if ($fileType != null && strpos($file, $fileType) > 1) {
          if (is_dir($directory . "/" . $file)) {
            if ($recursive) {
              $array_items = array_merge($array_items, directoryToArray($directory . "/" . $file, $recursive));
            }
            $file = $directory . "/" . $file;
            $array_items[] = preg_replace("/\/\//si", "/", $file);
          } else {
            $file = $directory . "/" . $file;
            $array_items[] = preg_replace("/\/\//si", "/", $file);
          }
        }
      }
    }
    closedir($handle);
  }
  return $array_items;
}

/**
 * simple saver of data/string to file
 * @param <type> $fileName
 * @param <type> $data
 * @return <type> false when we could not save the data
 */
function saveToFile($fileName, $data) {
  try {
    $fh = fopen($fileName, 'a');
    fwrite($fh, $data);
    fclose($fh);
  } catch (Exception $exc) {
    error_log("Err: Could not write to file: {$fileName} Trace:" . $exc->getTraceAsString());
    return false;
  }
  return true;
}

//
// Start the party
//
echo "== String the work ==\n";
$listOfFiles = directoryToArray($workDir, false, "txt");
$allResults = "";
foreach ($listOfFiles as $txtFile) {
  $fileText = file_get_contents($txtFile);
  $outData = str_replace(" ", ",", $fileText);
  $outData = preg_replace('/,+/', ',', $outData);
  $allResults .= "\n----------------------\n" . $outData;
}

echo "\n== Saving the results to: $outputFile";
saveToFile($outputFile, $allResults);
echo "\n== Done the work ==";
