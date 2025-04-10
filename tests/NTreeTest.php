<?php

use PHPUnit\Framework\TestCase;
require_once "./src/NTree.php";

class NTreeTest extends TestCase
{
    public function testTreeNodeCreation()
    {
        $node = new TreeNode('root');
        $this->assertEquals('root', $node->getValue());
        $this->assertEmpty($node->getChildren());
    }

    public function testTreeNodeAddChild()
    {
        $root = new TreeNode('root');
        $child = new TreeNode('child');
        
        $root->addChild($child);
        
        $this->assertCount(1, $root->getChildren());
        $this->assertSame($child, $root->getChildren()[0]);
    }

    public function testDepthFirstTraversal()
    {
        // Создаем тестовое дерево
        $root = new TreeNode('root');
        $child1 = new TreeNode('child1');
        $child2 = new TreeNode('child2');
        $grandchild1 = new TreeNode('grandchild1');
        $grandchild2 = new TreeNode('grandchild2');
        
        $child1->addChild($grandchild1);
        $child1->addChild($grandchild2);
        $root->addChild($child1);
        $root->addChild($child2);

        // Собираем посещенные узлы
        $visited = [];
        $callback = function ($value) use (&$visited) {
            $visited[] = $value;
        };

        // Выполняем обход
        $traversal = new DepthFirstTraversal();
        $traversal->traverse($root, $callback);

        // Проверяем порядок обхода
        $this->assertEquals([
            'root',
            'child1',
            'grandchild1',
            'grandchild2',
            'child2'
        ], $visited);
    }

    public function testBreadthFirstTraversal()
    {
        // Создаем тестовое дерево
        $root = new TreeNode('root');
        $child1 = new TreeNode('child1');
        $child2 = new TreeNode('child2');
        $grandchild1 = new TreeNode('grandchild1');
        $grandchild2 = new TreeNode('grandchild2');
        
        $child1->addChild($grandchild1);
        $child1->addChild($grandchild2);
        $root->addChild($child1);
        $root->addChild($child2);

        // Собираем посещенные узлы
        $visited = [];
        $callback = function ($value) use (&$visited) {
            $visited[] = $value;
        };

        // Выполняем обход
        $traversal = new BreadthFirstTraversal();
        $traversal->traverse($root, $callback);

        // Проверяем порядок обхода
        $this->assertEquals([
            'root',
            'child1',
            'child2',
            'grandchild1',
            'grandchild2'
        ], $visited);
    }

    public function testTreeTraversalInterface()
    {
        // Проверяем реализацию интерфейсов
        $this->assertInstanceOf(
            TreeTraversalInterface::class,
            new DepthFirstTraversal()
        );
        
        $this->assertInstanceOf(
            TreeTraversalInterface::class,
            new BreadthFirstTraversal()
        );
    }
}