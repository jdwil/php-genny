<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

/**
 * Interface HasMethodsInterface
 */
interface HasMethodsInterface
{
    /**
     * @param Method $method
     */
    public function addMethod(Method $method);

    /**
     * @return Method[]
     */
    public function getMethods(): array;

    /**
     * @param Method $method
     * @return bool
     */
    public function hasMethod(Method $method): bool;

    /**
     * @param Method $method
     */
    public function removeMethod(Method $method);
}
