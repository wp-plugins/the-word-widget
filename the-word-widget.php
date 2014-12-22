<?php
/**
Plugin Name: The Word Widget
Plugin URI: http://bible2.net/download/the-word-widget-for-wordpress/
Description: Shows two Bible sayings per day: "The Word" by project Bible 2.0, available in over 10 languages, got remotely for each day
Version: 0.4
Author: Helmut Steeb
Author URI: http://jsteeb.de
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

==============================================================================
Copyright 2014  Helmut Steeb (email: bible2.net/contact/)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (!class_exists('b2_TheWordWidget')) {

  require_once(dirname(__FILE__)."/includes/log.php");
  require_once(dirname(__FILE__)."/includes/server-access.php");
  require_once(dirname(__FILE__)."/includes/local.php");
  if (is_admin()) {
    require_once(dirname(__FILE__)."/includes/admin-form.php");
    require_once(dirname(__FILE__)."/includes/the-word-widget-admin.php");
  }

  /**
   * If WP_DEBUG and WP_DEBUG_LOG are true, writes info to the PHP log using error_log() via log.php.
   */
  class b2_TheWordWidget extends WP_Widget {

    const DOMAIN = "http://bible2.net"; # not re-used - PHP 5.5.3: no expression in constant :-(
    const LISTURL= "http://bible2.net/service/TheWord/twd11?format=atom";
    const WORDURL= "http://bible2.net/service/today/inline/"; # used with trailingslashit


    function __construct() {
      $Options = array(
          'description' => __("shows two selected Bible sayings for each day: The Word by project Bible 2.0, available in over 10 languages", "thewordwidget")
      );
      parent::__construct(
       'thewordwidget' # base ID
       , __('The Word', 'thewordwidget') # name displayed on the configuration page
      , $Options # passed to wp_register_sidebar_widget(), description: shown on the configuration page
      );
      add_action('plugins_loaded', array(&$this, 'translation'), 2);
    }
  

    function form($instance) {
      $Defaults = array('bible' => 'EnglishStandardVersion');
      $instance = wp_parse_args((array) $instance, $Defaults);
      $currentBible = $instance["bible"];

      $TwdFileList = Local::getCachedTwdFileList();
      if (!$TwdFileList) {
        $TwdFileList = ServerAccess::getTwdFileListFromUrl(self::LISTURL);
        if (!$TwdFileList) {
          printf("<p>" . __("Failed to retrieve Bible list from URL %s.", 'thewordwidget') . "</p>", $url);
          return;
        }

        # sort $TwdFileList for output in form
        usort($TwdFileList, array(&$this, "_cmpBibleName"));
  
        # store for use in next call
        Local::setCachedTwdFileList($TwdFileList);
      }
      # $TwdFileList truthy

      # create HTML
      AdminForm::html($this, $TwdFileList, $currentBible, self::DOMAIN);
    }


    function update($new_instance, $old_instance)
    {
      $instance = $old_instance;

      $bible = $instance['bible'] = preg_replace("[^A-Za-z0-9_]", "", $new_instance['bible']);
      if (!$bible) {
        b2_Log::debug("the-word-widget.php::update: invalid Bible name $bible");
        return false;
      }

      return $instance;
    }

    function widget($args, $instance) {
      $bible = isset($instance["bible"]) ? $instance["bible"] : "";

      $date = date("Y-m-d"); # use one date consistently
      $theWord = Local::getCachedTheWord($date, $bible);
      if (!$theWord) {
        $theWord = ServerAccess::getTheWordFromUrl(trailingslashit(self::WORDURL) . $bible);
        if (!$theWord) {
          # on error, avoid output
          return;
        }
        Local::setCachedTheWord($theWord, $date, $bible);
      }
      # $theWord truthy

      # display The Word
      echo $args['before_widget'];
      echo $theWord;
      echo $args['after_widget'];
    }
    
    # --- Private ---
  
    private static function _cmpBibleName($a, $b) { 
      return strcmp($a["bibleName"], $b["bibleName"]);
    }

    private function translation()
    {
      load_plugin_textdomain('the-word-widget', false, 'the-word-widget/languages');
    }

  }
  
  add_action('widgets_init',
    create_function('', 'return register_widget("b2_TheWordWidget");')
  );
}
?>
