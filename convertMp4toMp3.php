  <?php
/**
 * Work with ffmpeg and read a directory of mp4 files and translate them to mp3
 * (!) Yep - you need to install ffmpeg before running this script.
 *
 * @author: Ido Green | @greenido
 * @date: 1/1/2015
 */

// TODO: replace the dir with your local one
$dir    = '/your/local/location';
$files  = scandir($dir);
//print_r($files);

foreach ($files as $key => $fileName) {
  $name = str_replace("mp4", "mp3", $fileName, $wasReplaced);
  $name = str_replace(" ", "", $name);
  if  ( $wasReplaced === 1) {
    // convert the mp4 to mp3
    echo "Going to work on $dir/$fileName and create: $name\n";
    $start = time();
    // other option to get 192k -f mp3 -ab 192000
    exec("/Applications/ffmpeg -i '{$dir}/{$fileName}' -b:a 192K -vn {$dir}/{$name}"); 
    $end = time();
    echo "\n\n=============== Took: " . ($end-$start) . " Sec ===\n";
  }
}