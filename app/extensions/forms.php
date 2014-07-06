<?php

Form::macro('feedback', function ($show, $iconName = 'remove')
{
    $visible = $show ? '' : ' hidden';
    return '<span class="glyphicon glyphicon-'.$iconName.' form-control-feedback'.$visible.'"></span>';
});
