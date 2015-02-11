<?php

class NodeTest extends PHPUnit_Framework_TestCase
{
    public function testNodeWithEmptyValueAndWithoutSubNodesIsEmpty()
    {
        $node = new Node('');
        $this->assertTrue($node->isEmpty());
    }

    public function testNodeWithNonEmptyValueAndNoSubNodesIsNotEmpty()
    {
        $node = new Node('Foo');
        $this->assertFalse($node->isEmpty());
    }

    public function testNodeWithNonEmptySubNodesIsNotEmpty()
    {
        $node = new Node('%bar%', ['%bar%' => new Node('Bar')]);
        $this->assertFalse($node->isEmpty());
    }

    public function testNodeWithEmptySubNodesIsNotEmpty()
    {
        $node = new Node('%bar%', ['%bar%' => new Node('')]);
        $this->assertTrue($node->isEmpty());
    }

    public function testNodeWithValueResolvesToThatValue()
    {
        $this->assertEquals('Foo', (string)new Node('Foo'));
    }

    public function testValueOfChildNodeIsUsedInRootNode()
    {
        $this->assertEquals('Foo', (string)new Node('%foo%', ['%foo%' => new Node('Foo')]));
    }

    public function testMultipleSubNodesAreUsedInRootNode()
    {
        $this->assertEquals('Foo Bar', (string)new Node('%foo% %bar%', [
            '%bar%' => new Node('Bar'),
            '%foo%' => new Node('Foo')
        ]));
    }

    public function subNodeCombinations()
    {
        return [
            [['%bar%' => new Node('Bar'), '%foo%' => new Node('Foo')], 'Foo Bar', false],
            [['%bar%' => new Node('Bar'), '%foo%' => new Node('')], ' Bar', false],
            [['%bar%' => new Node(''), '%foo%' => new Node('Foo')], 'Foo ', false],
            [['%bar%' => new Node(''), '%foo%' => new Node('')], ' ', true],
            [
                ['%bar%' => new Node('Bar %baz%', ['%baz%' => new Node('Baz')]), '%foo%' => new Node('Foo')],
                'Foo Bar Baz',
                false
            ]
        ];
    }

    /**
     * @dataProvider subNodeCombinations
     * Sanity check for all possible combinations
     *
     * @param Node[] $subNodes
     * @parem string $expectedValue
     * @param boolean $isEmpty
     */
    public function testVariousSubNodeCombinations(array $subNodes, $expectedValue, $isEmpty)
    {
        $node = new Node('%foo% %bar%', $subNodes);
        $this->assertEquals($expectedValue, (string)$node);
        $this->assertEquals($isEmpty, $node->isEmpty());
    }
}
