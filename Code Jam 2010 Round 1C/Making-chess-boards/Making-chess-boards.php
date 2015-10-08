<?php
/**
 * Problem C. Making Chess Boards : 
 * The chess board industry has fallen on hard times and needs your help. It is a little-known fact that chess 
 * boards are made from the bark of the extremely rare Croatian Chess Board tree, (Biggus Mobydiccus). The bark 
 * of that tree is stripped and unwrapped into a huge rectangular sheet of chess board material. The rectangle 
 * is a grid of black and white squares.
 * 
 * Your task is to make as many large square chess boards as possible. A chess board is a piece of the bark that 
 * is a square, with sides parallel to the sides of the bark rectangle, with cells colored in the pattern of a 
 * chess board (no two cells of the same color can share an edge).
 * 
 * Each time you cut out a chess board, you must choose the largest possible chess board left in the sheet. If 
 * there are several such boards, pick the topmost one. If there is still a tie, pick the leftmost one. Continue 
 * cutting out chess boards until there is no bark left. You may need to go as far as cutting out 1-by-1 mini chess 
 * boards.
 *
 * Here is an example showing the bark of a Chess Board tree and the first few chess boards that will be cut out of it.
 *
 * @link http://code.google.com/codejam/contest/619102/dashboard#s=p2&a=1
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('C-small-practice.out',resolve(file_get_contents('C-small-practice.in'))); // small practice
file_put_contents('C-large-practice.out',resolve(file_get_contents('C-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  for ($n = 1; $n <= $casesCount; $n++) {
    $xy = explode(" ", array_shift($rows));
    $x  = $xy[1];
    $y  = $xy[0];
    $hexadecimals = array_splice($rows, 0, $y);
    $binaries     = array();
    foreach ($hexadecimals as $hexadecimal) {
      $binaries[] = str_pad(base_convert($hexadecimal, 16, 2), $x, "0", STR_PAD_LEFT);
    }
    $coorsVocabulary = array();
    foreach ($binaries as $k => $binaryData) {
      for ($i = 1; $i <= strlen($binaryData); $i ++) {
        $coorsVocabulary[($k + 1) . '-' . $i] = $binaryData[$i-1];
      }
    }
    $chessBoards     = array();
    $chessBoardCoors = $coorsVocabulary;
    while(!empty($chessBoardCoors)) {
      // find chess board max size for every coordinate
      foreach ($chessBoardCoors as $coor => $v){
        $in = array($coor);
        $chessBoardSizes = 1;
        while(true) {
          $out = array();
          $validated = true;
          foreach ($in as $coorToCheck) {
            $result = _check_2x2($coorToCheck, $chessBoardCoors, $coorsVocabulary);
            if ($result) {
              foreach ($result as $resultCoor) {
                if (!array_search($resultCoor, $out)) {
                  $out[] = $resultCoor;
                }
              }
            }
            else {
              $validated = false;
              break;
            }
          }
          if (!$validated) {
            break;
          }
          else {
            $chessBoardSizes ++;
            $in = array_diff($out, $in);
          }
        }
        $chessBoardCoors[$coor] = $chessBoardSizes;
      }
      $maxSize = max($chessBoardCoors);
      for ($j = $maxSize; $j > 0; $j --) {
        $find = array_filter($chessBoardCoors, function($v) use ($j) {return $v == $j;});
        foreach ($find as $coor => $size) {
          if (_checkChessBoardStillAvailable($coor, $size, $chessBoardCoors)) {
            $chessBoards[$size] = isset($chessBoards[$size]) ? $chessBoards[$size] + 1 : 1;
            _delete_coors($chessBoardCoors, $coor, $size);
          }
        }
      }
    }

    // set output
    $output .= "Case #$n: " . count($chessBoards) . "\n";
    foreach ($chessBoards as $size => $count) {
      $output .= $size . " " . $count . "\n";
    }
  }

  return trim($output);
}

function _check_2x2($coor, $chessBoardCoors, $coorsVocabulary) {
  $myColor       = $coorsVocabulary[$coor];
  $oppositeColor = $myColor == 1 ? 0 : 1;
  $xy   = explode("-", $coor);
  $x    = $xy[0];
  $y    = $xy[1];
  $rightCoorStr       = ($x + 1) . "-" . $y;
  $bottomCoorStr      = $x . "-" . ($y + 1);
  $bottomRightCoorStr = ($x + 1) . "-" . ($y + 1);
  if (
    isset($chessBoardCoors[$rightCoorStr]) &&
    $coorsVocabulary[$rightCoorStr] == $oppositeColor && 
    isset($chessBoardCoors[$bottomCoorStr]) &&
    $coorsVocabulary[$bottomCoorStr] == $oppositeColor && 
    isset($chessBoardCoors[$bottomRightCoorStr]) && 
    $coorsVocabulary[$bottomRightCoorStr] == $myColor
    ) {
    return array($rightCoorStr, $bottomCoorStr, $bottomRightCoorStr);
  }
  return false;
}

function _delete_coors(&$chessBoardCoors, $coor, $size) {
  if (isset($chessBoardCoors[$coor])) {
    unset($chessBoardCoors[$coor]);
  }
  $coorXY = explode("-", $coor);
  for($i = $coorXY[0]; $i < $coorXY[0] + $size; $i++) {
    for ($j = $coorXY[1]; $j < $coorXY[1] + $size; $j ++) {
      $coorTmp = $i . "-" . $j;
      if (isset($chessBoardCoors[$coorTmp])) {
        unset($chessBoardCoors[$coorTmp]);
      }
    }
  }
}

function _checkChessBoardStillAvailable($coor, $size, $chessBoardCoors) {
  $coorXY = explode("-", $coor);
  for($i = $coorXY[0]; $i < $coorXY[0] + $size; $i++) {
    for ($j = $coorXY[1]; $j < $coorXY[1] + $size; $j ++) {
      $coorTmp = $i . "-" . $j;
      if (!isset($chessBoardCoors[$coorTmp])) {
        return false;
      }
    }
  }
  return true;
}