<?php 

/*******
 *
 * wol(wake on lan) の実行PHPです。
 * ether-wake コマンドを利用しています。
 * ether-wake コマンドは、一般的に root 権限が必要です。
 * このプログラムでは、sudo コマンド 経由で実行しています。
 * sudo ether-wake  で 実行できるよう事前にsudo 権限を付与してください。 
 * eth0 以外のインターフェース以外を利用する場合は、$srcEth を変更してください。
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
