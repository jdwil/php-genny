<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

interface NamespaceInterface
{
    /**
     * @return string|null
     */
    public function getNamespace();

    /**
     * @param string $namespace
     */
    public function setNamespace(string $namespace);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getFqn(): string;
}
