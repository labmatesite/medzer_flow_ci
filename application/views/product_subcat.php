<?php foreach($prod_data as $res){	?>
	<a href="<?php echo base_url()?><?php echo $seg?>/<?php echo $res['page_url']?>"><?= $res['name'] ?></a><br>
<?php } ?>