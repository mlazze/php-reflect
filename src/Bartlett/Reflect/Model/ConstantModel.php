<?php
/**
 * ConstantModel represents a constant definition.
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

namespace Bartlett\Reflect\Model;

use PhpParser\Node;
use PhpParser\PrettyPrinter;

/**
 * The ConstantModel class reports information about a constant.
 *
 * @category PHP
 * @package  PHP_Reflect
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version  Release: @package_version@
 * @link     http://php5.laurent-laville.org/reflect/
 * @since    Class available since Release 2.0.0RC1
 */
class ConstantModel extends AbstractModel
{
    /**
     * Get the namespace name where the constant is defined.
     *
     * @return string
     */
    public function getNamespaceName()
    {
        $parts = $this->node->consts[0]->namespacedName->parts;
        array_pop($parts);
        return implode('\\', $parts);
    }

    /**
     * Gets the constant name.
     *
     * @return string
     */
    public function getName()
    {
        return (string) $this->node->consts[0]->namespacedName;
    }

    /**
     * Get the short name of the constant (without the namespace part).
     *
     * @return string
     */
    public function getShortName()
    {
        return (string) $this->node->consts[0]->name;
    }

    /**
     * Gets the constant value.
     *
     * @return mixed
     */
    public function getValue()
    {
        $prettyPrinter = new PrettyPrinter\Standard;
        return trim(
            $prettyPrinter->prettyPrintExpr($this->node->consts[0]->value),
            '"\''
        );
    }

    /**
     * Checks whether a constant is defined in a namespace.
     *
     * @return bool TRUE if it's in a namespace, otherwise FALSE
     */
    public function inNamespace()
    {
        return $this->node->consts[0]->namespacedName->isQualified();
    }

    /**
     * Checks whether it's an internal constant.
     *
     * @return bool TRUE if it's internal, otherwise FALSE
     */
    public function isInternal()
    {
        return false;
    }

    /**
     * Checks whether it's a magic constant.
     *
     * @link http://www.php.net/manual/en/language.constants.predefined.php
     * @return bool TRUE if it's magic, otherwise FALSE
     */
    public function isMagic()
    {
        return false;
    }

    /**
     * Checks whether it's a scalar constant.
     *
     * @return bool TRUE if it's scalar, otherwise FALSE
     */
    public function isScalar()
    {
        return ($this->node->consts[0]->value instanceof Node\Scalar);
    }

    /**
     * Returns the string representation of the ConstantModel object.
     *
     * @return string
     */
    public function __toString()
    {
        $eol = "\n";

        return sprintf(
            'Constant [ %s ] { %s }%s',
            $this->getName(),
            $this->getValue(),
            $eol
        );
    }
}
