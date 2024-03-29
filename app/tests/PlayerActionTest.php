<?php


use main\DatabaseHandler;
use main\HiveGame;
use main\PlayerAction;
use PHPUnit\Framework\TestCase;

class PlayerActionTest extends TestCase
{
    public function testMove_Queen_NoError()
    {
        session_start();
        
        $db = new DatabaseHandler();
        new HiveGame($db);
        $playerAction = new PlayerAction($db);

        $_SESSION['board']['0,0'] = [[0, 'Q']];
        $_SESSION['board']['0,1'] = [[1, 'Q']];

        $_SESSION['player'] = 0;
        $_POST['from'] = '0,0';
        $_POST['to'] = '1,0';

        $playerAction->move();

        $this->assertFalse(isset($_SESSION['error']), 'Test failed: Queen move error \''.$_SESSION['error'].'\'');
    }

    public function testMove_UpdatePrevPosition()
    {
        session_start();
        
        $db = new DatabaseHandler();
        new HiveGame($db);
        $playerAction = new PlayerAction($db);

        $_SESSION['board']['0,0'] = [[0, 'Q']];
        $_SESSION['board']['0,1'] = [[1, 'Q']];

        $_SESSION['player'] = 0;
        $_POST['from'] = '0,0';
        $_POST['to'] = '1,0';
        $playerAction->move();

        $_SESSION['player'] = 1;
        $_POST['from'] = '0,1';
        $_POST['to'] = '1,1';
        $playerAction->move();

        $this->assertFalse(isset($_SESSION['error']), 'Test failed: Update previous placement error \''.$_SESSION['error'].'\'');
    }
    
    public function testMove_Beetle_NoError()
    {
        session_start();
        
        $db = new DatabaseHandler();
        new HiveGame($db);
        $playerAction = new PlayerAction($db);

        $_SESSION['board']['0,0'] = [[0, 'Q']];
        $_SESSION['board']['0,1'] = [[1, 'Q']];
        $_SESSION['board']['-1,0'] = [[0, 'B']];
        $_SESSION['board']['0,2'] = [[1, 'B']];

        $_SESSION['player'] = 1;
        $_POST['from'] = '0,2';
        $_POST['to'] = '0,1';

        $playerAction->move();

        $this->assertFalse(isset($_SESSION['error']), 'Test failed: Beetle move error \''.$_SESSION['error'].'\'');
    }

    public function testMove_Beetle_CorrectPlacement()
    {
        session_start();
        
        $db = new DatabaseHandler();
        new HiveGame($db);
        $playerAction = new PlayerAction($db);

        $_SESSION['board']['0,0'] = [[0, 'Q']];
        $_SESSION['board']['0,1'] = [[1, 'Q']];
        $_SESSION['board']['-1,0'] = [[0, 'B']];
        $_SESSION['board']['0,2'] = [[1, 'B']];

        $_SESSION['player'] = 1;
        $_POST['from'] = '0,2';
        $_POST['to'] = '0,1';

        $playerAction->move();

        $this->assertEquals('B', $_SESSION['board']['0,1'][1], 'Test failed: Beetle move placement');
    }

    public function testMove_GrassHopper_CorrectPlacement()
    {
        session_start();
        
        $db = new DatabaseHandler();
        new HiveGame($db);
        $playerAction = new PlayerAction($db);

        $_SESSION['board']['0,0'] = [[0, 'Q']];
        $_SESSION['board']['0,1'] = [[1, 'Q']];
        $_SESSION['board']['-1,0'] = [[0, 'G']];
        $_SESSION['board']['0,2'] = [[1, 'B']];
        $_SESSION['board']['1,0'] = [];

        $_SESSION['player'] = 0;
        $_POST['from'] = '-1,0';
        $_POST['to'] = '1,0';

        $playerAction->move();

        $this->assertEquals('G', $_SESSION['board']['1,0'][0], 'Test failed: Grasshoper correct move placement');
    }

    public function testMove_GrassHopper_IncorrectPlacement()
    {
        session_start();
        
        $db = new DatabaseHandler();
        new HiveGame($db);
        $playerAction = new PlayerAction($db);

        $_SESSION['board']['0,0'] = [[0, 'Q']];
        $_SESSION['board']['0,1'] = [[1, 'Q']];
        $_SESSION['board']['-1,0'] = [[0, 'G']];
        $_SESSION['board']['0,2'] = [[1, 'B']];
        $_SESSION['board']['1,2'] = [];

        $_SESSION['player'] = 0;
        $_POST['from'] = '-1,0';
        $_POST['to'] = '1,2';

        $playerAction->move();

        $this->assertEquals('G', $_SESSION['board']['1,2'][0], 'Test failed: Grasshopper incorrect move placement');
    }

    public function testPass() 
    {
        session_start();
        
        $db = new DatabaseHandler();
        new HiveGame($db);
        $playerAction = new PlayerAction($db);
        $state = $db->getState();
        $_SESSION['last_move'];

        $stmt = $db->getConnection()->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "play", ?, ?, ?, ?)');
        $stmt->bind_param('issis', $_SESSION['game_id'], 'Q', '0,1', $_SESSION['last_move'], $state);
        $stmt->execute();
        $stmt = $db->getConnection()->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "play", ?, ?, ?, ?)');
        $stmt->bind_param('issis', $_SESSION['game_id'], 'Q', '1,0', $_SESSION['last_move'], $state);
        $stmt->execute();

        $playerAction->pass();

        $hist = $db->getMoveHistory();

        $this->assertEquals('pass', array_pop(hist)[2], 'Test failed: Pass()');
    }

    public function testPlay() 
    {
        session_start();
        
        $db = new DatabaseHandler();
        new HiveGame($db);
        $playerAction = new PlayerAction($db);

        $_POST['piece'] = 'Q';
        $_POST['to'] = '0,1';

        $playerAction->play();

        $this->assertEquals('Q', $_SESSION['board']['0,1'][0], 'Test failed: Play');
    }

    public function testPlayQueenFourth() 
    {
        session_start();
        
        $db = new DatabaseHandler();
        new HiveGame($db);
        $playerAction = new PlayerAction($db);

        $_POST['piece'] = 'Q';
        $_POST['to'] = '0,1';

        $playerAction->play();

        $this->assertEquals('Q', $_SESSION['board']['0,1'][0], 'Test failed: PlayQueenFourth');
    }

    public function testRestart() 
    {
        session_start();
        
        $db = new DatabaseHandler();
        new HiveGame($db);
        $playerAction = new PlayerAction($db);
        $state = $db->getState();
        $_SESSION['last_move'];

        $stmt = $db->getConnection()->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "play", ?, ?, ?, ?)');
        $stmt->bind_param('issis', $_SESSION['game_id'], 'Q', '0,1', $_SESSION['last_move'], $state);
        $stmt->execute();
        $stmt = $db->getConnection()->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, "play", ?, ?, ?, ?)');
        $stmt->bind_param('issis', $_SESSION['game_id'], 'Q', '1,0', $_SESSION['last_move'], $state);
        $stmt->execute();

        $playerAction->restart();

        $hist = $db->getMoveHistory();

        $this->assertEmpty($hist, 'Test failed: Restart');
    }

    // public function testUndo() {}
}