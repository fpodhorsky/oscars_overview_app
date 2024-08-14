<?php

namespace App\Controllers;

class BaseController
{
    public function render(string $template, ?array $vars = []): bool
    {
        if (!str_contains($template, '.php')) {
            $template .= '.php';
        }

        if (!str_contains($template, '/')) {
            $template = '../Views/' . $template;
        }

        extract($vars);
        ob_start();
        include __DIR__ . '/../Views/' . $template;
        $output = ob_get_clean();

        return print($output);
    }
}
