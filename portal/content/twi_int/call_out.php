<?php
$to=$_REQUEST['To'];
$callerId=$_REQUEST["callerId"];

if(!empty($to)){
	echo header('content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';

	/** Extracting user name **/
	$pos1 = strpos($to,":");
	$pos2 = strpos($to,"@");
	$tosip=substr($to,$pos1+1,$pos2-$pos1-1);

	if(strlen($tosip) == 3){

		/**Extracting sip endpoint**/
		$pos2 = strpos($to,":",strpos($to,":")+1);
		$tosip=substr($to,$pos1+1,$pos2-$pos1-1);

		echo '
		<Response>
			<Dial>
				<Sip>
					<?php echo $tosip; ?>
				</Sip>
			</Dial>
		</Response>';

	} else {
		if(substr($tosip,0,2)=="00"){
			$tosip=substr($tosip,2,strlen($tosip)-1);
		} else if(substr($tosip,0,3)=="011"){
			$tosip=substr($tosip,3,strlen($tosip)-1);
		}

		echo '
		<Response>
			<Dial callerId="'.$callerId.'">
				'.$tosip.'
			</Dial>
		</Response>';
	}
}