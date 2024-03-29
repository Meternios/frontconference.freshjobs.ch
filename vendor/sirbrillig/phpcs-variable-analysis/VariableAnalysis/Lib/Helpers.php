<?php

namespace VariableAnalysis\Lib;

use PHP_CodeSniffer\Files\File;

class Helpers {
  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return int|bool
   */
  public static function findContainingOpeningSquareBracket(File $phpcsFile, $stackPtr) {
    $previousStatementPtr = self::getPreviousStatementPtr($phpcsFile, $stackPtr);
    return $phpcsFile->findPrevious(T_OPEN_SHORT_ARRAY, $stackPtr - 1, $previousStatementPtr);
  }

  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return int|bool
   */
  public static function findContainingClosingSquareBracket(File $phpcsFile, $stackPtr) {
    $endOfStatementPtr = $phpcsFile->findNext([T_SEMICOLON], $stackPtr + 1);
    if (is_bool($endOfStatementPtr)) {
      return false;
    }
    return $phpcsFile->findNext(T_CLOSE_SHORT_ARRAY, $stackPtr + 1, $endOfStatementPtr);
  }

  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return int
   */
  public static function getPreviousStatementPtr(File $phpcsFile, $stackPtr) {
    $result = $phpcsFile->findPrevious([T_SEMICOLON, T_CLOSE_CURLY_BRACKET], $stackPtr - 1);
    return is_bool($result) ? 1 : $result;
  }

  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return int|bool
   */
  public static function findContainingOpeningBracket(File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();
    if (isset($tokens[$stackPtr]['nested_parenthesis'])) {
      $openPtrs = array_keys($tokens[$stackPtr]['nested_parenthesis']);
      return (int)end($openPtrs);
    }
    return false;
  }

  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return int|bool
   */
  public static function findParenthesisOwner(File $phpcsFile, $stackPtr) {
    return $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
  }

  /**
   * @param File $phpcsFile
   * @param int[] $conditions
   *
   * @return bool
   */
  public static function areAnyConditionsAClosure(File $phpcsFile, array $conditions) {
    // self within a closure is invalid
    $tokens = $phpcsFile->getTokens();
    foreach (array_reverse($conditions, true) as $scopePtr => $scopeCode) {
      //  Note: have to fetch code from $tokens, T_CLOSURE isn't set for conditions codes.
      if ($tokens[$scopePtr]['code'] === T_CLOSURE) {
        return true;
      }
    }
    return false;
  }


  /**
   * @param int[] $conditions
   *
   * @return bool
   */
  public static function areAnyConditionsAClass(array $conditions) {
    foreach (array_reverse($conditions, true) as $scopePtr => $scopeCode) {
      if ($scopeCode === T_CLASS || $scopeCode === T_TRAIT) {
        return true;
      }
    }
    return false;
  }

  /**
   * @param int[] $conditions
   *
   * @return bool
   */
  public static function areConditionsWithinFunctionBeforeClass(array $conditions) {
    // Return true if the token conditions are within a function before
    // they are within a class.
    $classTypes = [T_CLASS, T_ANON_CLASS, T_TRAIT];
    foreach (array_reverse($conditions, true) as $scopePtr => $scopeCode) {
      if (in_array($scopeCode, $classTypes)) {
        return false;
      }
      if ($scopeCode === T_FUNCTION) {
        return true;
      }
    }
    return false;
  }

  /**
   * @param File $phpcsFile
   * @param int $openPtr
   *
   * @return int|bool
   */
  public static function findPreviousFunctionPtr(File $phpcsFile, $openPtr) {
    // Function names are T_STRING, and return-by-reference is T_BITWISE_AND,
    // so we look backwards from the opening bracket for the first thing that
    // isn't a function name, reference sigil or whitespace and check if it's a
    // function keyword.
    $functionPtrTypes = [T_STRING, T_WHITESPACE, T_BITWISE_AND];
    return $phpcsFile->findPrevious($functionPtrTypes, $openPtr - 1, null, true, null, true);
  }

  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return int|bool
   */
  public static function findFunctionCall(File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();

    $openPtr = Helpers::findContainingOpeningBracket($phpcsFile, $stackPtr);
    if (is_int($openPtr)) {
      // First non-whitespace thing and see if it's a T_STRING function name
      $functionPtr = $phpcsFile->findPrevious(T_WHITESPACE, $openPtr - 1, null, true, null, true);
      if ($tokens[$functionPtr]['code'] === T_STRING) {
        return $functionPtr;
      }
    }
    return false;
  }

  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return array[]|false
   */
  public static function findFunctionCallArguments(File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();

    // Slight hack: also allow this to find args for array constructor.
    if (($tokens[$stackPtr]['code'] !== T_STRING) && ($tokens[$stackPtr]['code'] !== T_ARRAY)) {
      // Assume $stackPtr is something within the brackets, find our function call
      $stackPtr = Helpers::findFunctionCall($phpcsFile, $stackPtr);
      if ($stackPtr === false) {
        return false;
      }
    }

    // $stackPtr is the function name, find our brackets after it
    $openPtr = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, null, true, null, true);
    if (($openPtr === false) || ($tokens[$openPtr]['code'] !== T_OPEN_PARENTHESIS)) {
      return false;
    }

