<?php
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
