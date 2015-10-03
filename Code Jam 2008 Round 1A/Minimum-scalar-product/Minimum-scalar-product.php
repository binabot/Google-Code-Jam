<?php
/**
 * Problem A. Minimum Scalar Product : 
 * You are given two vectors v1=(x1,x2,...,xn) and v2=(y1,y2,...,yn). The scalar product 
 * of these vectors is a single number, calculated as x1y1+x2y2+...+xnyn.
 * Suppose you are allowed to permute the coordinates of each vector as you wish. Choose 
 * two permutations such that the scalar product of your two new vectors is the smallest 
 * possible, and output that minimum scalar product.
 * 
 * @link http://code.google.com/codejam/contest/32016/dashboard#s=p0
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('A-small-practice.out',resolve(file_get_contents('A-small-practice.in'))); // small practice
file_put_contents('A-large-practice.out',resolve(file_get_contents('A-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  for ($i = 1; $i <= $casesCount; $i++) {
    $count = array_shift($rows);
    $x     = explode(' ', array_shift($rows));
    $y     = explode(' ', array_shift($rows));
    $output .= "Case #$i: " . method1($x, $y) ."\n";
  }

  return trim($output);
}

function method1($x, $y) {
  $output = 0;
  $xPos = array_filter($x, function($v) {return $v > 0;});
  $xNeg = array_filter($x, function($v) {return $v <= 0;});
  $yPos = array_filter($y, function($v) {return $v > 0;});
  $yNeg = array_filter($y, function($v) {return $v <= 0;});

  // Match up all negative values of $x
  while(!empty($xNeg)) {
    if (!empty($yPos)) {
      $output += _method1(min($xNeg), max($yPos), $xNeg, $yPos);
    }
    else {
      $output += _method1(min($xNeg), max($yNeg), $xNeg, $yNeg);
    }
  }

  // Match up all positive values of $x
  while(!empty($xPos)) {
    if (!empty($yNeg)) {
      $output += _method1(min($yNeg), max($xPos), $yNeg, $xPos);
    }
    else {
      $output += _method1(min($xPos), max($yPos), $xPos, $yPos);
    }
  }

  return $output;
}

function _method1($a, $b, &$aArr, &$bArr) {
  $aKey = array_search($a, $aArr);
  $bKey = array_search($b, $bArr);
  unset($aArr[$aKey]);
  unset($bArr[$bKey]);

  return $a * $b;
}