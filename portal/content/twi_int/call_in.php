<?php
echo header('content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
/** Get sip endpoint list **/
$params=$_REQUEST['SipUser'];
$toNumberList=explode(",",$params);
?>
<Response>
    <?php
    for($i=0; $i < sizeof($toNumberList) ;$i++) { $to=$toNumberList[$i]; ?>
        <Dial timeout="20">

            <Sip>
                <?php echo $to; ?>
            </Sip>

        </Dial>
        <?php } ?>
</Response>