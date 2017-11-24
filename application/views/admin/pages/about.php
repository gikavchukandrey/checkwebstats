<div class="col-md-12">	
	<h2>Changelog
		<span class="pull-right">Version: <?php echo config_item("version"); ?></span>		
	</h2>

	<pre id="changelog" style="overflow: auto;max-height: 600px"><?php echo $changelog; ?></pre>	
</div>
<script>
var objDiv = document.getElementById("changelog");
objDiv.scrollTop = objDiv.scrollHeight;
</script>