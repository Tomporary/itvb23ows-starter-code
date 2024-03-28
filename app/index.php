<?php
    namespace main;

    require_once './vendor/autoload.php';

    session_start();

    $GLOBALS['OFFSETS'] = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];

    $db = new DatabaseHandler();
    $game = new HiveGame($db);
    $printer = new Printer($db, $game);
    $playerAction = new PlayerAction($db);

    $board = $_SESSION['board'];
    $player = $_SESSION['player'];
    $hand = $_SESSION['hand'];

    $PLAYERWHITE = 0;
    $PLAYERBLACK = 1;

    $playerAction->handleAction();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hive</title>
        <style>
            div.board {
                width: 60%;
                height: 100%;
                min-height: 500px;
                float: left;
                overflow: scroll;
                position: relative;
            }

            div.board div.tile {
                position: absolute;
            }

            div.tile {
                display: inline-block;
                width: 4em;
                height: 4em;
                border: 1px solid black;
                box-sizing: border-box;
                font-size: 50%;
                padding: 2px;
            }

            div.tile span {
                display: block;
                width: 100%;
                text-align: center;
                font-size: 200%;
            }

            div.player0 {
                color: black;
                background: white;
            }

            div.player1 {
                color: white;
                background: black
            }

            div.stacked {
                border-width: 3px;
                border-color: red;
                padding: 0;
            }
        </style>
    </head>
    <body>
        <div class="board">
            <?php
                $printer->printBoard();
            ?>
        </div>
        <div class="hand">
            White:
            <?php
                $printer->printHand($PLAYERWHITE);
            ?>
        </div>
        <div class="hand">
            Black:
            <?php
                $printer->printHand($PLAYERBLACK);
            ?>
        </div>
        <div class="turn">
            Turn: 
            <?php 
                if ($player == $PLAYERWHITE) {
                    echo "White";
                } else {
                    echo "Black";
                } 
            ?>
        </div>
        <form method="post">
            <select name="piece">
                <?php
                    $printer->printPiecesRemaining();
                ?>
            </select>
            <select name="to">
                <?php
                    $printer->printPlayTo();
                ?>
            </select>
            <input type="submit" name="action" value="Play">
        </form>
        <form method="post">
            <select name="from">
                <?php
                    $printer->printMoveFrom();
                ?>
            </select>
            <select name="to">
                <?php
                    $printer->printMoveTo();
                ?>
            </select>
            <input type="submit" name="action" value="Move">
        </form>
        <form method="post">
            <input type="submit" name="action" value="Pass">
        </form>
        <form method="post">
            <input type="submit" name="action" value="Restart">
        </form>
        <strong>
            <?php 
                if (isset($_SESSION['error'])) {
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                } 
            ?>
        </strong>
        <ol>
            <?php
                $printer->printMoveHistory();
            ?>
        </ol>
        <form method="post">
            <input type="submit" name="action" value="Undo">
        </form>
    </body>
</html>

