<?php
/**
 * Problem A. Store Credit : 
 * You receive a credit C at a local store and would like to buy two items. You first walk through the store and create 
 * a list L of all available items. From this list you would like to buy two items that add up to the entire value of the 
 * credit. The solution you provide will consist of the two integers indicating the positions of the items in your list 
 * (smaller number first).
 * 
 * @link http://code.google.com/codejam/contest/dashboard?c=351101#s=p0
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('A-small-practice.out',resolve(file_get_contents('A-small-practice.in'))); // small practice
file_put_contents('A-large-practice.out',resolve(file_get_contents('A-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", $content);
  $casesCount = array_shift($rows);
  for ($i = 1; $i <= $casesCount; $i++) {
    $output .= method1($rows, $i);
  }
  return trim($output);
}

function method1(&$rows, $i) {
  $creditAmount = array_shift($rows);
  $itemsCount   = array_shift($rows);
  $itemsPrices  = explode(' ', array_shift($rows));
  $j = 0;      // first item pointer
  $k = $j + 1; // second item pointer
  while (!isset($o)) {
    if ($itemsPrices[$j] + $itemsPrices[$k] == $creditAmount) {
      $o = "Case #$i: ". ($j + 1) ." ". ($k + 1) ."\n";
      break;
    }
    if ($k + 1 == $itemsCount) {
      $j ++;
      $k = $j + 1;
      if ($j + 1 == $itemsCount) {
        $o = "Case #$i: No result\n";
      }
    }
    else {
      $k ++;
    }
  }
  return $o;
}