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

namespace JDWil\PhpGenny\Writer;

use JDWil\PhpGenny\Builder\BuilderFactory;
use JDWil\PhpGenny\Type\Class_;
use JDWil\PhpGenny\Type\Interface_;
use JDWil\PhpGenny\Type\Trait_;
use PhpParser\PrettyPrinterAbstract;

/**
 * Class TypeWriter
 */
class TypeWriter
{
    /**
     * @var string
     */
    protected $baseDirectory;

    /**
     * @var string
     */
    protected $namespacePrefix;

    /**
     * @var BuilderFactory
     */
    protected $factory;

    /**
     * @var PrettyPrinterAbstract
     */
    protected $printer;

    /**
     * Writer constructor.
     * @param BuilderFactory $builderFactory
     * @param PrettyPrinterAbstract $printer
     */
    public function __construct(BuilderFactory $builderFactory, PrettyPrinterAbstract $printer)
    {
        $this->baseDirectory = './';
        $this->namespacePrefix = '';
        $this->factory = $builderFactory;
        $this->printer = $printer;
    }

    /**
     * @param Class_[]|Interface_[]|Trait_[] $types
     * @return bool
     * @throws \Exception
     */
    public function writeAll(array $types): bool
    {
        foreach ($types as $type) {
            if (!$this->write($type)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Class_|Interface_|Trait_ $o
     * @return bool
     * @throws \Exception
     */
    public function write($o): bool
    {
        if ($o instanceof Class_) {
            $builder = $this->factory->constructClassBuilder($o);
        } else if ($o instanceof Interface_) {
            $builder = $this->factory->constructInterfaceBuilder($o);
        } else if ($o instanceof Trait_) {
            $builder = $this->factory->constructTraitBuilder($o);
        } else {
            throw new \Exception('Invalid type');
        }

        $path = sprintf(
            '%s/%s/%s',
            $this->baseDirectory,
            $this->namespaceToPath($this->getNamespacePrefix()),
            $this->namespaceToPath($o->getNamespace())
        );

        if (!@mkdir($path, 0777, true) && !is_dir($path)) {
            throw new \Exception('Could not make directory');
        }

        $filePath = sprintf('%s/%s.php', $path, $o->getName());

        try {
            file_put_contents($filePath, $this->printer->prettyPrintFile($builder->getStatements()));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getBaseDirectory(): string
    {
        return $this->baseDirectory;
    }

    /**
     * @param string $baseDirectory
     */
    public function setBaseDirectory(string $baseDirectory)
    {
        if (substr($baseDirectory, -1) === '/') {
            $baseDirectory = (string) substr($baseDirectory, 0, -1);
        }

        $this->baseDirectory = $baseDirectory;
    }

    /**
     * @return string
     */
    public function getNamespacePrefix(): string
    {
        return $this->namespacePrefix;
    }

    /**
     * @param string $namespacePrefix
     */
    public function setNamespacePrefix(string $namespacePrefix)
    {
        $this->namespacePrefix = $namespacePrefix;
    }

    /**
     * @param string $namespace
     * @return string
     */
    private function namespaceToPath(string $namespace): string
    {
        return str_replace('\\', '/', $namespace);
    }
}
