<?php

function get_state() {
    return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
}

function set_state($state) {
    list($a, $b, $c) = unserialize($state);
    $_SESSION['hand'] = $a;
    $_SESSION['board'] = $b;
    $_SESSION['player'] = $c;
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
return new mysqli('db', 'root', '', 'hive');
	
?>