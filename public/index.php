<?php
/**
 * Created by PhpStorm.
 * @author ArGabid <argabid@gmail.com> <argabid@gmail.com>
 */

require_once '../classes/Team.php';

$dataMatches = include '../storage/data-matches.php';

$team = new Team;

$team->loadMatches($dataMatches);

$results = $team->match(1, 2);

$opponent = $team->getOpponent();

$matchResults = $team->getMatchResults();

$penalty = $team->getPenaltyResults();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Прогноз на матч</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <h1>Прогноз на матч &laquo;<?php echo $team->name; ?> - <?php echo $opponent->name; ?>&raquo;</h1>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Команда</th>
            <th>Первый период</th>
            <th>Второй период</th>
            <th>Первый послематчевый период</th>
            <th>Второй послематчевый период</th>
            <th>Серия пенальти</th>
            <th>Итог</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong><?php echo $team->name; ?></strong></td>
            <th><?php echo $matchResults[0][0]; ?></th>
            <th><?php echo $matchResults[1][0]; ?></th>
            <th><?php echo (isset($matchResults[2][0]) ? $matchResults[2][0] : null); ?></th>
            <th><?php echo (isset($matchResults[3][0]) ? $matchResults[2][0] : null); ?></th>
            <th><?php echo (isset($penalty[0]) ? $penalty[0] : null); ?></th>
            <th><?php echo $results[0]; ?></th>
        </tr>
        <tr>
            <td><strong><?php echo $opponent->name; ?></strong></td>
            <th><?php echo $matchResults[0][1]; ?></th>
            <th><?php echo $matchResults[1][1]; ?></th>
            <th><?php echo (isset($matchResults[2][1]) ? $matchResults[2][1] : null); ?></th>
            <th><?php echo (isset($matchResults[3][1]) ? $matchResults[2][1] : null); ?></th>
            <th><?php echo (isset($penalty[1]) ? $penalty[1] : null); ?></th>
            <th><?php echo $results[1]; ?></th>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
