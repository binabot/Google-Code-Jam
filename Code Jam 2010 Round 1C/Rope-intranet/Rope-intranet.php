<?php
/**
 * Problem A. Rope Intranet : 
 * A company is located in two very tall buildings. The company intranet connecting the buildings 
 * consists of many wires, each connecting a window on the first building to a window on the second 
 * building.
 * 
 * You are looking at those buildings from the side, so that one of the buildings is to the left and 
 * one is to the right. The windows on the left building are seen as points on its right wall, and the 
 * windows on the right building are seen as points on its left wall. Wires are straight segments 
 * connecting a window on the left building to a window on the right building.
 * 
 * You've noticed that no two wires share an endpoint (in other words, there's at most one wire going 
 * out of each window). However, from your viewpoint, some of the wires intersect midway. You've also
 * noticed that exactly two wires meet at each intersection point.
 *
 * On the above picture, the intersection points are the black circles, while the windows are the white circles.
 * How many intersection points do you see?
 *
 * @link http://code.google.com/codejam/contest/619102/dashboard#s=p0
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('A-small-practice.out',resolve(file_get_contents('A-small-practice.in'))); // small practice
file_put_contents('A-large-practice.out',resolve(file_get_contents('A-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  for ($i = 1; $i <= $casesCount; $i++) {
    $numWires = array_shift($rows);
    $getWires = array_splice($rows, 0, $numWires);
    $wires    = array();
    $intersec = 0;
    foreach ($getWires as $coordinate) {
      $coordinateXY = explode(" ", $coordinate);
      $wires[] = array(
        'x' => $coordinateXY[0],
        'y' => $coordinateXY[1],
      );
    }
    while (!empty($wires)) {
      $wire = array_shift($wires);
      $find = array_filter($wires, function($v) use ($wire) {
        return ($wire["x"] < $v["x"] && $wire["y"] > $v["y"]) || ($wire["x"] > $v["x"] && $wire["y"] < $v["y"]);
      });
      $intersec += count($find);
    }
    $output .= "Case #$i: " . $intersec . "\n";
  }

  return trim($output);
}