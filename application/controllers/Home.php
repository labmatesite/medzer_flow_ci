<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	function index(){
		$data['main_section'] = $this->general_model->get_main_section();	
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		$data['meta_home'] = $this->general_model->get_meta_home();
		
		$data['title'] = "Medzer";
		$data['description'] = $data['meta_home'][0]['meta_description'];
		$data['keyword'] = str_replace('|',',',$data['title']);
		// echo "<pre>";
		// print_r($data);
		$this->load->view('index', $data);
		
	}
// Distributor Login Functions

	function login(){
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		$data['meta_home'] = $this->general_model->get_meta_home();
		
		$data['title'] = "Distributor Login | Medzer";
		$data['description'] = "Medzer is a UK based leading manufacturers of medical devices served in the field of Hospitals, Biomedical industry, Pharmaceutical industry, Biotechnology industry, Education institutes and research laboratories.";
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('login', $data);
	}
	function register(){
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		$data['meta_home'] = $this->general_model->get_meta_home();
		
		$data['title'] = "Distributor Register | Medzer";
		$data['description'] = "Medzer is a UK based leading manufacturers of medical devices served in the field of Hospitals, Biomedical industry, Pharmaceutical industry, Biotechnology industry, Education institutes and research laboratories.";
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('register', $data);
	}
	function dashboard(){
		if(!empty($this->session->userdata('role')))
		{
			//echo "Admin Access";die;
			$data['users'] = $this->general_model->distributor_list();
			$data['main_section'] = $this->general_model->get_main_section();
			$data['category'] = $this->general_model->get_main_categories();
			$data['products'] = $this->general_model->get_random_products();
			$data['products1'] = $this->general_model->get_random_products1();
			$data['meta_home'] = $this->general_model->get_meta_home();
			
			$data['title'] = "Distributor Admin-Access | Medzer";
			$data['description'] = "Medzer is a UK based leading manufacturers of medical devices served in the field of Hospitals, Biomedical industry, Pharmaceutical industry, Biotechnology industry, Education institutes and research laboratories.";
			$data['keyword'] = str_replace('|',',',$data['title']);
			$this->load->view('admin_access', $data);
		}
		else
		{
			//echo "Login Page";die;
			redirect('distributor/login');
		}
	}
	function approve(){
		$user_id = $this->input->post('id');
		$this->general_model->activate_user($user_id);
		$this->db->select('*');
		$this->db->where('id', $user_id);
		$query = $this->db->get('auth_user');
		$res = array();
		if($query->num_rows() > 0){
			$res = $query->result_array();
		}
		//echo "<pre>";print_r($res);die;
		$msg_body  ='	<div class="table-responsive">
							<h1 style="text-align:center;">Distributor Info : <a style="color:#007f96;" href="http://medzer.com/">Medzer</a></h1>
							<br>
							<table class="table">
								<tr>
									<td>
										<h3>Congratulations !!! Your Account has been APPROVED by ADMIN of Medzer Website.</h3>
										<p>Login here : <a href="'.base_url('distributor/login').'">Distributor Login</a></p>
									</td>
								</tr>
							</table>
						</div>  ';

		$headSubject = 'Distributor Request Approved - Medzer';		

		$to = $res[0]['email'];

        $from = 'info@medzer.com';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";		

		$headers .= 'From:' . $from . "\r\n";

		if(mail($to,$headSubject,$msg_body,$headers)){
			$this->session->set_flashdata('approve_msg', 6);
			redirect('dashboard');
		} else {
			redirect('dashboard');
		}
	}
	function block(){
		$user_id = $this->input->post('id');
		$this->general_model->disable_user($user_id);
		$this->db->select('*');
		$this->db->where('id', $user_id);
		$query = $this->db->get('auth_user');
		$res = array();
		if($query->num_rows() > 0){
			$res = $query->result_array();
		}
		echo "<pre>";print_r($res);die;
		$msg_body  ='	<div class="table-responsive">
							<h1 style="text-align:center;">Distributor Info : <a style="color:#007f96;" href="http://Medzer/">Medzer</a></h1>
							<br>
							<table class="table">
								<tr>
									<td>
										<h3>SORRY !!! Your Account has been Blocked by ADMIN of Medzer Website for some reason.</h3>
									</td>
								</tr>
							</table>
						</div>  ';

		$headSubject = 'Distributor Request Rejected - Medzer';		

		$to = $res[0]['email'];

        $from = 'info@Medzer';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";		

		$headers .= 'From:' . $from . "\r\n";

		if(mail($to,$headSubject,$msg_body,$headers)){
			$this->session->set_flashdata('block_msg', 7);
			redirect('dashboard');
		} else {
			redirect('dashboard');
		}
	}
	
	function register_data(){
		$c_name = $this->input->post('c_name');
		$c_person = $this->input->post('c_person');
		$email = $this->input->post('email');		
		$password = $this->input->post('password');
		$address = $this->input->post('address');
		$phone = $this->input->post('phone');
		$location = $this->input->post('location');

		$data = array(
		
			'company_name' =>  $c_name,
			'company_person' =>  $c_person,
			'email' => $email,
			'password' => $password,
			'address' =>  $address,
			'phone' =>  $phone,
			'location' => $location

		);	   	   
		//echo "<pre>";print_r($data);die;

		$this->general_model->insert_user_data($data);		
		$msg_body  ='	<div class="table-responsive">
							<h1 style="text-align:center;">New Distributor Request : <a style="color:#007f96;" href="http://Medzer/">Medzer</a></h1>
							<br>
							<table class="table">
								<tr>
									<td>
										<h3><b><span style="color:#43c0b5">Company Name :</span> </b>' . $c_name . '</h3>
										<h3><b><span style="color:#43c0b5">Company Person :</span> </b>' . $c_person . '</h3>
									</td>
								</tr>
								<tr>
									<td>
										<h3><b><span style="color:#43c0b5">Email :</span> </b><a style="color:#007f96;" href="mailto:'.$email.'">' . $email . '</a></h3>
									</td>
								</tr>
								<tr>
									<td>
										<h3><b><span style="color:#43c0b5">Phone :</span> </b>' . $phone . '</h3>
									</td>
								</tr>
								<tr>
									<td>
										<h3><b><span style="color:#43c0b5">Address :</span> </b>' . $address . '</h3>
									</td>
								</tr>
								<tr>
									<td>
										<h3>
											<b><span style="color:#43c0b5">Location :</span> <span style="color:green;">'. $location.'</span></b>
										</h3>
									</td>
								</tr>
								<tr>
									<td>
										<h3><b><span style="color:#43c0b5">Link :</span> </b><a style="color:red"href="'.base_url().'distributor/login">Allow Access To New Distributor.</a></h3>
										<p>NOTE:Please Login to above link using super-admin credentials given below.</p>
										<p><b>Email Id</b> : <ins>info@pcdex.com</ins></p>
										<p><b>Password</b> : <ins>info321pcdex</ins></p>
									</td>
								</tr>
							</table>
						</div>  ';

		$headSubject = 'New Distributor Request - Medzer';		

		$to = 'info@pcdex.com';
		$cc = 'info@Medzer.com';

        $from = $email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";		

		$headers .= 'From:' . $from . "\r\n";		
		$headers .= 'Cc:' . $cc . "\r\n";		

		if(mail($to,$headSubject,$msg_body,$headers)){
			$this->session->set_flashdata('suc_reg', 1);
			redirect('');
		} else {
			$this->session->set_flashdata('err_login', 2);
			redirect('');
		}
	}
	function login_check(){
		$password = $this->input->post('password'); 
		$email = $this->input->post('email');
		$res = $this->general_model->verify_user($password,$email);
		if($res['msg'] == 1){
		   if($res['data'][0]['role'] == 'user' && ($res['data'][0]['inactive'] === '0'))
			{
				$this->session->set_userdata('id', $res['data']['0']['id']);
				$this->session->set_userdata('name', $res['data']['0']['username']);
				$this->session->set_flashdata('suc_login', 1);
				redirect('');
			}
			elseif ($res['data'][0]['role'] == 'user' && ($res['data'][0]['inactive'] === '1'))
			{
				$this->session->set_flashdata('suc_inlogin', 1);
				redirect('distributor/login');
			}
			elseif ($res['data'][0]['role'] == 'user' && ($res['data'][0]['inactive'] === '2'))
			{
				$this->session->set_flashdata('suc_block', 5);
				redirect('');
			}
			elseif($res['data'][0]['role'] == 'admin'){
				$this->session->set_userdata('id', $res['data']['0']['id']);
				$this->session->set_userdata('name', $res['data']['0']['username']);
				$this->session->set_userdata('role', $res['data']['0']['role']);
				redirect('dashboard');
			}
		}
		else{
			$this->session->set_flashdata('err_login', 2);
			redirect('distributor/login');
		}
	}
	function logout(){
		$this->session->sess_destroy();
		$this->session->set_flashdata('logout', 1);
		redirect('distributor/login');
	}
	function forgot_pwd(){
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		$data['meta_home'] = $this->general_model->get_meta_home();
		
		$data['title'] = "Email Check | Medzer";
		$data['description'] = $data['meta_home'][0]['meta_description'];
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('email_check', $data);
	}
	function change_pwd(){
		$data['id'] = $this->input->post('id');
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		$data['meta_home'] = $this->general_model->get_meta_home();
		
		$data['title'] = "Change Password | Medzer";
		$data['description'] = $data['meta_home'][0]['meta_description'];
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('change_pwd', $data);
	}
	
	function check_email(){
		$email = $this->input->post('user_email');
		$this->db->select('*');
		$this->db->where('email', $email);
		$query = $this->db->get('auth_user');
		$res = array();
		if($query->num_rows() > 0){
			$res = $query->result_array();
			$data = array('msg'=> 1, 'id'=> $res[0]['id']);
			echo json_encode($data);
		}
		else{
			$data = array('msg'=>0);
			echo json_encode($data);
		}
	}
	function password_update(){
		$user_id = $this->input->post('id');
		$new_pwd = $this->input->post('password');
		//echo $user_id."/".$new_pwd; die;
		$this->general_model->update_pwd($user_id,$new_pwd);
		$this->session->set_flashdata('pwd_update', 4);
		redirect('distributor/login');
	}
	
	
