<?php @session_start();
$orekaDir = __DIR__.'/../../../../';
// include $orekaDir.'q_lib/database.php';
include $orekaDir.'q_lib/database2.0.php';
$_SESSION['db2'] = true;
include $orekaDir.'q_lib/general_functions.php';
include $orekaDir.$_SESSION['logged']['version'].'/lib/q_functions.php';
include 'functions.php';
if (!isset($_SESSION['brand']) || $_SESSION['brand']['cod_bra'] != 231) {
	header('Location: /q_lib/break_session.php');
}
