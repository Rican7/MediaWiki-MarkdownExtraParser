<?php
/**
 * MarkdownExtraParser - A quick MediaWiki hook for using a Markdown parser
 *
 * MediaWiki's sweet, but Markdown's the "new hotness (steez)".
 * .... yea, anyway, so this is a quick piece of code for
 * hooking MediaWiki's parser to use Michael Fortin's PHP Markdown Extra
 * library (http://michelf.ca/projects/php-markdown/)
 *
 * @author      Trevor Suarez (Rican7)
 * @copyright   2013 Trevor Suarez
 * @license     MIT - http://www.opensource.org/licenses/mit-license.php
 */




/**
 * MarkdownExtraParser 
 *
 * MediaWiki content parser designed to utilize Michael Fortin's
 * PHP-Markdown Extra library
 *
 * @link http://michelf.ca/projects/php-markdown/
 */
class MarkdownExtraParser {

	public static function parseAsMarkdown( &$parser, &$text ) {
		$text = Markdown( $text );
		return true;
	}

} // End class MarkdownExtraParser


 // Running MediaWiki?
if ( defined( 'MEDIAWIKI' ) ) {

	// Define our parser to use our override
	@define( 'MARKDOWN_PARSER_CLASS',  'MarkdownExtraOverride' );

	// Require the Markdown library
	require_once( __DIR__ . DIRECTORY_SEPARATOR . 'markdown.php' );

	// Register our MediaWiki parser hooks
	$wgHooks['ParserBeforeStrip'][] = array( 'MarkdownExtraParser::parseAsMarkdown' );
	// $wgHooks['ParserAfterStrip'][] = array( $markdownExtraParser, 'stripParagraphTags' );

} // End MediaWiki env


/**
 * MarkdownExtraOverride 
 *
 * Used to extend and override some method declarations,
 * so we don't have to edit the Markdown library's source
 * 
 * @uses MarkdownExtra_Parser
 */
class MarkdownExtraOverride extends MarkdownExtra_Parser {

	function formParagraphs($text) {
	#
	#	Params:
	#		$text - string to process with html <p> tags
	#
		# Strip leading and trailing lines:
		$text = preg_replace('/\A\n+|\n+\z/', '', $text);
		
		$grafs = preg_split('/\n{2,}/', $text, -1, PREG_SPLIT_NO_EMPTY);

		#
		# Wrap <p> tags and unhashify HTML blocks
		#
		foreach ($grafs as $key => $value) {
			$value = trim($this->runSpanGamut($value));
			
			# Check if this should be enclosed in a paragraph.
			# Clean tag hashes & block tag hashes are left alone.
			$is_p = !preg_match('/^B\x1A[0-9]+B|^C\x1A[0-9]+C$/', $value);
			
			if ($is_p) {
				// $value = "<p>$value</p>";
			}
			$grafs[$key] = $value;
		}
		
		# Join grafs in one text, then unhash HTML tags. 
		$text = implode("\n\n", $grafs);
		
		# Finish by removing any tag hashes still present in $text.
		$text = $this->unhash($text);
		
		return $text;
	}

} // End class MarkdownExtraOverride
/**
 *  
 */
