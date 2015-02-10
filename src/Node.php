<?php

class Node
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var Node[]
     */
    private $subNodes;

    /**
     * @param string $value
     * @param Node[] $subNodes
     */
    public function __construct($value, $subNodes = [])
    {
        $this->value = $value;
        $this->subNodes = $subNodes;
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->value) || $this->subNodesAreEmpty();
    }

    /**
     * @return boolean
     */
    private function subNodesAreEmpty()
    {
        return !array_reduce($this->subNodes, function($carry, Node $subNode) {
            return !$subNode->isEmpty() && $carry;
        }, true);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strtr($this->value, $this->subNodes);
    }
}
