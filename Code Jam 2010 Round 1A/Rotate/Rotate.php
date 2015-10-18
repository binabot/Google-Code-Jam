<?php
/**
 * Problem A. Rotate : 
 * In the exciting game of Join-K, red and blue pieces are dropped into an N-by-N table. The 
 * table stands up vertically so that pieces drop down to the bottom-most empty slots in their 
 * column. For example, consider the following two configurations:
 * 
 * In these pictures, each '.' represents an empty slot, each 'R' represents a slot filled with
 * a red piece, and each 'B' represents a slot filled with a blue piece. The left configuration 
 * is legal, but the right one is not. This is because one of the pieces in the third column 
 * (marked with the arrow) has not fallen down to the empty slot below it.
 *
 * A player wins if they can place at least K pieces of their color in a row, either horizontally,
 * vertically, or diagonally. The four possible orientations are shown below.
 *
 * In the "Legal Position" diagram at the beginning of the problem statement, both players had 
 * lined up two pieces in a row, but not three.
 *
 * As it turns out, you are right now playing a very exciting game of Join-K, and you have a tricky 
 * plan to ensure victory! When your opponent is not looking, you are going to rotate the board 90 
 * degrees clockwise onto its side. Gravity will then cause the pieces to fall down into a new 
 * position as shown below.
 *
 * Unfortunately, you only have time to rotate once before your opponent will notice.
 *
 * All that remains is picking the right time to make your move. Given a board position, you should 
 * determine which player (or players!) will have K pieces in a row after you rotate the board 
 * clockwise and gravity takes effect in the new direction.
 *
 * @link http://code.google.com/codejam/contest/544101/dashboard#s=p0
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('A-small-practice.out',resolve(file_get_contents('A-small-practice.in'))); // small practice
file_put_contents('A-large-practice.out',resolve(file_get_contents('A-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  for ($i = 1; $i <= $casesCount; $i++) {
    $params         = explode(" ", array_shift($rows));
    $boardLong      = $params[0];
    $piecesRequired = $params[1];
    $board          = array_splice($rows, 0, $boardLong);

    $R = array();
    $B = array();
    foreach ($board as $y => $line) {
      $slots      = str_split($line);
      $emptySlots = array();
      for ($x = count($slots) - 1; $x >= 0; $x --) {
        if ($slots[$x] == ".") {
          $emptySlots[] = $x;
        } else {
          if (!empty($emptySlots)) {
            $rightmostEmptySlot = array_shift($emptySlots);
            ${$slots[$x]}[]     = $rightmostEmptySlot . "#" . $y;
            $emptySlots[]       = $x;
          }
          else {
            ${$slots[$x]}[] = $x . "#" . $y;
          }
        }
      }
    }
    _rotate($R, $boardLong);
    _rotate($B, $boardLong);
    $Rwin = _check4directions($R, $piecesRequired);
    $Bwin = _check4directions($B, $piecesRequired);

    if ($Rwin && $Bwin) {
      $output .= "Case #$i: Both\n";
    } else if ($Rwin && !$Bwin) {
      $output .= "Case #$i: Red\n";
    } else if (!$Rwin && $Bwin) {
      $output .= "Case #$i: Blue\n";
    } else {
      $output .= "Case #$i: Neither\n";
    }
  }

  return trim($output);
}

function _rotate(&$slotsFilled, $boardLong) {
  foreach ($slotsFilled as $k => $v) {
    $xy = explode("#", $v);
    $slotsFilled[$k] = ($boardLong - $xy[1]) . "#" . ($boardLong - $xy[0]);
  }
}

function _check4directions($slotsFilled, $piecesRequired) {
  $validated = false;
  foreach ($slotsFilled as $v) {
    $xy = explode("#", $v);
    $x  = $xy[0];
    $y  = $xy[1];
    // Check top
    $checkTop = array();
    for ($i = 1; $i < $piecesRequired; $i ++) {
      $checkTop[] = $x . "#" . ($y + $i);
    }
    if (empty(array_diff($checkTop, $slotsFilled))) {
      $validated = true;
      break;
    }
    // Check top-left 
    $checkTopLeft = array();
    for ($i = 1; $i < $piecesRequired; $i ++) {
      $checkTopLeft[] = ($x - $i) . "#" . ($y + $i);
    }
    if (empty(array_diff($checkTopLeft, $slotsFilled))) {
      $validated = true;
      break;
    }
    // Check left 
    $checkLeft = array();
    for ($i = 1; $i < $piecesRequired; $i ++) {
      $checkLeft[] = ($x - $i) . "#" . $y;
    }
    if (empty(array_diff($checkLeft, $slotsFilled))) {
      $validated = true;
      break;
    }
    // Check left-bottom 
    $checkLeftBottom = array();
    for ($i = 1; $i < $piecesRequired; $i ++) {
      $checkLeftBottom[] = ($x - $i) . "#" . ($y - $i);
    }
    if (empty(array_diff($checkLeftBottom, $slotsFilled))) {
      $validated = true;
      break;
    }
  }

  return $validated;
}