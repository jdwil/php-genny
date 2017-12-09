<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

use JDWil\PhpGenny\ValueObject\Visibility;

interface HasConstantsInterface
{
    /**
     * @param string $name
     * @param $value
     * @param Visibility|null $visibility
     * @param bool $static
     */
    public function addConstant(string $name, $value, Visibility $visibility = null, bool $static = false);

    /**
     * @return array
     */
    public function getConstants(): array;
}
