<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

trait DocBlockTrait
{
    protected $comments = [];

    public function setComments(array $comments)
    {
        $this->comments = $comments;
    }

    public function getComments(bool $returnLineBreakWhenEmpty = false)
    {
        if (empty($this->comments)) {
            return $returnLineBreakWhenEmpty ? "\n" : null;
        }

        $ret = "\n/**\n";
        foreach ($this->comments as $comment) {
            $ret .= ' * ' . $comment . "\n";
        }
        $ret .= ' */';

        return $ret;
    }

    public function addComment(string $comment)
    {
        $this->comments[] = $comment;
    }
}
