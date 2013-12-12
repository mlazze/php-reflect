<?php
/**
 * Base of Reflect manager interface.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  PHP_Reflect
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  GIT: $Id$
 * @link     http://php5.laurent-laville.org/reflect/
 */

namespace Bartlett\Reflect;

use Bartlett\Reflect\Parser\ParserInterface;
use Bartlett\Reflect\ProviderManager;

/**
 * Any extension of Reflect should implement this interface.
 *
 * @category PHP
 * @package  PHP_Reflect
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: @package_version@
 * @link     http://php5.laurent-laville.org/reflect/
 * @since    Interface available since Release 2.0.0RC1
 */
interface ManagerInterface
{
    /**
     * Pushes a parser on to the stack.
     *
     * @param ParserInterface $parser Instance of your custom parser
     *
     * @return void
     */
    public function pushParser(ParserInterface $parser);

    /**
     * Pops a parser from the stack.
     *
     * @return ParserInterface
     * @throws \LogicException if parsers stack is empty
     */
    public function popParser();

    /**
     * Returns an instance of the current provider manager.
     *
     * @return ProviderManager
     */
    public function getProviderManager();

    /**
     * Defines the current provider manager.
     *
     * @param ProviderManager $manager Instance of your custom source provider
     *
     * @return void
     */
    public function setProviderManager(ProviderManager $manager);
}