    if (!isset($tokens[$openPtr]['parenthesis_closer'])) {
      return false;
    }
    $closePtr = $tokens[$openPtr]['parenthesis_closer'];

    $argPtrs = [];
    $lastPtr = $openPtr;
    $lastArgComma = $openPtr;
    $nextPtr = $phpcsFile->findNext(T_COMMA, $lastPtr + 1, $closePtr);
    while (is_int($nextPtr)) {
      if (Helpers::findContainingOpeningBracket($phpcsFile, $nextPtr) == $openPtr) {
        // Comma is at our level of brackets, it's an argument delimiter.
        array_push($argPtrs, range($lastArgComma + 1, $nextPtr - 1));
        $lastArgComma = $nextPtr;
      }
      $lastPtr = $nextPtr;
      $nextPtr = $phpcsFile->findNext(T_COMMA, $lastPtr + 1, $closePtr);
    }
    array_push($argPtrs, range($lastArgComma + 1, $closePtr - 1));

    return $argPtrs;
  }

  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return int
   */
  public static function findWhereAssignExecuted(File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();

    //  Write should be recorded at the next statement to ensure we treat the
    //  assign as happening after the RHS execution.
    //  eg: $var = $var + 1; -> RHS could still be undef.
    //  However, if we're within a bracketed expression, we take place at the
    //  closing bracket, if that's first.
    //  eg: echo (($var = 12) && ($var == 12));
    $semicolonPtr = $phpcsFile->findNext(T_SEMICOLON, $stackPtr + 1, null, false, null, true);
    $commaPtr = $phpcsFile->findNext(T_COMMA, $stackPtr + 1, null, false, null, true);
    $closePtr = false;
    $openPtr = Helpers::findContainingOpeningBracket($phpcsFile, $stackPtr);
    if ($openPtr !== false) {
      if (isset($tokens[$openPtr]['parenthesis_closer'])) {
        $closePtr = $tokens[$openPtr]['parenthesis_closer'];
      }
    }

    // Return the first thing: comma, semicolon, close-bracket, or stackPtr if nothing else
    $assignEndTokens = [$commaPtr, $semicolonPtr, $closePtr];
    $assignEndTokens = array_filter($assignEndTokens); // remove false values
    sort($assignEndTokens);
    if (empty($assignEndTokens)) {
      return $stackPtr;
    }
    return $assignEndTokens[0];
  }

  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return int|bool
   */
  public static function isNextThingAnAssign(File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();

    // Is the next non-whitespace an assignment?
    $nextPtr = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, null, true, null, true);
    if ($nextPtr !== false) {
      if ($tokens[$nextPtr]['code'] === T_EQUAL) {
        return $nextPtr;
      }
    }
    return false;
  }

  /**
   * @param string $varName
   *
   * @return string
   */
  public static function normalizeVarName($varName) {
    $result = preg_replace('/[{}$]/', '', $varName);
    return $result ? $result : $varName;
  }

  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return int|bool
   */
  public static function findFunctionPrototype(File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();

    $openPtr = Helpers::findContainingOpeningBracket($phpcsFile, $stackPtr);
    if (! is_int($openPtr)) {
      return false;
    }
    $functionPtr = Helpers::findPreviousFunctionPtr($phpcsFile, $openPtr);
    if (($functionPtr !== false) && ($tokens[$functionPtr]['code'] === T_FUNCTION)) {
      return $functionPtr;
    }
    return false;
  }

  /**
   * @param File $phpcsFile
   * @param int $stackPtr
   *
   * @return int|false
   */
  public static function findVariableScope(File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();
    $token  = $tokens[$stackPtr];

    $in_class = false;
    if (!empty($token['conditions'])) {
      foreach (array_reverse($token['conditions'], true) as $scopePtr => $scopeCode) {
        if (($scopeCode === T_FUNCTION) || ($scopeCode === T_CLOSURE)) {
          return $scopePtr;
        }
        if (in_array($scopeCode, [T_CLASS, T_ANON_CLASS, T_INTERFACE, T_TRAIT])) {
          $in_class = true;
        }
      }
    }

    $scopePtr = Helpers::findFunctionPrototype($phpcsFile, $stackPtr);
    if (is_int($scopePtr)) {
      return $scopePtr;
    }

    if ($in_class) {
      // Member var of a class, we don't care.
      return false;
    }

    // File scope, hmm, lets use first token of file?
    return 0;
  }

  /**
   * @param string $message
   *
   * @return void
   */
  public static function debug($message) {
    if (! defined('PHP_CODESNIFFER_VERBOSITY')) {
      return;
    }
    if (PHP_CODESNIFFER_VERBOSITY > 3) {
      echo PHP_EOL . "VariableAnalysisSniff: DEBUG: $message" . PHP_EOL;
    }
  }

  /**
   * @param string $pattern
   * @param string $value
   *
   * @return string[]
   */
  public static function splitStringToArray($pattern, $value) {
    $result = preg_split($pattern, $value);
    return is_array($result) ? $result : [];
  }
}
