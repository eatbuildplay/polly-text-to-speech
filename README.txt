=== Saber TTS (Text-to-Speech) ===
Contributors: eatbuildplay
Tags: polly, aws, text-to-speech, tts
Donate link: https://eatbuildplay.com/donate/
Requires at least: 5.0
Tested up to: 5.4
Requires PHP: 7.3
Stable tag: 1.1.0
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Provides integration of AWS Polly text-to-speech service. Requires an AWS Cloud account with API credentials and the ACF Pro plugin.

== Description ==
Integrates AWS Polly TTS (text-to-speech) API service. Enables rapid text-to-speech conversion in the WP Admin with an easy-to-use interface built on ACF Pro. Outputs MP3 audio files that can be stored either in an S3 bucket or on your server. Has an option to import to the WP Media library for convenient future access to the speech file.

All conversions completed by Polly are stored as Text Conversion custom post types. This enables you to find your converted audio files easily, and for developers provides a way to query the library of speech conversion files.

A shortcode is provided that will render a given speech conversion in an HTML5 audio tag.

There is a Saber TTS Pro version that provides additional features including Neural Engine support, a wider selection of Polly Voices, and SSML tag support for even more control over speech.

== Installation ==
The easiest way to install Saber TTS is to search for Saber TTS (and/or text-to-speech) through your WP admin plugins page. Once located click install, then once installed click activate.

Alternatively download the zip file from the Saber TTS plugin page, or from the GitHub repo.

You\'ll need an AWS Cloud account and an IAM user that has permissions for AWS Polly. Enter the IAM user ID and token secret on the Saber TTS Settings page.

If you plan to use an AWS S3 bucket for storage of the Polly converted audio files, make sure your IAM user has S3 write permissions. Then copy the region and bucket name into the Saber TTS Settings page.

== Frequently Asked Questions ==
= Does Saber TTS support the Polly Neural Engine? =
No, the Neural Engine is only available in Saber TTS Pro.

= Does Saber TTS support using SSML tags? =
No, SSML tag support is only available in Saber TTS Pro.

= What are the limits on length of text converted in one conversion request? =
The plugin does not impose limits, so the limits are only what is set by AWS Polly. Check the AWS Polly documentation for more details on limits per request.

= Can I paste HTML into the Polly speech conversion text area? =
Saber TTS will read the HTML tags if any are found in the text you send for conversion. This is not usually the goal, so it is better to copy only the text and avoid entering HTML tags.

= Where are all the other voices from Amazon Polly? =
We provide only a limited selection of voices in the free Saber TTS plugin, to unlock the full selection of AWS Polly voices including Neural Engine voices for the best natural speech, try Saber TTS Pro.


== Screenshots ==
1. Convert Text Page

== Changelog ==

= 1.1.0 =
Changed plugin name to Saber TTS from Polly Text-to-Speech during WP Plugin directory review.

= 1.0.1 =
Include readme and improvements to the button text and update message for the convert text page.

= 1.0.1 =
Include exports of the ACF Field Groups.

== Upgrade Notice ==
No upgrade notice is available at this time due to Saber TTS being a new plugin.