//Application Functions

	function allproduct(){
		//echo "all-products";die;
		$data['main_subcat'] = $this->general_model->get_main_subcat_categories();
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		
		$data['title'] = "All-Products | Medzer";
		$data['description'] = "Medzer offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('allproducts', $data);
	}
	function error(){
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		
		$data['title'] = "404_Error | Medzer";
		$data['description'] = "Medzer offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('errorpage', $data);
	}
/*------------- Section Controller ------------------*/
	function section()
	{
		$section = $this->uri->segment(1);
		$data['seg1'] = $section;
		$sec_data = $this->general_model->main_section($section);
		if(!empty($sec_data))
		{
			$sec_name = $sec_data[0]['section'];
			$sec_id = $sec_data[0]['id'];
			$data['sec_name'] = $sec_data[0]['section'];
			//echo "<pre>";print_r($data['sec_name']);die;
			$main_cat_section = $this->general_model->main_cat_list($sec_name);
			if (!empty($main_cat_section))
				{
				$data['main_cat_section'] = $this->general_model->main_cat_list($sec_name);
				$data['main_section'] = $this->general_model->get_main_section();
				$data['category'] = $this->general_model->get_main_categories();
				$data['products'] = $this->general_model->get_random_products();
				$data['title'] = $sec_name. " | Medzer";
				$data['description'] = "Medzer offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
				$data['keyword'] = str_replace('|',',',$data['title']);
				$this->load->view('section', $data);
				}
			else
				{
				redirect('404_override');
				}
		}
		else
		{
			$this->direct_product($section);
		}
	}	
	function direct_product($section){
		$product_name = explode("-", $section);
		
		$sku2 = end($product_name);
		$sku1 = prev($product_name);
		$sku = $sku1.'-'.$sku2;
		
        $data['prod_data'] = $this->general_model->get_product_by_SKU($sku);
        $product = $this->general_model->get_product_by_SKU($sku);
        if(empty($product)){
            redirect('all-products');
		}
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		
		$data['title'] = $product[0]['name']." | Medzer";
		if($product[0]['description']){
            $data['description'] = $product[0]['description'];
        }else{ 
			$data['description'] = $product[0]['name']; 
		}
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('direct-product', $data);
	}
