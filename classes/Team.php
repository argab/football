<?php

/**
 * Class Team
 *
 * @project <>
 * @author ArGabid <argabid@gmail.com>
 * @copyright 2018-2019, ArGabid, License MIT, All rights reserved
 */

/**
 * show off @property, @property-read, @property-write
 *
 * @property Team $_opponent;
 */
class Team
{
    public $name;

    public $games = 0;
    
    public $win = 0;
    
    public $draw = 0;
    
    public $defeat = 0;
    
    public $goals = 0;
    
    public $goalSkiped = 0;

    private $_score = array();

    private $_opponent;

    private $_matches = array();

    protected $scoreMeasure = array(
        'games',
        'win',
        'defeat',
        'goals',
        'goalSkiped',
    );

    protected $matchPeriod = array(
        0 => 45,
        1 => 45,
        2 => 15,
        3 => 15,
    );

    protected $penalty = 5;

    private $_matchResults = array();

    private $_penaltyResults = array(0, 0);

    public function loadMatches(array $data)
    {
        $this->_matches = $data;
    }

    protected function loadTeam($id)
    {
        if (false == isset($this->_matches[$id]))

            throw new Exception('The team not found.');

        list($this->name, $this->games, $this->win, $this->draw, $this->defeat, $this->goals, $this->goalSkiped) = array(
            $this->_matches[$id]['name'],
            $this->_matches[$id]['games'],
            $this->_matches[$id]['win'],
            $this->_matches[$id]['draw'],
            $this->_matches[$id]['defeat'],
            $this->_matches[$id]['goals']['scored'],
            $this->_matches[$id]['goals']['skiped'],
        );
    }

    /**
     * @return Team
     */
    public function getOpponent()
    {
        return $this->_opponent;
    }

    /**
     * @return array
     */
    public function getScore()
    {
        return $this->_score;
    }

    /**
     * @return array
     */
    public function getMatchResults()
    {
        return $this->_matchResults;
    }

    /**
     * @return array
     */
    public function getPenaltyResults()
    {
        return $this->_penaltyResults;
    }

    public function scoreUp()
    {
        $this->_score[] = 1;
    }

    public function scoreDown()
    {
        $this->_score[] = 0;
    }

    public function resetScore()
    {
        $this->_score = array();
    }

    protected function fetchScore()
    {
        foreach ($this->scoreMeasure as $item)
        {
            if ($item === 'defeat' || $item === 'goalSkiped')
            {
                if ($this->{$item} < $this->_opponent->{$item})
                {
                    $this->scoreUp();

                    $this->_opponent->scoreDown();
                }
                elseif ($this->_opponent->{$item} < $this->{$item})
                {
                    $this->_opponent->scoreUp();

                    $this->scoreDown();
                }

                continue;
            }

            if ($this->_opponent->{$item} > $this->{$item})
            {
                $this->_opponent->scoreUp();

                $this->scoreDown();
            }
            elseif ($this->{$item} > $this->_opponent->{$item})
            {
                $this->scoreUp();

                $this->_opponent->scoreDown();
            }
            else
            {
                $this->scoreUp();

                $this->_opponent->scoreUp();

                $this->scoreDown();

                $this->_opponent->scoreDown();
            }
        }
    }

    public function match($c1, $c2)
    {
        $this->loadTeam($c1);

        $this->_opponent = new Team;

        $this->_opponent->loadMatches($this->_matches);

        $this->_opponent->loadTeam($c2);

        $this->resetScore();

        $this->_opponent->resetScore();

        $this->fetchScore();

        return $this->playGame();
    }

    protected function playGame()
    {
        $results = array(0, 0);

        for ($i = 0; $i < sizeof($this->matchPeriod); ++$i)
        {
            $goalTeam = $goalOpponent = 0;

            for ($ii = 0; $ii < $this->matchPeriod[$i]; ++$ii)
            {
                $this->fetchGoal($goalTeam, $goalOpponent);
            }

            $results[0] += $goalTeam;
            $results[1] += $goalOpponent;

            $this->_matchResults[$i] = array($goalTeam, $goalOpponent);

            if ($i == 1 && $results[0] !== $results[1])

                return $results;
        }

        if ($results[0] === $results[1])

            $this->tryPenalty($results);

        return $results;
    }

    protected function tryPenalty(& $matchResults)
    {
        $try = 0;

        while ($try < $this->penalty)
        {
            $goalTeam = $goalOpponent = 0;

            $this->fetchGoal($goalTeam, $goalOpponent);

            $matchResults[0] += $goalTeam;
            $matchResults[1] += $goalOpponent;

            $this->_penaltyResults[0] += $goalTeam;
            $this->_penaltyResults[1] += $goalOpponent;

            if (($this->_penaltyResults[0] >= 4 && $this->_penaltyResults[1] <= 1)

                || ($this->_penaltyResults[1] >= 4 && $this->_penaltyResults[0] <= 1))

                return;

            $try += 1;
        }

        while ($this->_penaltyResults[0] === $this->_penaltyResults[1])
        {
            $this->fetchGoal($this->_penaltyResults[0], $this->_penaltyResults[1]);

            $matchResults[0] += $this->_penaltyResults[0];
            $matchResults[1] += $this->_penaltyResults[1];
        }
    }

    protected function fetchGoal(& $goalTeam, & $goalOpponent)
    {
        $score = $this->getScore();

        $scoreOpponent = $this->_opponent->getScore();

        $k1 = array_rand($score);

        $k2 = array_rand($scoreOpponent);

        if ($score[$k1] > $scoreOpponent[$k2])
        {
            $goalTeam += 1;
        }
        elseif ($scoreOpponent[$k2] > $score[$k1])
        {
            $goalOpponent += 1;
        }
    }
}
