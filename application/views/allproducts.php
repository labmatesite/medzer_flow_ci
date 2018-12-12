<?php foreach ($main_subcat as  $value) { ?>
		<li><a href="<?=  base_url().$value['name'] ?>"><?= $value['name'] ?></a></li>
<?php } ?>