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
    public function __construct($value, array $subNodes = [])
    {
        $this->value = $value;
        $this->subNodes = $subNodes;
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        if (empty($this->value)) {
            return true;
        }

        return $this->subNodesAreEmpty();
    }

    /**
     * @return boolean
     */
    private function subNodesAreEmpty()
    {
        if (count($this->subNodes) == 0) {
            return false;
        }
        foreach ($this->subNodes as $subNode) {
            if (!$subNode->isEmpty()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strtr($this->value, $this->subNodes);
    }
}
