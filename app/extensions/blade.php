<?php

/**
 * Erweitert die Templates um einen helper, der für CSS 
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

/**
 * Lässt in den Templates ein @ifstaffelleitung Statement benutzen. Damit kann man
 * überprüfen, ob der aktuell eingeloggte Benutzer ein Admin (Staffelleitung) ist, um bestimmte Elemente
 * nur für Admins sichtbar zu machen.
 * 
 * z. B. wird folgender Button nur gerendert, wenn man Staffelleitung ist:
 * @ifstafelleitung
 *		<button>Löschen</button>
 * @endif
 */
Blade::extend(function($view, $compiler) 
{
    return str_replace("@ifstaffelleitung", '<?php if(Auth::user()->rolle == "Staffelleitung"): ?>', $view);
});