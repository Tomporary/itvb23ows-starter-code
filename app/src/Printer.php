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
        foreach ($_SESSION['hand'][$player] as $tile => $ct) {
            for ($i = 0; $i < $ct; $i++) {
                echo '<div class="tile player'.$player.'"><span>'.$tile."</span></div> ";
            }
        }
    }

    public function printBoard()
    {
        $min_p = 1000;
        $min_q = 1000;
        foreach ($_SESSION['board'] as $pos => $tile) {
            $pq = explode(',', $pos);
            if ($pq[0] < $min_p) {
                $min_p = $pq[0];
            }
            if ($pq[1] < $min_q) {
                $min_q = $pq[1];
            }
        }
        foreach (array_filter($_SESSION['board']) as $pos => $tile) {
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
        foreach (array_keys($_SESSION['board']) as $pos) {
            $tile = $_SESSION['board'][$pos];
            $h = count($tile);
            if ($tile[$h-1][0] == $_SESSION['player']){
                echo "<option value=\"$pos\">$pos</option>";
            }
        }
    }

    public function printPlayTo()
    {
        foreach ($this->game->getPossibleDestinations() as $pos) {
            if (empty($_SESSION['board'])){
                echo "<option value=\"$pos\">$pos</option>";
            }
            elseif(!in_array($pos, array_keys($_SESSION['board']))) {
                if(Util::neighboursAreSameColor($_SESSION['player'], $pos, $_SESSION['board']) ||
                   $_SESSION['hand'][$_SESSION['player']]==["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]) {
                    echo "<option value=\"$pos\">$pos</option>";
                }
            } elseif(Util::len($_SESSION['board'][$pos])==0) {
                if(Util::neighboursAreSameColor($_SESSION['player'], $pos, $_SESSION['board']) ||
                   $_SESSION['hand'][$_SESSION['player']]==["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]) {
                    echo "<option value=\"$pos\">$pos</option>";
                }
            }
        }
    }

    public function printPiecesRemaining()
    {
        foreach ($_SESSION['hand'][$_SESSION['player']] as $tile => $ct) {
            if ($ct>0) {
                echo "<option value=\"$tile\">$tile</option>";
            }
        }
    }
}
