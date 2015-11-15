<?php
require_once( dirname(__FILE__) .'/wol.php');

$WOL = new WOL;
$WOL->run('ZZ-ZZ-ZZ-ZZ-ZZ-ZZ');
for( $i = 0 ; $i <= 5 ; $i++ ){
	if($WOL->ping('192.168.0.1')){
		echo "Success.";
		exit ;
	}
	echo 'retry...'. $i . "\n";
	sleep(5);
}
echo "false.";
exit;

