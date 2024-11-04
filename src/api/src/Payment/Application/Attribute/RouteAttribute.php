<?php

namespace App\Payment\Application\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class RouteAttribute
{
    public function __construct(
        public string $path,
        public string $name,
        public string $method = 'GET', // Default
        public array $requirements = []
    ) {}

    // Method to get a summary of the route
    public function getSummary(): string
    {
        $requirements = !empty($this->requirements) ? json_encode($this->requirements) : 'none';
        return sprintf("Route '%s' with path '%s', method '%s', and requirements: %s", 
            $this->name, $this->path, $this->method, $requirements);
    }
}
