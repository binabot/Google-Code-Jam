<?php
/**
 * Problem B. Picking Up Chicks : 
 * A flock of chickens are running east along a straight, narrow road. Each one is running with 
 * its own constant speed. Whenever a chick catches up to the one in front of it, it has to slow 
 * down and follow at the speed of the other chick. You are in a mobile crane behind the flock, 
 * chasing the chicks towards the barn at the end of the road. The arm of the crane allows you to 
 * pick up any chick momentarily, let the chick behind it pass underneath and place the picked up 
 * chick back down. This operation takes no time and can only be performed on a pair of chicks that 
 * are immediately next to each other, even if 3 or more chicks are in a row, one after the other.
 * 
 * Given the initial locations (Xi) at time 0 and natural speeds (Vi) of the chicks, as well as the 
 * location of the barn (B), what is the minimum number of swaps you need to perform with your crane 
 * in order to have at least K of the N chicks arrive at the barn no later than time T?
 *
 * You may think of the chicks as points moving along a line. Even if 3 or more chicks are at the 
 * same location, next to each other, picking up one of them will only let one of the other two pass 
 * through. Any swap is instantaneous, which means that you may perform multiple swaps at the same 
 * time, but each one will count as a separate swap.
 *
 * @link http://code.google.com/codejam/contest/635101/dashboard#s=p1
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('B-small-practice.out',resolve(file_get_contents('B-small-practice.in'))); // small practice
file_put_contents('B-large-practice.out',resolve(file_get_contents('B-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  for ($i = 1; $i <= $casesCount; $i++) {
    $infos          = explode(" ", array_shift($rows));
    $chicksCount    = $infos[0];
    $chicksToArrive = $infos[1];
    $barnLocation   = $infos[2];
    $timeToArrive   = $infos[3];
    $chicksLocation = explode(" ", array_shift($rows));
    $chicksSpeed    = explode(" ", array_shift($rows));
    $swaps          = array();
    $fastChicks     = array();
    $slowChicks     = array();
    for ($j = 0; $j < $chicksCount; $j++) {
      $chickSpeed        = $chicksSpeed[$j];
      $chickLocation     = $chicksLocation[$j];
      $chickTimeToArrive = ($barnLocation - $chickLocation)/$chickSpeed;
      if ($chickTimeToArrive > $timeToArrive) {
        $slowChicks[$j] = $chickLocation;
      }
      else {
        $fastChicks[$j] = $chickLocation;
      }
    }
    if (count($fastChicks) < $chicksToArrive) {
      $output .= "Case #$i: IMPOSSIBLE\n";
    }
    else {
      foreach ($slowChicks as $chickKey => $chickLocation) {
        $fastChicksBehindMe = array_filter($fastChicks, function($v) use ($chickLocation) {
          return $v < $chickLocation;
        });
        foreach ($fastChicksBehindMe as $chickBehindKey => $v) {
          $swaps[$chickBehindKey] = isset($swaps[$chickBehindKey]) ? $swaps[$chickBehindKey] + 1 : 1;
        }
      }
      if (!empty($swaps)) {
        asort($swaps);
      }
      $minSwaps = array_slice($swaps, 0, $chicksToArrive);
      $output .= "Case #$i: " . array_sum($minSwaps) . "\n";
    }
  }

  return trim($output);
}