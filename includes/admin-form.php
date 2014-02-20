<?php

class AdminForm
{
  /**
   * Emits HTML for the admin form to select a Bible edition.
   *
   * @param $Widget the WP_Widget to show
   * @param $TwdFileList array of array of "bible" etc.
   * @param $currentBible which element of $TwdFileList to select
   * @param $domain info to show
   */
  static function html($Widget, $TwdFileList, $currentBible, $domain)
  {
    echo "<p>"
      . "<label for='" . $Widget->get_field_id("bible") . "'>" . __("Bible:", 'thewordwidget') . "</label>\n"
      . "<select name='" . $Widget->get_field_name("bible") . "' id='" . $Widget->get_field_id("bible") . "'>\n"
      ;

    foreach ($TwdFileList as $TwdFile) {
      $selected = selected($TwdFile["bible"], $currentBible, false);
      printf("  <option value='%1\$s'%2\$s data-url='" . $TwdFile["url"]. "'>%3\$s (%4\$s)</option>\n"
        , esc_attr($TwdFile["bible"])
        , $selected
        , esc_attr($TwdFile["bibleName"])
        , esc_attr($TwdFile["lang"]
        ));
    }
    printf("</select>\n"
      . "</p>"
      . "<p>"
      . __("The widget will get The Word for the selected Bible and the current day remotely from %s.",
           'thewordwidget')
      . "</p>"
      , $domain)
      ;
  }
}