/*------------- Category Controller ------------------*/
	function product_category()
	{
			//echo "Product Category";		die;
		$url = $this->uri->segment_array();		
		$caturl = end($url);
		$data['seg'] = $this->uri->segment(1);
		$catdata = $this->general_model->get_cat_specific($caturl);		
		$data['cat_data'] = $this->general_model->get_cat_specific($caturl);
		if(!empty($data['cat_data']))
		{
			$catid = $catdata[0]['id'];
			$data['subcat_data'] = $this->general_model->get_subcat_specific($catid);
			$subcatdata = $this->general_model->get_subcat_specific($catid);
			if (!empty($subcatdata))
				{
				$prod_data = $this->general_model->get_all_subcats_products($catid);
				if (!empty($prod_data))
					{
					$data['prod_data'] = $this->general_model->get_all_subcats_products($catid);
					}
				  else
					{
					$prod_data1 = $this->general_model->get_all_subcats_products2($catid);
					if (!empty($prod_data1))
						{
						$data['prod_data'] = $this->general_model->get_all_subcats_products2($catid);
						}
					else{
							$data['prod_data'] = $this->general_model->get_all_subcats_products2($catid);
						}
					}
				}
			else
				{
				$data['prod_data'] = $this->general_model->get_products_specific($catid);
				}
			//echo "<pre>";print_r($data['prod_data']);die;
			
			$data['catname'] = $catdata[0]['name'];
			$data['catdesc'] = $catdata[0]['description'];
			$data['main_section'] = $this->general_model->get_main_section();
			$data['category'] = $this->general_model->get_main_categories();
			$data['products'] = $this->general_model->get_random_products();
			$data['products1'] = $this->general_model->get_random_products1();
			
			$data['title'] = $catdata[0]['head_title'];
			$data['description'] = $catdata[0]['meta_description'];
			$data['keyword'] = str_replace('|', ',', $data['title']);
			$this->load->view('product_category', $data);
		}
		else
		{
			$product_name = explode("-", $caturl);
			$sku = end($product_name);
			$prod_data = $this->general_model->get_product_by_SKU($sku);
			if(!empty($prod_data))
			{
				$this->direct_product($caturl);
			}
			else
			{
				redirect('404_override');
			}
		}
	
	}
