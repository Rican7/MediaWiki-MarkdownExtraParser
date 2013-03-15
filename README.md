# MarkdownExtraParser

A quick MediaWiki hook for using a Markdown parser

================

## Tell Me More

[MediaWiki's](http://www.mediawiki.org/) sweet, but [Markdown's](http://daringfireball.net/projects/markdown/) the "new hotness (steez)". .... yea, anyway, so this is a quick piece of code for hooking MediaWiki's parser to use [Michael Fortin's](http://michelf.ca) [PHP Markdown Extra library](http://michelf.ca/projects/php-markdown/)

## Installation

1. Create a folder in your "$IP/extensions" directory called **"MarkdownExtraParser"**
    - Note: $IP is your MediaWiki install directory
	- You should have something like this: $IP/extensions/MarkdownExtraParser/
2. Clone this repo into your new directory (or download the zip)
3. Download Michael Fortin's [PHP Markdown Extra library](http://michelf.ca/projects/php-markdown/)
4. Extract and copy the **"markdown.php"** file into your new "$IP/extensions/MarkdownExtraParser/" directory
5. Enable the extension by adding the following line to your "LocalSettings.php" file:

```php
require_once( "$IP/extensions/MarkdownExtraParser/MarkdownExtraParser.php" );
```

## Configuration

Before "requiring" the extension, you can set an array variable to hold some configuration settings for MarkdownExtraParser, like so:

```php
// MarkdownExtraParser
$MarkdownExtraParserOptions = array(
	'use_raw_html' => true,
);
```

### Available options

- **'use_raw_html'** - Allows for more advanced markdown-to-HTML conversions, such as image tags, etc.
