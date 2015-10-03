<?php
/**
 * Problem C. Welcome to Code Jam : 
 * So you've registered. We sent you a welcoming email, to welcome you to code jam. But it's possible 
 * that you still don't feel welcomed to code jam. That's why we decided to name a problem "welcome to 
 * code jam." After solving this problem, we hope that you'll feel very welcome. Very welcome, that is, 
 * to code jam.
 * 
 * If you read the previous paragraph, you're probably wondering why it's there. But if you read it very 
 * carefully, you might notice that we have written the words "welcome to code jam" several times: 400263727 
 * times in total. After all, it's easy to look through the paragraph and find a 'w'; then find an 'e' later
 * in the paragraph; then find an 'l' after that, and so on. Your task is to write a program that can take 
 * any text and print out how many times that text contains the phrase "welcome to code jam".
 * To be more precise, given a text string, you are to determine how many times the string "welcome to code 
 * jam" appears as a sub-sequence of that string. In other words, find a sequence s of increasing indices 
 * into the input string such that the concatenation of input[s[0]], input[s[1]], ..., input[s[18]] is the 
 * string "welcome to code jam".
 * 
 * The result of your calculation might be huge, so for convenience we would only like you to find the last 
 * 4 digits.
 * 
 * @link http://code.google.com/codejam/contest/90101/dashboard#s=p2
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('C-small-practice.out',resolve(file_get_contents('C-small-practice.in'))); // small practice
file_put_contents('C-large-practice.out',resolve(file_get_contents('C-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $casesCount = array_shift($rows);
  for ($i = 0; $i < $casesCount; $i++) {
    $row   = str_split($rows[$i]); 
    $total = 0;
    _calculate($row, 19, $total);
    $output .= "Case #". ($i + 1) .": " . substr("000" . $total, -4) . "\n";
  }

  return trim($output);
}

function _calculate($row, $letterIndex, &$total, $counter = array())  {
  $string = "/welcome to code jam";
  $letter = $string[$letterIndex]; // begin with "m"
  if ($letter == '/') {
    if (isset($counter[$letterIndex + 1])) {
      foreach ($counter[$letterIndex + 1] as $position => $count) {
        if (!empty($count)) {
          $total += substr($count, -4);
        }
      }
    }
  }
  else {
    $findLetter = array_filter($row, function($v) use ($letter) {return $v == $letter;});
    if ($letterIndex == 19) { // is last letter "m"
      foreach ($findLetter as $position => $v) {
        $counter[$letterIndex][$position] = 1;
      }
    }
    else {
      $nextLetter = $string[$letterIndex + 1];
      foreach ($findLetter as $position => $v) {
        // find all next letter on the right side of current letter
        $findNextLetter = array_filter($row, function($v, $k) use ($position, $nextLetter) {
            return $k > $position && $v == $nextLetter;
          }, ARRAY_FILTER_USE_BOTH);
        $possibility = 0;
        foreach ($findNextLetter as $positionNextLetter => $v2) {
          if (isset($counter[$letterIndex + 1][$positionNextLetter])) {
            $possibility += substr($counter[$letterIndex + 1][$positionNextLetter], -4);
          }
        }
        $counter[$letterIndex][$position] = $possibility;
      }
    }

    $letterIndex -= 1;
    _calculate($row, $letterIndex, $total, $counter);
  }
}