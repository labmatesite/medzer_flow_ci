<?php foreach($main_cat_section as $res){ ?>
	<!-- main Sub_category name -->
        <a href=""><?= $res['name'] ?></a><br>
        	<!-- Retrieving Sub-Sub category name -->
		        <ul class="subcatlist">
							<?php 
									$this->db->select('*');
									$this->db->from('categories');
									$this->db->where('parent_id', $res['id']);
									$query = $this->db->get();
									$response = array();
									if($query->num_rows() > 0)
									{
										$response = $query->result_array();
									}

									$length = count($response);

									if($length = 0){ 

									} else {
										
									foreach($response as $row){ ?>
								<li>
									<a href="<?php echo base_url()?><?php echo $seg1.'/'.$row['page_url']?>">
										<?php echo $row['name']?>
									</a>
								</li>
								
							<?php } } ?>
							
							</ul>
<?php } ?>

