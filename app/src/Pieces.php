<?php

namespace main;

class Pieces {
    public static function isValidMove($board, $from, $to, $piece) {
        switch ($piece) {
            case 'Q':
                return self::queenValidity($board, $from, $to);
                break;
            case 'B':
                return self::beetleValidity($board, $from, $to);
                break;
            case 'G':
                return self::grasshopperValidity($board, $from, $to);
                break;
            case 'S':
                return self::spiderValidity($board, $from, $to);
                break;
            case 'A':
                return self::antValidity($board, $from, $to);
                break;
            default:
                $_SESSION['error'] = 'Unknown piece.';
                return false;
                break;
        }
    }

    private static function queenValidity($board, $from, $to) {
        return Util::slide($board, from, $to);
    }

    private static function beetleValidity($board, $from, $to) {
        return Util::slide($board, from, $to);
    }

    private static function grasshopperValidity($board, $from, $to) {
        $start = explode(",", $from);
        $end = explode(",", $to);

        $straightline = false;
        if($start[0]==$end[0] || $start[1]==$end[1] || ($start[0]-$end[0]+$start[1]-$end[1])==0) {
            $straightline = true;
        }

        return $straightline;
    }

    private static function antValidity($board, $from, $to) {
        return false;
    }

    private static function spiderValidity($board, $from, $to) {
        return false;
    }
}
