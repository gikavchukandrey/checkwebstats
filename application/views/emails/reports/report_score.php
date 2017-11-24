<?php echo __("Hi"); ?> <strong><?php echo $user->names; ?></strong><br><br>
<?php echo __("Your sites has been updated, and now can see the full report. Only need make click over the url and get instant full report from your site"); ?>
<br>
<br>
<br>
<table width="100%">
	<?php foreach ($site as $key => $value) { 
		if($value->metaTitle == '')
			$value->metaTitle = $value->url;
		?>
		<tr>
		<td valign="middle" align="center" style="padding-left: 10px;padding-right: 10px;padding-bottom:15px;">			
				<h1 style="color:<?php if($value->score <50) { echo "#FF0000"; } ?><?php if($value->score >=50 && $value->score <= 60) { echo "#F0AD4E"; } ?>  <?php if($value->score >60) { echo "#3C8DBC"; } ?>;margin:0px;padding:0px;"><?php echo $value->score; ?></h1>
				<small style="color:#909090;font-size:10px"><?php echo __("Score"); ?></small>			
		</td>
		<td valign="middle" style="padding-bottom:25px;"">
			<a style="color:#0A0A0A;text-decoration:none" href="<?php echo config_item("domain"); ?><?php echo $value->url; ?>">
				<strong><?php echo $value->metaTitle; ?></strong><br>
				<small style="color:#888888"><?php echo $value->url; ?></small><br>
			</a>
			
		</td>
		</tr>
	<?php } ?>	
</table>