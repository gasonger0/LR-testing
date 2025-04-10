<?php
// NTree.php

interface TreeNodeInterface
{
    public function getValue();
    public function getChildren(): array;
    public function addChild(TreeNodeInterface $child): void;
}

class TreeNode implements TreeNodeInterface
{
    private $value;
    private $children = [];

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function addChild(TreeNodeInterface $child): void
    {
        $this->children[] = $child;
    }
}

interface TreeTraversalInterface
{
    public function traverse(TreeNodeInterface $node, callable $callback): void;
}

class DepthFirstTraversal implements TreeTraversalInterface
{
    public function traverse(TreeNodeInterface $node, callable $callback): void
    {
        $callback($node->getValue());
        
        foreach ($node->getChildren() as $child) {
            $this->traverse($child, $callback);
        }
    }
}

class BreadthFirstTraversal implements TreeTraversalInterface
{
    public function traverse(TreeNodeInterface $node, callable $callback): void
    {
        $queue = [$node];
        
        while (!empty($queue)) {
            $currentNode = array_shift($queue);
            $callback($currentNode->getValue());
            
            foreach ($currentNode->getChildren() as $child) {
                $queue[] = $child;
            }
        }
    }
}