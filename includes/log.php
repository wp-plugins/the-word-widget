<?php

class b2_Log
{

  /**
   * @param $info string to debug
   * If WP_DEBUG and WP_DEBUG_LOG are true, writes $info to the PHP log using error_log.
   * - in wp-config.php, add define('WP_DEBUG', true); define('WP_DEBUG_LOG', true);
   * - see the result in wp-content/debug.log
   */
  static function debug($info)
  {
    if (true === WP_DEBUG) {
      error_log("b2:" . $info);
    }
  }

}