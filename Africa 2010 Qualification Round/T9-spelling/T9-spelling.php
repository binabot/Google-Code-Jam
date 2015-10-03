<?php
/**
 * Problem C. T9 Spelling : 
 * The Latin alphabet contains 26 characters and telephones only have ten digits on the keypad. 
 * We would like to make it easier to write a message to your friend using a sequence of keypresses 
 * to indicate the desired characters. The letters are mapped onto the digits as shown below. To 
 * insert the character B for instance, the program would press 22. In order to insert two characters 
 * in sequence from the same key, the user must pause before pressing the key a second time. The space 
 * character ' ' should be printed to indicate a pause. For example, 2 2 indicates AA whereas 22 indicates B.
 * 
 * @link http://code.google.com/codejam/contest/dashboard?c=351101#s=p2
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('C-small-practice.out',resolve(file_get_contents('C-small-practice.in'))); // small practice
file_put_contents('C-large-practice.out',resolve(file_get_contents('C-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  $vocabulary = method1();
  foreach ($rows as $key => $value) {
    $output .= "Case #". ($key + 1) .": ";
    for ($i = 0; $i < strlen($value); $i++) {
      if (isset($prevDigit) && $vocabulary[$value[$i]]['digit'] == $prevDigit) {
        $output .= " ";
      }
      $prevDigit = $vocabulary[$value[$i]]['digit'];
      $output   .= $vocabulary[$value[$i]]['value'];
    }
    $output .= "\n";
  }
  return trim($output);
}

function method1() {
  $vocabulary = array(" " => array('digit' => 0, 'value' => 0));
  $digit  = 2;
  $i      = 1;
  foreach (range('a', 'z') as $char) {
    $numLettersOnKey   = ($digit == 7 || $digit == 9) ? 4 : 3;
    $vocabulary[$char] = array(
      'digit' => $digit,
      'value' => str_repeat($digit, $i),
    );
    if ($i == $numLettersOnKey) {
      $digit ++;
      $i = 1;
    }
    else {
      $i ++;
    }
  }
  return $vocabulary;
}