<?php  foreach ($prod_data as $feature) { ?>
	<p><?= $feature['name'] ?></p>
	<p><?= $feature['sku'] ?></p>
	<p><?= $feature['series'] ?></p>
	<p><?= $feature['description'] ?></p>
	<p><?= $feature['features'] ?></p>
	<p><?= $feature['final_inr'] ?></p>
<?php } ?>
