<?php

/**
 * Erweitert die templates um einen helper, der für CSS 
 * Fehlerklassen auf die folgende Weise benutzt werden kann:
 *
 * <div class="@hasError('email')"></div>
 *
 * Wenn nun ein Fehler für email registriert wurde, sieht das
 * daraus resultierende HTML so aus:
 * <div class="has-error"></div>
 *
 * ansonsten:
 * <div class=""></div>
 *
 */
Blade::extend(function($view, $compiler) 
{
    $pattern = $compiler->createMatcher('hasError');
    return preg_replace($pattern, '<?php echo $errors->has($2) ? "has-error" : ""; ?>', $view);
});

