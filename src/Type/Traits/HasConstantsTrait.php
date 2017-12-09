<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type\Traits;

use JDWil\PhpGenny\ValueObject\Visibility;

trait HasConstantsTrait
{
    /**
     * @var array
     */
    protected $constants = [];

    /**
     * @param string $name
     * @param $value
     * @param Visibility|null $visibility
     * @param bool $static
     */
    public function addConstant(string $name, $value, Visibility $visibility = null, bool $static = false)
    {
        $this->constants[] = [
            'name' => $name,
            'value' => $value,
            'visibility' => $visibility,
            'static' => $static
        ];
    }

    /**
     * @return array
     */
    public function getConstants(): array
    {
        return $this->constants;
    }
}
