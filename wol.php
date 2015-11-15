<?php 

/*******
 *
 * wol(wake on lan) $B$N<B9T(BPHP$B$G$9!#(B
 * ether-wake $B%3%^%s%I$rMxMQ$7$F$$$^$9!#(B
 * ether-wake $B%3%^%s%I$O!"0lHLE*$K(B root $B8"8B$,I,MW$G$9!#(B
 * $B$3$N%W%m%0%i%`$G$O!"(Bsudo $B%3%^%s%I(B $B7PM3$G<B9T$7$F$$$^$9!#(B
 * sudo ether-wake  $B$G(B $B<B9T$G$-$k$h$&;vA0$K(Bsudo $B8"8B$rIUM?$7$F$/$@$5$$!#(B 
 * eth0 $B0J30$N%$%s%?!<%U%'!<%90J30$rMxMQ$9$k>l9g$O!"(B$srcEth $B$rJQ99$7$F$/$@$5$$!#(B
 *
 * *****/


class WOL {

	public $srcEth = 'eth0';

	public function run($macAddr){
		$macAddr = $this->validMacAddr($macAddr);
		$result  = $this->execWol($macAddr);
		return $result ;
	}

	private function execWol($macAddr){
		$cmd  = "sudo ether-wake  -i " .  $this->srcEth . " " .  $macAddr . " -b";
		exec( $cmd , $res , $resultVal);
		if($resultVal == '0' ){
			return true;
		}
		return false;
	}

	private function validMacAddr($macAddr){
		$result = str_replace("-", ":", $macAddr);
		return $result;
	}

	/* PingTest*/
	public function ping($host){
		$r = exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($host)), $res, $rval);
		return $rval === 0;
	}
}

/* Test 
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
*/
