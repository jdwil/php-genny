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

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;

/**
 * Class Switch_
 */
class Switch_ extends AbstractNode
{
    use NestedNodeTrait;

    /**
     * @var AbstractNode
     */
    protected $subject;

    /**
     * @var Case_[]
     */
    protected $cases;

    /**
     * @param AbstractNode $subject
     * @return Switch_
     */
    public static function new(AbstractNode $subject): Switch_
    {
        $ret = new static();
        $ret->subject = $subject;

        return $ret;
    }

    /**
     * @param AbstractNode|null $condition
     * @return Case_
     */
    public function case(AbstractNode $condition = null): Case_
    {
        $case = Case_::new($condition);
        $case->setParent($this);
        $this->cases[] = $case;

        return $case;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of Switch_ must be a Builder');
        }

        return $this->parent;
    }

    /**
     * @return \PhpParser\Node\Stmt\Switch_
     */
    public function getStatements(): \PhpParser\Node\Stmt\Switch_
    {
        return new \PhpParser\Node\Stmt\Switch_(
            $this->subject->getStatements(),
            array_map(function (Case_ $case) {
                return $case->getStatements();
            }, $this->cases)
        );
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'subject' => $this->subject,
            'cases' => $this->cases
        ];
    }
}
