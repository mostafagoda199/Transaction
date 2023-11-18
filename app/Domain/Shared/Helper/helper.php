<?php

use Illuminate\Support\Str;

if (! function_exists('get_permission_from_public_methods_controller')) {
/**
 * @throws ReflectionException
 */
function get_permission_from_public_methods_controller(): array
{
    $loader = require base_path('vendor/autoload.php');

    $permissions = [];
    foreach ($loader->getClassMap() as $class => $file) {
        $methods = [];

        if (preg_match('/[a-z]+Controller$/', $class)
            && strpos($class, 'Controllers\\Admin')
        ) {
            $reflection = new ReflectionClass($class);

            $categoryName = substr($reflection->getShortName(), 0, strrpos($reflection->getShortName(), "C"));

            foreach ($reflection->getMethods() as $method) {
                if ($method->class === $reflection->getName()) {
                    $methods[] = Str::kebab($method->name);
                }
            }
            $permissions[$categoryName] = $methods;
        }
    }

    return $permissions;
}
}
