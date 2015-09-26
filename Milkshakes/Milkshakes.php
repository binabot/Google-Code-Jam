<?php
/**
 * Problem B. Milkshakes : 
 * You own a milkshake shop. There are N different flavors that you can prepare, and each flavor 
 * can be prepared "malted" or "unmalted". So, you can make 2N different types of milkshakes. Each 
 * of your customers has a set of milkshake types that they like, and they will be satisfied if you
 * have at least one of those types prepared. At most one of the types a customer likes will be a 
 * "malted" flavor.
 * You want to make N batches of milkshakes, so that:
 * - There is exactly one batch for each flavor of milkshake, and it is either malted or unmalted.
 * - For each customer, you make at least one milkshake type that they like.
 * - The minimum possible number of batches are malted.
 * Find whether it is possible to satisfy all your customers given these constraints, and if it is, 
 * what milkshake types you should make.
 * If it is possible to satisfy all your customers, there will be only one answer which minimizes the number of malted batches.
 * 
 * @link http://code.google.com/codejam/contest/32016/dashboard#s=p1
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('B-small-practice.out',resolve(file_get_contents('B-small-practice.in'))); // small practice
file_put_contents('B-large-practice.out',resolve(file_get_contents('B-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  for ($i = 1; $i <= $casesCount; $i ++) {
    $numFlavors    = array_shift($rows);
    $numCustomer   = array_shift($rows);
    $customerLikes = array_map("_str_to_array", array_splice($rows, 0, $numCustomer));

    $malted   = array();
    $unmalted = array();
    foreach ($customerLikes as $customer => $customerLike) {
      foreach ($customerLike as $falvor => $ifMalted) {
        if ($ifMalted == 1) {
          $malted[$customer] = $falvor; // Each customer will like at most one malted flavor.
        } else {
          $unmalted[$customer][$falvor] = true; // Each customer can like > 1 unmalted flavor.
        }
      }
    }

    $batches  = array();
    $visited  = array();
    $possible = true;
    while (true) {
      $StrictCustomerFound = false;
      for ($customer = 0; $customer < $numCustomer; $customer ++) {
        // each for loop is to find the most strict customer, nothing found means everyone got at least one batch he like
        if (!isset($unmalted[$customer]) && !isset($visited[$customer])) {
          $visited[$customer]  = true;
          $StrictCustomerFound = true;
          if (isset($malted[$customer])) {
            // we need to satisfy this customer's malted flavor cz he don't like any unmalted falvor, 
            // or all his favorite unmalted falvor has been made as malted flavor to satisfy other strict customer.
            $batches[$malted[$customer]] = true;
            // Remove the unmalted falvor from everyone's favorite list cz this falvor will be make as malted flavor.
            for ($k = 0; $k < $numCustomer; $k ++) {
              if (isset($unmalted[$k][$malted[$customer]])) {
                unset($unmalted[$k][$malted[$customer]]);
                if (count($unmalted[$k]) == 0) {
                  unset($unmalted[$k]); // Now ths guy is being a strict customer :(
                }
              }
            }
          }
          else {
            // this customer don't like any malted falvor, and we can't offer him any unmalted falvor 
            // he like. So is impossible to satisfy all customers in this case. We break the loop. 
            $possible = false;
            break;
          }
        }
      }
      if (!$StrictCustomerFound) {
        // Every customer got at least one batch he like
        break;
      }
      if (!$possible) {
        // impossible to satisfy all customer in this case
        break;
      }
    }

    // set output
    if ($possible) {
      $output .= "Case #$i: ";
      for ($j = 1; $j <= $numFlavors; $j ++) {
        $output .= (isset($batches[$j]) ? 1 : 0) . " ";
      }
      $output .= "\n";
    }
    else {
      $output .= "Case #$i: IMPOSSIBLE\n";
    }

  }

  return trim($output);
}

function _str_to_array($v) {
  $customerLikes = explode(" ", $v);
  $numLikes      = array_shift($customerLikes);
  $output = array();
  for ($i = 0; $i < $numLikes * 2; $i += 2) {
    $output[$customerLikes[$i]] = $customerLikes[$i+1]; // falvor => malted
  }
  return $output;
}