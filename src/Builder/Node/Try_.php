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
use PhpParser\Node\Stmt\TryCatch;

class Try_ extends Builder
{
    /**
     * @var Catch_[]
     */
    public $catches;

    /**
     * @var Finally_
     */
    public $finally;

    /**
     * @return Try_
     */
    public static function new(): Try_
    {
        $ret = new static();
        $ret->catches = [];

        return $ret;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of Catch_ must be a Builder');
        }

        return $this->parent;
    }

    /**
     * @param \JDWil\PhpGenny\Type\Class_[]|string[] $exceptions
     * @param string $name
     * @return Catch_
     */
    public function catch(array $exceptions, string $name): Catch_
    {
        $e = [];
        foreach ($exceptions as $exception) {
            if ($exception instanceof \JDWil\PhpGenny\Type\Class_) {
                $e[] = $exception->getFqn();
            } else {
                $e[] = $exception;
            }
        }

        $catch = Catch_::new($e, $name);
        $catch->setParent($this);
        $this->catches[] = $catch;

        return $catch;
    }

    public function getStatements()
    {
        $finally = null === $this->finally ?
            null :
            $this->finally->getStatements()
        ;

        return new TryCatch(
            parent::getStatements(),
            array_map(function (Catch_ $catch) {
                return $catch->getStatements();
            }, $this->catches),
            $finally
        );
    }
}
