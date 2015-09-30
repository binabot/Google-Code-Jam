<?php
/**
 * Problem A. Alien Language : 
 * After years of study, scientists at Google Labs have discovered an alien language transmitted 
 * from a faraway planet. The alien language is very unique in that every word consists of exactly 
 * L lowercase letters. Also, there are exactly D words in this language.
 * Once the dictionary of all the words in the alien language was built, the next breakthrough was 
 * to discover that the aliens have been transmitting messages to Earth for the past decade. 
 * Unfortunately, these signals are weakened due to the distance between our two planets and some 
 * of the words may be misinterpreted. In order to help them decipher these messages, the scientists 
 * have asked you to devise an algorithm that will determine the number of possible interpretations 
 * for a given pattern.
 * A pattern consists of exactly L tokens. Each token is either a single lowercase letter (the 
 * scientists are very sure that this is the letter) or a group of unique lowercase letters 
 * surrounded by parenthesis ( and ). For example: (ab)d(dc) means the first letter is either a or b,
 *  the second letter is definitely d and the last letter is either d or c. Therefore, the pattern 
 * (ab)d(dc) can stand for either one of these 4 possibilities: add, adc, bdd, bdc.
 * 
 * @link http://code.google.com/codejam/contest/90101/dashboard#s=p0
 * @author Jian LI <lijian9051@gmail.com>
 */

file_put_contents('A-small-practice.out',resolve(file_get_contents('A-small-practice.in'))); // small practice
file_put_contents('A-large-practice.out',resolve(file_get_contents('A-large-practice.in'))); // large practice

function resolve($content) {
  $output     = "";
  $rows       = explode("\n", trim($content));
  $firstLine  = explode(" ", array_shift($rows));
  $wordLength = $firstLine[0];
  $vocabulary = array_splice($rows, 0, $firstLine[1]);

  foreach ($rows as $k => $row) {
    $matchVocabulary = $vocabulary;
    $data            = str_split($row);
    $pointer         = 0;
    while (!empty($data)) {
      $filter = array();
      $letter = array_shift($data);
      if ($letter == "(") {
        while(true) {
          $nextLetter = array_shift($data);
          if ($nextLetter != ")") {
            $filter[] = $nextLetter;
          }
          else {
            break;
          }
        }
      }
      else {
        $filter[] = $letter;
      }
      $matchVocabulary = array_filter($matchVocabulary, function($v) use ($filter, $pointer) {
        return in_array($v[$pointer], $filter);
      });
      // 0 result matched
      if (empty($matchVocabulary)) {
        break;
      }
      $pointer ++;
    }
    // Set output
    $output .= "Case #". ($k + 1) .": " . count($matchVocabulary) . "\n";
  }

  return trim($output);
}