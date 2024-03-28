<?php

namespace main;

class HiveGame
{
    private $hand = [];
    private $board = [];
    private $player = [];
    private $possibleDestinations = [];
    private DatabaseHandler $db;

    public function __construct($db)
    {
        $this->db = $db;
        if (!isset($_SESSION['board'])) {
            $_SESSION['board'] = [];
            $_SESSION['hand'] = [0 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3],
                                 1 => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]];
            $_SESSION['player'] = 0;
            $_SESSION['game_id'] = $this->createGame();
        }
        $this->board = $_SESSION['board'];
        $this->player = $_SESSION['player'];
        $this->hand = $_SESSION['hand'];
        $this->possibleDestinations = $this->setPossibleDestinations();
        $this->game_id = $_SESSION['game_id'];
    }

    private function createGame()
    {
        $this->db->getConnection()->prepare('INSERT INTO games VALUES ()')->execute();
        return $this->db->getConnection()->insert_id;
    }

    private function setPossibleDestinations()
    {
        $to = [];
        foreach ($GLOBALS['OFFSETS'] as $pq) {
            foreach (array_keys($this->board) as $pos) {
                $pq2 = explode(',', $pos);
                $to[] = ($pq[0] + $pq2[0]).','.($pq[1] + $pq2[1]);
            }
        }
        $to = array_unique($to);
        if (!count($to)) {
            $to[] = '0,0';
        }
        return $to;
    }
    
    public function getHand()
    {
        return $this->hand;
    }

    public function getBoard()
    {
        return $this->board;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function getPossibleDestinations()
    {
        return $this->possibleDestinations;
    }

    public function getGameId()
    {
        return $this->game_id;
    }

    public function getHandPlayer($player)
    {
        return $this->hand[$player];
    }
}
