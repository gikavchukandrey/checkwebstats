<div class="container p-t-2">

	<div class="row">
		<div class="col-lg-3 col-md-4">		
							<?php echo get_ads("ads1","ads card card-block no-padding p-b-1 p-t-1"); ?>


			<div class="card card-block">
				<h2 class="small p-b-1"><?php echo __("Recents"); ?></h2>
				<?php foreach ($recents as $key => $value){ 
					if($value->id != $site->id){
					?>
				<div class="site-list">
					<div class="score"><?php echo $value->score; ?></div>
					<div class="data">
						<div class="title truncate"><?php echo badWords($value->metaTitle); ?></div>
						<a href="<?php echo base_url(); ?><?php echo $value->url; ?>" class="subtitle truncate"><?php echo $value->url; ?></a>
					</div>
				</div>
				<?php } } ?>				
			</div>

		</div>
		<div class="col-lg-9 col-md-8">		

			
			<h2 class="nice-title "><i class="zmdi zmdi-file"></i><span><?php echo $page->title; ?></span></h2>
			<div class="card card-block">
				<?php echo $page->text; ?>
			</div>

			<?php echo get_ads("ads2","ads card card-block no-padding p-b-1 p-t-1"); ?>

			<?php if(config_item("disqus_shortname")){ ?>
				<div class="card card-block">
					<div id="disqus_thread"></div>
					<script type="text/javascript">
						var disqus_shortname = '<?php echo config_item("disqus_shortname"); ?>';
						(function() {
						var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
						dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
						(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
						})();
					</script>
				</div>
			<?php } ?>
		</div>
		

	</div>
</div>