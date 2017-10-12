<?php
/**
 * Function test
 *
 * @package tssfw
 */

/**
 * Sample test case.
 */
class Tssfw_Basic_Test extends WP_UnitTestCase {

	/**
	 * A single example test
	 *
	 */
	function test_domain() {
		// Check domain exists.
		$this->assertTrue( is_textdomain_loaded( 'taro-nickname' ) );
	}

}
