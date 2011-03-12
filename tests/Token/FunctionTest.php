<?php

if (!defined('TEST_FILES_PATH')) {
    define(
      'TEST_FILES_PATH',
      dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR .
      '_files' . DIRECTORY_SEPARATOR
    );
}

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'PHP/Reflect.php';

spl_autoload_register('PHP_Reflect::autoload');

/**
 * Tests for the PHP_Reflect_Token_FUNCTION class.
 *
 * @package    PHP_Reflect
 * @subpackage Tests
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       https://github.com/llaville/php-reflect
 * @since      Class available since Release 0.1.0
 */
class PHP_Reflect_Token_FunctionTest extends PHPUnit_Framework_TestCase
{
    protected $functions;

    protected function setUp()
    {
        $reflect = new PHP_Reflect();
        $tokens  = $reflect->scan(TEST_FILES_PATH . 'source.php');

        foreach ($tokens as $id => $token) {
            if ($token[0] == 'T_FUNCTION') {
                $this->functions[] = new PHP_Reflect_Token_FUNCTION($token[1], $token[2], $id, $tokens);
            }
        }
    }

    /**
     * @covers PHP_Reflect_Token_FUNCTION::getArguments
     */
    public function testGetArguments()
    {
        $this->assertEquals(array(), $this->functions[0]->getArguments());
        $this->assertEquals(array('$baz' => 'Baz'), $this->functions[1]->getArguments());
        $this->assertEquals(array('$foobar' => 'Foobar'), $this->functions[2]->getArguments());
        $this->assertEquals(array('$barfoo' => 'Barfoo'), $this->functions[3]->getArguments());
    }

    /**
     * @covers PHP_Reflect_Token_FUNCTION::getName
     */
    public function testGetName()
    {
        $this->assertEquals('foo', $this->functions[0]->getName());
        $this->assertEquals('bar', $this->functions[1]->getName());
        $this->assertEquals('foobar', $this->functions[2]->getName());
        $this->assertEquals('barfoo', $this->functions[3]->getName());
    }

    /**
     * @covers PHP_Reflect_Token::getLine
     */
    public function testGetLine()
    {
        $this->assertEquals(5,  $this->functions[0]->getLine());
        $this->assertEquals(10, $this->functions[1]->getLine());
        $this->assertEquals(17, $this->functions[2]->getLine());
        $this->assertEquals(21, $this->functions[3]->getLine());
    }

    /**
     * @covers PHP_Reflect_TokenWithScope::getEndLine
     */
    public function testGetEndLine()
    {
        $this->assertEquals(5,  $this->functions[0]->getEndLine());
        $this->assertEquals(12, $this->functions[1]->getEndLine());
        $this->assertEquals(19, $this->functions[2]->getEndLine());
        $this->assertEquals(23, $this->functions[3]->getEndLine());
    }

    /**
     * @covers PHP_Reflect_Token_FUNCTION::getDocblock
     */
    public function testGetDocblock()
    {
        $this->assertNull($this->functions[0]->getDocblock());
        $this->assertEquals("/**\n     * @param Baz \$baz\n     */", $this->functions[1]->getDocblock());
        $this->assertEquals("/**\n     * @param Foobar \$foobar\n     */", $this->functions[2]->getDocblock());
        $this->assertNull($this->functions[3]->getDocblock());
    }
}