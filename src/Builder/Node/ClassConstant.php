<?php
/**
 * Copyright (c) 2017 JD Williams
 *
 * This file is part of PHP-Genny, a library built by JD Williams. PHP-Genny is free software; you can
 * redistribute it and/or modify it under the terms of the GNU General Public License as published by the
 * Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 *
 * PHP-Genny is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details. You should have received a copy of the GNU Lesser General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * You should have received a copy of the GNU General Public License along with Unify. If not, see
 * <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\DocBlockTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use JDWil\PhpGenny\Builder\Node\Traits\StaticTrait;
use JDWil\PhpGenny\Builder\Node\Traits\VisibilityTrait;
use PhpParser\Node\Const_;
use PhpParser\Node\Stmt\ClassConst;

/**
 * Class ClassConstant
 */
class ClassConstant extends AbstractNode
{
    use VisibilityTrait;
    use StaticTrait;
    use NestedNodeTrait;
    use DocBlockTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var AbstractNode
     */
    protected $value;

    /**
     * @param string $name
     * @param AbstractNode $value
     * @return ClassConstant
     */
    public static function new(string $name, AbstractNode $value): ClassConstant
    {
        $ret = new ClassConstant();
        $ret->name = $name;
        $ret->value = $value;
        $ret->static = false;

        return $ret;
    }

    /**
     * @return Class_|Interface_
     * @throws \Exception
     */
    public function done()
    {
        if (!$this->parent instanceof Class_ && !$this->parent instanceof Interface_) {
            throw new \Exception('Parent of ClassConstant must be an instance of Class_ or Interface_');
        }

        return $this->parent;
    }

    /**
     * @return ClassConst
     */
    public function getStatements(): ClassConst
    {
        $flags = $this->addVisibilityFlags(0);
        $flags = $this->addStaticFlag($flags);

        return new ClassConst([new Const_($this->name, $this->value->getStatements())], $flags);
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'value' => $this->value
        ];
    }
}
