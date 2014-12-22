=== The Word Widget ===
Contributors: HSteeb
Tags: bible, bibel, losung, devotional, verse of the day, votd, daily, täglich, sidebar, widget, Almeida Revista E Atualizada, An Bíobla Naofa, Bybel in Afrikaans, Chinese Union Version, English Standard Version, Hoffnung für Alle, Jubiläums-Bibel, Karoli, Kiswahili Contemporary Version, Kutsal Kitap, Modern Hebrew, Nuova Riveduta, O‘zbek tilidagi Muqaddas Kitob, Reina-Valera, Schlachter, Segond, Thai Holy Bible, Tübinger Bibel

Requires at least: not known
Tested up to: 4.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shows two Bible sayings per day: "The Word" by project Bible 2.0, available in
over 10 languages, got remotely for each day

== Description ==

The plugin provides a widget which you can place into one of the widget areas
provided by your theme (in the WordPress admin area: Appearance | Widgets).

The widget configuration retrieves the list of available Bible editions of the
current year remotely from http://bible2.net and lets you select one Bible
edition. On each day, the widget retrieves the two sayings for the day from
bible2.net and displays them.

### Project Bible 2.0

Project [Bible 2.0](http://bible2.net/) collects cross-references between
selected Bible verses, formats the verses nicely and publishes two
cross-referenced verses ("sayings") for each day of the year in over 10
languages, available for free download and as a remote service.

### Bible Editions Available

As of 2014-02, The Word is available for 2014 in the following Bible editions
and languages (see http://bible2.net/download/bible-editions-available/):

* Almeida Revista E Atualizada (Português Portuguese pt)
* An Bíobla Naofa 1981 (Gaeilge Irish ga)
* Bybel in Afrikaans (1983-vertaling) (Afrikaans af)
* Chinese Union Version (Simplified Chinese) (简体字 Simplified Chinese zh-Hans)
* Chinese Union Version (Traditional Chinese) (繁體字 Traditional Chinese zh-Hant) 
* English Standard Version (English en)
* Hoffnung für Alle (Deutsch German de)
* Jubiläums-Bibel (русский Russian ru)
* Karoli 1990 (Magyar Hungarian hu)
* Kiswahili Contemporary Version 2006 (Kiswahili sw)
* Kutsal Kitap 2001 (Türkçe Turkish tr)
* Modern Hebrew 2004 (עברית Hebrew he)
* Nuova Riveduta 1994 (Italiano Italian it)
* O‘zbek tilidagi Muqaddas Kitob (2012) Cyrillic (Oʻzbekcha Usbek (Cyrillic) uz-Cyrl)
* O‘zbek tilidagi Muqaddas Kitob (2012) Latin (Oʻzbekcha Usbek (Latin) uz-Latn)
* Reina-Valera 1995 (Español Spanish es)
* Schlachter 2000 (Deutsch German de)
* Segond 21 (Français French fr)
* Thai Holy Bible 1971 (ภาษาไทย Thai th)
* Tübinger Bibel (Deutsch German de)

*See: [Project Bible 2.0 bible2.net](http://bible2.net/)*

### System Requirements

* PHP: tested with 5.3.10 and 5.5.9

### License

1. Plugin

The WordPress plugin is licensed under GPLv2 or later.

2. Bible Texts (got remotely per day)

The license conditions for the Bible texts (verses) are defined by the
publisher of the respective Bible edition. They are contained in the .twd XML
files, and are also shown in http://bible2.net/copyright/.

3. Related Bible References (got remotely per day)

The project Bible 2.0 provides pairs of related Bible references.
The Word associates one pair of Bible references with a certain day, respectively.
The association of Bible references into pairs and of such pairs to days of a certain year is subject to

  Licence "Creative Commons 2.0
  http://creativecommons.org/licenses/by-nc-nd/2.0/
  (Attribution, Noncommercial, No Derivative Works).

With each publication, the following statement
with a link to http://bible2.net must be available for the user
(e.g. by adding a link to the copyright page):

  Association of Bible references by project Bible 2.0


== Installation ==

1. unpack the zip file into your WordPress plugin folder `/wp-content/plugins/`
2. activate the plugin within the 'Plugins' menu in the WordPress admin area
3. put the widget into one of your widget areas
4. select a Bible edition, Save

### Layout adaptation

The widget output uses the following CSS classes which you may adapt in your
stylesheet (CSS):

* TheWord
* TL
* Parol
* IL
* L
* SL
	
An example css file is included in the plugin zip file. It includes CSS to
either show the verses with line breaks (on a wider display) or without the
line breaks (on a smaller display). You may need to adapt the rules, depending
on the actual width of your widget area.

== Screenshots ==

1. The widget configuration
2. The widget in a wider widget area (line breaks preserved)
3. The widget in a small widget area (no line breaks)

== Changelog ==

= 0.3 =
* the widget does not store a .twd file per year but uses the daily online service

= 0.2 =
* the widget form (for admin) retrieves the list of Bible editions from bible2.net,
* ... lets admin select the Bible edition
* ... and retrieves The Word .twd file for the selected Bible edition from bible2.net.
* the widget shows The Word from the Bible edition selected in the widget form.

= 0.1 =
* initial version

== Upgrade Notice ==