/*------------- Route to "Sub-Cat/Description" Controller ------------------*/
	function route(){
		$url = $this->uri->segment_array();
		$last = end($url);
		$msg = $this->general_model->check_routes($last);
		if($msg == 1)
		{
			return $this->product_description($url);
		}
		else
		{
			return $this->subcategory_list($url);
		}
	}
/*------------- Sub - Category Controller ------------------*/
	function subcategory_list($url)
	{
		 $data['seg'] = $this->uri->segment(1);
		// $category = $this->uri->segment(2);
		$url_arr = $this->uri->segment_array();
		
		$length = count($url_arr);
		
		if($length == 3)
		{
			//echo "3rd level";die;
			$data['length'] = $length;
			$subcaturl = end($url_arr);
			$caturl = prev($url_arr);
			
			$data['cat_data'] = $this->general_model->get_cat_specific($caturl);
			$catid = $data['cat_data'][0]['id'];
			$data['all_subcat_data'] = $this->general_model->get_subcat_specific($catid);
			
			$data['main_subcat_data'] = $this->general_model->get_subcat_url_specific($subcaturl);
			
			$finalcatid = $data['main_subcat_data'][0]['id'];
			$finalcat = $this->general_model->get_all_final_subcat($finalcatid);
			$data['finalcat'] = $finalcat;
			 
			$data['catname'] = $data['main_subcat_data'][0]['name'];
			$data['catdesc'] = $data['main_subcat_data'][0]['description'];
			
			$subcatdata = $this->general_model->get_subcat_url_specific($subcaturl);
			
			$subcat_id = $subcatdata[0]['id'];
			$data['subcat_id'] = $subcatdata[0]['id'];
			$data['prod_data'] = $this->general_model->get_prod_for_subcat($subcat_id);
			
			//$data['prod_data1'] = $this->general_model->get_prod_for_subcat1($subcat_id);			
			//echo "<pre>";print_r($subcatdata);print_r($data['prod_data1']);die;
			
			$data['main_section'] = $this->general_model->get_main_section();
			$data['category'] = $this->general_model->get_main_categories();
			$data['products'] = $this->general_model->get_random_products();
			$data['products1'] = $this->general_model->get_random_products1();
			
			$data['title'] = $data['main_subcat_data'][0]['head_title']." | Medzer";
			if(!empty($data['main_subcat_data'][0]['meta_description'])){
				$data['description'] = $data['main_subcat_data'][0]['meta_description'];
			} else {
				$data['description'] = $data['cat_data'][0]['meta_description'];
			}
			$data['keyword'] = str_replace('|',',',$data['title']);
			$this->load->view('product_subcat', $data);	
			
		}
		else
		{
			//echo "4th level";die;
			$data['length'] = $length;
			$sub_subcaturl = end($url_arr);
			$subcaturl = prev($url_arr);
			$caturl = prev($url_arr);
			
			$data['cat_data'] = $this->general_model->get_cat_specific($caturl);
			
			$data['subcat_data'] = $this->general_model->get_subcat_url_specific($subcaturl);
			
			$subcatid = $data['subcat_data'][0]['id'];
			$data['all_subcat_data'] = $this->general_model->get_subcat_specific($subcatid);
			
			$data['main_subcat_data'] = $this->general_model->get_subcat_url_specific($sub_subcaturl);
			
			$data['catname'] = $data['main_subcat_data'][0]['name'];
			$data['catdesc'] = $data['main_subcat_data'][0]['description'];
			
			$subcatdata = $this->general_model->get_subcat_url_specific($sub_subcaturl);
			$subcat_id = $subcatdata[0]['id'];
			$data['prod_data'] = $this->general_model->get_prod_for_subcat_3rd($subcat_id);
			
			//echo "<pre>";print_r($data['prod_data']);die;
			
			$data['main_section'] = $this->general_model->get_main_section();
			$data['category'] = $this->general_model->get_main_categories();
			$data['products'] = $this->general_model->get_random_products();
			$data['products1'] = $this->general_model->get_random_products1();
			
			$data['title'] = $data['main_subcat_data'][0]['head_title']." | Medzer";
		if(!empty($data['main_subcat_data'][0]['meta_description'])){
			$data['description'] = $data['main_subcat_data'][0]['meta_description'];
		} else {
			$data['description'] = $data['cat_data'][0]['meta_description'];
		}
			$data['keyword'] = str_replace('|',',',$data['title']);
			$this->load->view('product_final_subcat', $data);
			
		}		
	}
