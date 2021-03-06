<?php

require_once(dirname(__FILE__)."/log.php");

class ServerAccess
{
  /**
   * @return array of array("lang", "bible", "bibleName", "url", "year"), i.e. info about TwdFile, or false,
   */
  static function getTwdFileListFromUrl($url)
  {
    b2_Log::debug("ServerAccess::getTwdFileListFromUrl: retrieving '$url'");

    # 2014-12-22 HSteeb:
    # simplexml_load_file fails if allow_url_fopen=off
    # --> fall back to WP mechanism (which uses streams)
    # No idea whether the WP mechanism will work on all server configurations
    # --> keeping two ways may be better than one...
    $TwdList = false;
    $Xml = self::_getXmlUsingSimpleXml($url);
    if (!$Xml) {
      $Xml = self::_getXmlUsingWP($url);
    }
    if ($Xml) {
      $TwdList = self::_parseTwdList($Xml);
    }
    b2_Log::debug("ServerAccess::getTwdFileListFromUrl: " . ($TwdList ? "ok" : "not ok"));
    return $TwdList;
  }

  private static function _getXmlUsingSimpleXml($url)
  {
    b2_Log::debug("ServerAccess::_getXmlUsingSimpleXml: retrieving '$url'");

    $Xml = @simplexml_load_file($url);
    if (!$Xml) {
      b2_Log::debug("ServerAccess::_getXmlUsingSimpleXml: failed to simplexml_load_file('$url').");
    }
    return $Xml;
  }

  private static function _getXmlUsingWP($url)
  {
    b2_Log::debug("ServerAccess::_getXmlUsingWP: retrieving '$url'");

    $Response = wp_remote_get($url);
    if (200 != wp_remote_retrieve_response_code($Response)) {
      b2_Log::debug("ServerAccess::_getXmlUsingWP: failed to get '$url'.");
      return false;
    }
    $body = wp_remote_retrieve_body($Response);

    $Xml = simplexml_load_string($body);
    if (!$Xml) {
      b2_Log::debug("ServerAccess::_getXmlUsingWP: failed to simplexml_load_string from body of URL '$url'.");
    }
    return $Xml;
  }

  private static function _parseTwdList($Xml)
  {
    b2_Log::debug("ServerAccess::_parseTwdList");
    $currentYear = date("Y");
    $TwdFileList = array();

    # Convention for storing .twd file info in Atom format:
    # http://bible2.net/download/online-retrieval-of-twd-1-1-files/
    $langCodePattern       = "[A-Za-z0-9-]+";
    $bibleShortnamePattern = "[A-Za-z0-9]+";
    $yearPattern           = "\d{4}";
    foreach ($Xml->entry as $entry) {
      if ($entry->category["term"] == "file"
          # e.g. <id>http://bible2.net/service/TheWord/twd11/de_HoffnungFuerAlle_2014</id>
          # - language (ISO language code)
          # - Bible short name (A-Za-z0-9)
          # - year
          && preg_match("@/($langCodePattern)_($bibleShortnamePattern)_($yearPattern)$@", $entry->id, $ID)
          # e.g. <title>2014 de Hoffnung für Alle</title>
          # - year
          # - language (ISO language code)
          # - Bible long name (Unicode)
          && preg_match("@^$yearPattern\s+$langCodePattern\s+(.*)@", $entry->title, $Title)
          && $ID[3] == $currentYear
        ) {

        # find <link> with rel="alternate"
        $url = "";
        foreach ($entry->link as $link) {
          if ($link["rel"] == "alternate") {
            # Need (string) cast!
            # Without cast, $url is a SimpleXMLElement which gives an error when used in set_transient:
            # PHP Fatal error:  Uncaught exception 'Exception' with message 'Serialization of 'SimpleXMLElement' is not allowed'
            $url = (string) $link["href"];
          }
        }
        if (!$url) {
          b2_Log::debug("ServerAccess::getTwdFileListFromUrl: missing url in '" . $entry->title . "', skipping file.");
        }
        else {
          $TwdFileList[$ID[2]] = array (
              "lang" => $ID[1]
            , "bible" => $ID[2]
            , "bibleName" => $Title[1]
            , "url" => $url
            , "year" => $currentYear
            );
        }
      }
    }
    return $TwdFileList;
  }


  /**
   * @param string $url ready to use url including Bible
   * @return string $theWord as HTML to display
   */
  static function getTheWordFromUrl($url)
  {
    b2_Log::debug("ServerAccess::getTwdFileListFromUrl: retrieving '$url'");

    $Response = wp_remote_get($url);
    if (200 != wp_remote_retrieve_response_code($Response)) {
      b2_Log::debug("ServerAccess::getTheWordFromUrl: failed to get '$url'.");
      return false;
    }
    return wp_remote_retrieve_body($Response);
  }
}
# Local Variables:
# coding: utf-8
# End:
