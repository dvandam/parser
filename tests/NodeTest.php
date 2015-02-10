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
}
