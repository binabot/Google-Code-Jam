<?php
/**
 * Problem C. Numbers : 
 * In this problem, you have to find the last three digits before the decimal point for the number (3 + √5)n.
 * For example, when n = 5, (3 + √5)5 = 3935.73982... The answer is 935. 
 * For n = 2, (3 + √5)2 = 27.4164079... The answer is 027.
 * 
 * @link http://code.google.com/codejam/contest/32016/dashboard#s=p2
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('C-small-practice.out',resolve(file_get_contents('C-small-practice.in'), '_method3')); // small practice
file_put_contents('C-large-practice.out',resolve(file_get_contents('C-large-practice.in'), '_method3')); // large practice


function resolve($content, $method) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  $base       = 3 + sqrt(5);
  for ($i = 0; $i < $casesCount; $i++) {
    $output .= $method($rows[$i], $i, $base);
  }
  return trim($output);
}

// Method 1 : php math functions used for small practice
// return wrong result when $n >= 16, but still can be used if don't need a super accurate answer
// Case (3 + √5)16 : 
// - right answer = 992
// - wrong answer = 991
function _method1($row, $i, $base) { 
  $result  = bcpow($base, $row, 0);
  return "Case #". ($i + 1) .": ". substr("00" . $result, -3) ."\n";
}

// Method 2 : php math functions used for large practice
function _method2($row, $i, $base) { 
  $result  = bcpowmod($base, $row, 1000, 0);
  return "Case #". ($i + 1) .": ". substr("00" . $result, -3) ."\n";
}

// Method 3 : full custom concept & functions created for small and large practice
function _method3($row, $caseNum, $base) {
  $baseList   = _float_to_array($base);
  $countAfterDecimalPoint = array_shift($baseList) * $row;
  $resultList = $baseList;
  // loop
  for ($i = 1; $i < $row; $i ++) {
    $data = array();
    foreach($baseList as $key => $baseValue) {
      $j = $key;
      foreach ($resultList as $resultValue) {
        $data[$j][] = $baseValue * $resultValue;
        $j ++;
      }
    }
    $dataReverse = array_reverse(array_map("_sum_elements_of_array", $data));
    for ($k = 0; $k < count($dataReverse); $k ++) {
      $value = $dataReverse[$k];
      $add  = floor($value / 10);
      $stay = $value % 10;
      $dataReverse[$k] = $stay;
      if ($add > 0) {
        $dataReverse[$k + 1] = isset($dataReverse[$k + 1]) ? ($dataReverse[$k + 1] + $add) : $add;
      }
    }
    $resultList = array_reverse($dataReverse);
  }
  // Get data
  array_unshift($resultList, 0, 0); 
  $last3digits = array_slice($resultList, -($countAfterDecimalPoint + 3), 3);

  return "Case #". ($caseNum + 1) .": ". implode("", $last3digits) ."\n";;
}

function _float_to_array($float) {
  $float  = strval($float);
  $input  = explode(".", $float);
  // set count number after decimal point
  $output = array('countAfterDecimalPoint' => strlen($input[1]));
  for ($i = 0; $i < strlen($float); $i ++) {
    if ($float[$i] != ".") {
      $output[] = $float[$i];
    }
  }
  return $output;
}

function _sum_elements_of_array($v) {
  return array_sum($v); 
}