/*------------- Description Controller ------------------*/
	function product_description($url)
	{
		/* $data['seg'] = $this->uri->segment(1);*/
		$category = $this->uri->segment(1); 
		$url_arr = $this->uri->segment_array();
		//echo "<pre>";print_r($url_arr); echo $data['seg'];die;
		$length = count($url_arr);
		if($length == 3){
			$data['length'] = $length;
			$produrl = end($url_arr);
			$caturl = prev($url_arr);
			
			$data['cat_data'] = $this->general_model->get_cat_specific($caturl);
			$data['prod_data'] = $this->general_model->get_final_prod_data($produrl);
			
			$rel_id = $data['cat_data'][0]['id'];
			$data['rel_prod'] = $this->general_model->get_rel_prod_data($rel_id);
			//echo "<pre>";print_r($data['prod_data']);die;
		}
		if($length == 4){
			$data['length'] = $length;
			$produrl = end($url_arr);
			$subcaturl = prev($url_arr);
			$caturl = prev($url_arr);
			//echo $caturl;die;
			$data['cat_data'] = $this->general_model->get_cat_specific($caturl);
			$data['subcat_data'] = $this->general_model->get_subcat_url_specific($subcaturl);
			$data['prod_data'] = $this->general_model->get_final_prod_data($produrl);
			//echo "<pre>";print_r($data['cat_data']);die;
			$rel_id = $data['subcat_data'][0]['id'];
			$data['rel_prod'] = $this->general_model->get_rel_prod_data($rel_id);
			//echo "<pre>";print_r($data['prod_data']);die;
		}
		if($length == 5){
			$data['length'] = $length;
			$produrl = end($url_arr);
			$sub_subcaturl = prev($url_arr);
			$subcaturl = prev($url_arr);
			$caturl = prev($url_arr);
			
			$data['cat_data'] = $this->general_model->get_cat_specific($caturl);
			$data['subcat_data'] = $this->general_model->get_subcat_url_specific($subcaturl);
			$data['main_subcat_data'] = $this->general_model->get_subcat_url_specific($sub_subcaturl);
			$data['prod_data'] = $this->general_model->get_final_prod_data($produrl);
			
			$rel_id = $data['main_subcat_data'][0]['id'];
			$data['rel_prod'] = $this->general_model->get_rel_prod_data($rel_id);
			//echo "<pre>";print_r($data['prod_data']);die;
		}
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		
		$data['title'] = $data['prod_data'][0]['name']." | ".str_replace("-"," ",$category)." | Medzer";
		if(!empty($data['prod_data'][0]['meta_description'])){
			$data['description'] = $data['prod_data'][0]['meta_description'];
		} else {
			$data['description'] = "Medzer offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		}
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('product_description', $data);
	}
	
	function search(){
		$keyword = $this->input->get('keyword');
		//echo $keyword;die;
		$data['keys'] = $keyword;
		$searched_prod = $this->general_model->get_search_prod($keyword);
		$length = count($searched_prod);
		$data['count'] = $length;
		$data['searched_prod'] = $this->general_model->get_search_prod($keyword);
		
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		
		$data['title'] = "Search: ".$keyword." | Medzer";
		$data['description'] = "Medzer offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('search', $data);
	}
	function gallery(){
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products'] = $this->general_model->get_random_products();
		$data['products1'] = $this->general_model->get_random_products1();
		
		$data['title'] = "Product Gallery | Medzer";
		$data['description'] = "Medzer offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('gallery', $data);
	}
	function aboutus(){
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products1'] = $this->general_model->get_random_products1();
		$data['meta_about'] = $this->general_model->get_meta_about();
		$data['title'] = "About Us | Medzer";
		$data['description'] = "Medzer offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('aboutus', $data);
	}
	function contactus(){
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products1'] = $this->general_model->get_random_products1();
		$data['meta_contact'] = $this->general_model->get_meta_contact();
		
		$data['title'] = "Contact Us | Medzer";
		$data['description'] = "Medzer offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('contactus', $data);
	}
	
	function compare()
    {
        $ids = '';
        if ($this->input->get('product_id')){

            $ids = explode(',', $this->input->get('product_id'));

        }		//print_r($ids);die;

        $results = $this->db->where_in('id', $ids)
            ->order_by('name')
            ->group_by('id')
            ->get('products')
            ->result_array();

        $keys = array();
        $uni = array();

        foreach ($results as $row) {
            $spec = json_decode($row['specifications'], true);
            foreach ($spec as $key => $value) {
                if (!in_array($key, $uni)) {
                    $uni[] = $key;
                }
            }
        }
        foreach ($results as $row) {
            $spec = json_decode($row['specifications'], true);
            foreach ($uni as $k) {
                if (!isset($spec[$k])) {
                    $keys[$k]['child'][] = "&mdash;";
                } else {
                    $keys[$k]['child'][] = $spec[$k];
                }
            }
        }
		$main_section = $this->general_model->get_main_section();
		$category = $this->general_model->get_main_categories();
		$products = $this->general_model->get_random_products();
		$products1 = $this->general_model->get_random_products1();
		
		$title = "Compare | Medzer";
		$description = "Medzer offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$keyword = str_replace('|',',',$title);
        $this->load->view('compare',array('keys' => $keys, 'product' => $results, 'category' => $category, 'title' => $title, 'description' => $description, 'keyword' => $keyword, 'products' => $products, 'products1' => $products1, 'main_section' => $main_section));

    }
	function catalog(){
		//echo "catalog";die;
		$sku = $this->uri->segment(2); 
        $data['product'] = $this->general_model->get_data_for_catalog_by_sku($sku);
		
		$data['main_section'] = $this->general_model->get_main_section();
		$data['category'] = $this->general_model->get_main_categories();
		$data['products1'] = $this->general_model->get_random_products1();
		
		$data['title'] = $data['product'][0]['name']." | Catalog | Medzer";
		$data['description'] = "Medzer offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('catalog', $data);
	}
	function buildTree($elements = array(), $parentId = 0)
	{
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    } 
	function quote(){
        $name = $_POST['name'];
        $email = $_POST['email'];
		$phone = $_POST['phone'];
        $product = $_POST['product'];
        $location = $_POST['location'];
        $url = $_POST['url'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
		//echo $name." ".$email." ".$phone." ".$product." ".$location." ".$url." ".$subject." ".$message ;die;
		$msg_body  ='<style type="text/css"> 
						   
						</style>
						<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="all">
						<div class="table-responsive">
							<h1 style="text-align:center;">Quotation Request From <a style="color:#007f96;" href="http:/Medzer/">Medzer</a></h1>
							<br>
							<table class="table ">
								<tr>
									<td>
										<h3><b>Name : </b>' . $name . '</h3>
									</td>
								</tr>
								<tr>    
									<td>
										<h3><b>Email : </b><a style="color:#007f96;" href="mailto:'.$email.'">' . $email . '</a></h3>
									</td>
								</tr> 
								<tr>    
									<td>  
										<h3>
											<b>Product : </b>
												<a style="color:#007f96;" target="_blank" href="'.$url.'">
													'. $product .'
												</a>
										</h3>   
									</td>
								</tr>
								
								<tr> 
									<td>
										<h3><b>Phone : </b>' . $phone . '</h3>
									</td>
								</tr>
								<tr> 
									<td>
										<h3>
											<b>Location : <span style="color:green;">'.$location.'</span></b>
										</h3>  
									</td>
								</tr> 
								<tr> 
									<td>
										<h3><b>Subject : </b>' . $subject . '</h3>
									</td>
								</tr> 
								<tr> 
									<td>
										<h3><b>Message : </b>' . $message . '</h3>
									</td>
								</tr>  
							</table>
						</div>  ';        
		
		$headSubject = 'Product Quote - Medzer';
		
		$cc = 'info@pcdex.com';
        $to = 'info@Medzer';
        $from = $email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From:' . $from . "\r\n";
        //$headers .= 'Cc:' . $cc . "\r\n";
		if(mail($to,$headSubject,$msg_body,$headers)){
			$this->session->set_flashdata('suc_mail', 5);
			redirect($url);
		} else {
			$this->session->set_flashdata('err_mail', 6);
			redirect($url);
		}
	}
	function enquiry(){

		$name = $_POST['name'];
        $email = $_POST['email'];
		$subject = $_POST['subject'];
        $message = $_POST['message'];
		$location = $_POST['location'];

		$msg_body  ='<style type="text/css"> 

						   

						</style>

						<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="all">

						<div class="table-responsive">

							<h1 style="text-align:center;">Contact Request From <a style="color:#007f96;" href="http://Medzer/">Medzer</a></h1>

							<br>

							<table class="table ">

								<tr>
									<td>
										<h3><b>Name : </b>' . $name . '</h3>
									</td>
								</tr>

								<tr> 
									<td>
										<h3><b>Email : </b><a style="color:#007f96;" href="mailto:'.$email.'">' . $email . '</a></h3>

									</td>
								</tr>

								<tr> 
									<td>
										<h3>
											<b>Location : <span style="color:green;">'.$location.'</span></b>
										</h3>  
									</td>
								</tr>

								<tr> 
									<td>
										<h3><b>Subject : </b>' . $subject . '</h3>
									</td>
								</tr> 

								<tr>
									<td>
										<h3><b>Message : </b>' . $message . '</h3>
									</td>
								</tr>  

							</table>

						</div>  ';

		

		$headSubject = 'Contact Details - Medzer';		

		$cc = 'info@pcdex.com';
		$to = 'info@Medzer';
        $from = $email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";		

		$headers .= 'From:' . $from . "\r\n";

		if(mail($to,$headSubject,$msg_body,$headers)){

			$this->session->set_flashdata('suc_mail', 5);
			redirect($url);

		} else {

			$this->session->set_flashdata('err_mail', 6);
			redirect($url);

		}
	}
	
	/*
	function certification(){
		$data['main_cat'] = $this->general_model->get_main_categories();
		$data['title'] = "Certification | Medical Equipment | Hostipal Products | Medical Supplies";
		$data['description'] = "Kizlon offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$this->load->view('certification', $data);
	}
	function terms(){
		$data['main_cat'] = $this->general_model->get_main_categories();
		$data['title'] = "Terms of Use | Medical Equipment | Hostipal Products | Medical Supplies";
		$data['description'] = "Kizlon offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$this->load->view('terms', $data);
	}
	function policies(){
		$data['main_cat'] = $this->general_model->get_main_categories();
		$data['title'] = "Policies | Medical Equipment | Hostipal Products | Medical Supplies";
		$data['description'] = "Kizlon offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$this->load->view('policies', $data);
	}
	function sitemap(){
		$data['main_cat'] = $this->general_model->get_main_categories();
		$data['title'] = "Sitemap | Medical Equipment | Hostipal Products | Medical Supplies";
		$data['description'] = "Kizlon offers a wide range of innovative Lab Equipment & Analytical Instruments for numerous applications in R&D, Quality control & Testing Laboratory";
		$this->load->view('sitemap', $data);
	}
	*/
	/* function categorylist(){
		
		$data['main_cat'] = $this->general_model->get_main_categories();
		
		$data['title'] = "Product Categories | Spectrophotometers";		
		$data['description'] = "Spectrophotometers are widely used for colorimetric applications in various fields of biochemistry, physics and chemical industries. We carry wide array of products suitable for all the specific needs including clinical, laboratory or research and industrial market. We supplies all different types of spectrophotometers such as UV/Vis, double beam, visible, large LCD and Nano spectrophotometers models. We are dedicated to provide genuine and authenticated products, our expert team will be there at every step to help guide you throughout the process.";		
		$data['keyword'] = str_replace('|',',',$data['title']);
		$this->load->view('productlist', $data);
	} */
}
?>