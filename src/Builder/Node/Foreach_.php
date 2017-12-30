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

class Foreach_ extends Builder
{
    /**
     * @var AbstractNode
     */
    protected $subject;

    /**
     * @var AbstractNode
     */
    protected $valueVar;

    /**
     * @var AbstractNode|null
     */
    protected $keyVar;

    /**
     * @var bool
     */
    protected $byRef;

    /**
     * @param AbstractNode $subject
     * @param AbstractNode $valueVar
     * @param AbstractNode|null $keyVar
     * @param bool $byRef
     * @return Foreach_
     */
    public static function new(
        AbstractNode $subject,
        AbstractNode $valueVar,
        AbstractNode $keyVar = null,
        bool $byRef = false
    ): Foreach_ {
        $ret = new static();
        $ret->subject = $subject;
        $ret->valueVar = $valueVar;
        $ret->keyVar = $keyVar;
        $ret->byRef = $byRef;

        return $ret;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of Foreach_ must be a Builder');
        }

        return $this->parent;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'nodes' => parent::getNodes(),
            'subject' => $this->subject,
            'valueVar' => $this->valueVar,
            'keyVar' => $this->keyVar
        ];
    }

    public function getStatements()
    {
        $params = [
            'byRef' => $this->byRef,
            'stmts' => parent::getStatements()
        ];

        if (null !== $this->keyVar) {
            $params['keyVar'] = $this->keyVar->getStatements();
        }

        return new \PhpParser\Node\Stmt\Foreach_(
            $this->subject->getStatements(),
            $this->valueVar->getStatements(),
            $params
        );
    }
}
