<?php
/**
 * Problem A. File Fix-it : 
 * On Unix computers, data is stored in directories. There is one root directory, and this might have several 
 * directories contained inside of it, each with different names. These directories might have even more 
 * directories contained inside of them, and so on.
 * 
 * A directory is uniquely identified by its name and its parent directory (the directory it is directly contained 
 * in). This is usually encoded in a path, which consists of several parts each preceded by a forward slash ('/'). 
 * The final part is the name of the directory, and everything else gives the path of its parent directory. For 
 * example, consider the path:
 * /home/gcj/finals
 *
 * This refers to the directory with name "finals" in the directory described by "/home/gcj", which in turn refers 
 * to the directory with name "gcj" in the directory described by the path "/home". In this path, there is only one 
 * part, which means it refers to the directory with the name "home" in the root directory.
 *
 * To create a directory, you can use the mkdir command. You specify a path, and then mkdir will create the directory 
 * described by that path, but only if the parent directory already exists. For example, if you wanted to create the 
 * "/home/gcj/finals" and "/home/gcj/quals" directories from scratch, you would need four commands:
 * mkdir /home
 * mkdir /home/gcj
 * mkdir /home/gcj/finals
 * mkdir /home/gcj/quals
 *
 * Given the full set of directories already existing on your computer, and a set of new directories you want to create 
 * if they do not already exist, how many mkdir commands do you need to use?
 *
 * @link http://code.google.com/codejam/contest/635101/dashboard#s=p0
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('A-small-practice.out',resolve(file_get_contents('A-small-practice.in'))); // small practice
file_put_contents('A-large-practice.out',resolve(file_get_contents('A-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  for ($i = 1; $i <= $casesCount; $i++) {
    $dirDesc     = explode(" ", array_shift($rows));
    $dirExists   = _array_to_string(array_splice($rows, 0, $dirDesc[0]));
    $dirToCreate = _array_to_string(array_splice($rows, 0, $dirDesc[1]));
    $mkdirCount  = array_diff($dirToCreate, $dirExists);
    $output     .= "Case #$i: " . count($mkdirCount) . "\n";
  }

  return trim($output);
}

function _array_to_string($dirs) {
  $output = array();
  foreach ($dirs as $dirPath) {
    $dir = explode("/", substr($dirPath, 1));
    $prefix = '';
    while(!empty($dir)) {
      $prefix .= "/" . array_shift($dir);
      if (!in_array($prefix, $output)) {
        $output[] = $prefix;
      }
    }
  }
  return $output;
}