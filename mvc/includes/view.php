<?php

declare(strict_types=1);

function renderView(string $template, array $data = []): void
{
    include TEMPLATES_DIR . '/header.php';    
    include TEMPLATES_DIR . '/' . $template . '.php';
}
function login(string $template){    
    include TEMPLATES_DIR . '/'.$template.'.php';
}
function renderViewint(string $template, int $data): void
{
    include TEMPLATES_DIR . '/header.php';    
    include TEMPLATES_DIR . '/' . $template . '.php';
}