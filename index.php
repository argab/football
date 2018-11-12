<?php
/**
 * Created by PhpStorm.
 * @author ArGabid <argabid@gmail.com> <argabid@gmail.com>
 */

function match($c1, $c2)
{
    require_once 'classes/Team.php';

    $dataMatches = include 'storage/data-matches.php';

    $team = new Team($dataMatches);

    return $team->match($c1, $c2);
}

//var_dump(match(1, 2));
