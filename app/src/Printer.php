<?php

namespace main;

class Printer
{
    private DatabaseHandler $db;
    private HiveGame $game;

    public function __construct($db, $game)
    {
        $this->db = $db;
        $this->game = $game;
    }

    public function printMoveHistory()
    {
        $result = $this->db->getMoveHistory();
        while ($row = $result->fetch_array()) {
            echo '<li>'.$row[2].' '.$row[3].' '.$row[4].'</li>';
        }
    }

    public function printHand($player)
    {
        foreach ($this->game->getHand()[$player] as $tile => $ct) {
            for ($i = 0; $i < $ct; $i++) {
                echo '<div class="tile player'.$player.'"><span>'.$tile."</span></div> ";
            }
        }
    }

    public function printBoard()
    {
        $min_p = 1000;
        $min_q = 1000;
        foreach ($this->game->getBoard() as $pos => $tile) {
            $pq = explode(',', $pos);
            if ($pq[0] < $min_p) {
                $min_p = $pq[0];
            }
            if ($pq[1] < $min_q) {
                $min_q = $pq[1];
            }
        }
        foreach (array_filter($this->game->getBoard()) as $pos => $tile) {
            $pq = explode(',', $pos);
            $pq[0];
            $pq[1];
            $h = count($tile);
            echo '<div class="tile player';
            echo $tile[$h-1][0];
            if ($h > 1) {
                echo ' stacked';
            }
            echo '" style="left: ';
            echo ($pq[0] - $min_p) * 4 + ($pq[1] - $min_q) * 2;
            echo 'em; top: ';
            echo ($pq[1] - $min_q) * 4;
            echo "em;\">($pq[0],$pq[1])<span>";
            echo $tile[$h-1][1];
            echo '</span></div>';
        }
    }

    public function printMoveTo()
    {
        foreach ($this->game->getPossibleDestinations() as $pos) {
            echo "<option value=\"$pos\">$pos</option>";
        }
    }

    public function printMoveFrom()
    {
        foreach (array_keys($this->game->getBoard()) as $pos) {
            echo "<option value=\"$pos\">$pos</option>";
        }
    }

    public function printPlayTo()
    {
        foreach ($this->game->getPossibleDestinations() as $pos) {
            echo "<option value=\"$pos\">$pos</option>";
        }
    }

    public function printPiecesRemaining()
    {
        foreach ($this->game->getHand()[$this->game->getPlayer()] as $tile => $ct) {
            echo "<option value=\"$tile\">$tile</option>";
        }
    }
}
