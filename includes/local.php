<?php

require_once(dirname(__FILE__)."/log.php");

/**
 * Temporarily store some data locally to save bandwith and server usage.
 */
class Local
{
  const TRANSIENT_LIST = "b2_tww-list";
  const TRANSIENT_WORD = "b2_tww-word";

  static function setCachedTwdFileList($TwdFileList)
  {
    set_transient(self::TRANSIENT_LIST, $TwdFileList, 60*60); # in seconds
  }

  /**
   * @return array of array as passed to setCachedTwdFileList, maybe null.
   */
  static function getCachedTwdFileList()
  {
    return get_transient(self::TRANSIENT_LIST);
  }

  /**
   * @param string $theWord
   * @param string $date for $theWord
   * @param string $bible for $theWord
   */
  static function setCachedTheWord($theWord, $date, $bible)
  {
    $Item = array(
      "date" => $date
    , "bible" => $bible
    , "word" => $theWord
    );
    set_transient(self::TRANSIENT_WORD, $Item, 60*60*24); # in seconds
  }

  /**
   * @param string $date
   * @param string $bible
   * @return null if 
   * - setCachedTheWord has not been called, or
   * - has been called with a different $date or $bible, or
   * - an error occurred;
   * otherwise the string $theWord to display.
   */
  static function getCachedTheWord($date, $bible)
  {
    $Item = get_transient(self::TRANSIENT_WORD);
    return ($Item
      && isset($Item["date" ]) && $Item["date" ] == $date
      && isset($Item["bible"]) && $Item["bible"] == $bible
    ) ? $Item["word"] : null;
  }

  /**
   * delete the cached data set in setCachedTwdFileList() and setCachedTheWord()
   */
  static function clearCache()
  {
    b2_Log::debug("Local::clearCache: cleanup");
    delete_transient(self::TRANSIENT_LIST);
    delete_transient(self::TRANSIENT_WORD);
  }
}