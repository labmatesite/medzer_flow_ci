<?php foreach ($main_section as  $value) { ?>
		<li><a href="<?php echo base_url()?><?php echo $value['page_url']?>"><?= $value['section'] ?></a></li>
<?php } ?>