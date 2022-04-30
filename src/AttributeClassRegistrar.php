<?php

namespace LaravelExportConstants;

use Exception;
use HaydenPierce\ClassFinder\ClassFinder;

class AttributeClassRegistrar
{
    public function __construct(private mixed $getAttributeNamespaces)
    {
    }

    /**
     * @return string[]
     * @throws Exception
     */
    public function getAllClasses(): array
    {
        $classes = [];
        foreach ($this->getAttributeNamespaces as $namespace) {
            $foundClasses = ClassFinder::getClassesInNamespace($namespace, ClassFinder::RECURSIVE_MODE);
            $classes = array_Merge($classes, $foundClasses);
        }

        return array_unique($classes);
    }
}
