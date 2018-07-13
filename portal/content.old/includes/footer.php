<?php
/* JAVASCRIPT */
echo '
<script src="/content/libs/jquery/jquery.min.js" type="text/javascript"></script>
<script src="/content/libs/perfect-scrollbar/dist/perfect-scrollbar.js" type="text/javascript"></script>

<script src="/content/javascripts/src/dashboard-main.js" type="text/javascript"></script>
<script src="/content/libs/bootstrap/dist/js/bootstrap.js" type="text/javascript"></script>
<script src="/content/libs/jquery-flot/jquery.flot.js" type="text/javascript"></script>
<script src="/content/libs/jquery-flot/jquery.flot.pie.js" type="text/javascript"></script>
<script src="/content/libs/jquery-flot/jquery.flot.resize.js" type="text/javascript"></script>
<script src="/content/libs/jquery-flot/plugins/jquery.flot.orderBars.js" type="text/javascript"></script>
<script src="/content/libs/jquery-flot/plugins/curvedLines.js" type="text/javascript"></script>
<script src="/content/libs/jquery.sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/content/libs/countup/countUp.min.js" type="text/javascript"></script>
<script src="/content/libs/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/content/libs/jqvmap/jquery.vmap.min.js" type="text/javascript"></script>
<script src="/content/libs/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="/content/javascripts/src/app-dashboard.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function(){
		App.init();
		App.dashboard();
	});
</script>

<script type="text/javascript" src="/content/javascripts/dest/general.min.js"></script>

<script type="text/javascript" defer> $(document).ready(function(){ ' .$page_specific_javascript.' }); </script>
';