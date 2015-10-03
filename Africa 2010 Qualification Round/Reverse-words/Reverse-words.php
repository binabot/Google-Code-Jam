<?php
/**
 * Problem B. Reverse Words : 
 * Given a list of space separated words, reverse the order of the words. Each line of text contains L letters and W words. 
 * A line will only consist of letters and space characters. There will be exactly one space character between each pair of 
 * consecutive words.
 * 
 * @link http://code.google.com/codejam/contest/dashboard?c=351101#s=p1
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('B-small-practice.out',resolve(file_get_contents('B-small-practice.in'))); // small practice
file_put_contents('B-large-practice.out',resolve(file_get_contents('B-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  foreach ($rows as $key => $value) {
    $data = explode(" ", $value);
    if (count($data) == 1) {
      $output .= "Case #". ($key + 1) .": ". $data[0] ."\n";
    } else {
      $output .= "Case #". ($key + 1) .": ". implode(" ", array_reverse($data)) ."\n";
    }
  }
  return trim($output);
}