<?php

namespace main;

class Util
{
    public static function isNeighbour($a, $b) {
        $a = explode(',', $a);
        $b = explode(',', $b);
        if ($a[0] == $b[0] && abs($a[1] - $b[1]) == 1 ||
            $a[1] == $b[1] && abs($a[0] - $b[0]) == 1 ||
            $a[0] + $a[1] == $b[0] + $b[1])
        {
            return true;
        }
    }

    public static function hasNeighBour($a, $board) {
        foreach (array_keys($board) as $b) {
            if (self::isNeighbour($a, $b)) {
                return true;
            }
        }
    }

    public static function neighboursAreSameColor($player, $a, $board) {
        foreach ($board as $b => $st) {
            if (!$st) {
                continue;
            }
            $c = $st[count($st) - 1][0];
            if ($c != $player && self::isNeighbour($a, $b)) {
                return false;
            }
        }
        return true;
    }

    public static function len($tile) {
        return $tile ? count($tile) : 0;
    }

    public static function slide($board, $from, $to) {
        if (!self::hasNeighBour($to, $board) || !self::isNeighbour($from, $to)) {
            return false;
        }
        $b = explode(',', $to);
        $common = [];
        foreach ($GLOBALS['OFFSETS'] as $pq) {
            $p = $b[0] + $pq[0];
            $q = $b[1] + $pq[1];
            if (self::isNeighbour($from, $p.",".$q)) {
                $common[] = $p.",".$q;
            }
        }
        if (!$board[$common[0]] && !$board[$common[1]] && !$board[$from] && !$board[$to]) {
            return false;
        }
        return min( self::len($board[$common[0]]),
                    self::len($board[$common[1]]))
                    <= max( self::len($board[$from]),
                    self::len($board[$to]));
    }
}