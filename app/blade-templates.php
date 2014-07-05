<?php

Blade::extend(function($view, $compiler) 
{
    $pattern = $compiler->createMatcher('hasError');
    return preg_replace($pattern, '<?php echo $errors->has($2) ? "error" : ""; ?>', $view);
});

