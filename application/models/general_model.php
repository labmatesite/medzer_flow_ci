<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends CI_Model{
	function insert_user_data($data){
		$this->db->insert('auth_user', $data);
		return true;
    }
	function verify_user($password,$email){
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$query = $this->db->get('auth_user');
		$res = array();

		if($query->num_rows() > 0){
			$res['data'] = $query->result_array();
			$res['msg'] = 1;
		}
		else{
			$res['msg'] = 0;
		}
		return $res;
    }
	function distributor_list(){
		$this->db->select('*')->from('auth_user');
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function activate_user($user_id){
		$this->db->set('inactive', 0);
		$this->db->where('id', $user_id);
		$this->db->update('auth_user');
		return true;
	}
	function disable_user($user_id){
		$this->db->set('inactive', 2);
		$this->db->where('id', $user_id);
		$this->db->update('auth_user');
		return true;
	}
	
	function verify_email($email_id){
		
		$this->db->select('*')->from('auth_user');
		$this->db->where('email', $email_id);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function update_pwd($user_id,$new_pwd){
		$this->db->set('password', $new_pwd);
		$this->db->where('id', $user_id);
		$this->db->update('auth_user');
		return true;
	}
	function get_product_catID($id){
		$this->db->select('*')->from('products')->where('inactive',0)->where('category_id',$id);  
		$query = $this->db->get(); 
		$response = array(); 
		if($query->num_rows() > 0){ 
			$response = $query->result_array(); 
		} 
		return $response;
	}
	function get_product_by_SKU($sku){
		$this->db->select('*')->from('products')->where('inactive',0)->where('sku',$sku);  
		$query = $this->db->get(); 
		$response = array(); 
		if($query->num_rows() > 0){ 
			$response = $query->result_array(); 
		} 
		return $response;
	}
	function get_data_for_catalog_by_sku($data){ 
        $this->db->select('*'); 
        $this->db->where('sku', $data); 
        $query = $this->db->get('products'); 
        $res = $query->result_array(); 
        return $res; 
    }
	function get_main_subcat_categories(){
		$this->db->select('*')->from('categories')->where('inactive',0)->where('level',1);
		$this->db->order_by("name", "asc");
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_main_section(){
		$this->db->select('*')->from('sections');
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		/* echo "<pre>";
		print_r($response);die; */
		return $response;
	}
	function main_section($section){
		$this->db->select('*');
		$this->db->where('page_url',$section);
		$query = $this->db->get('sections');
		$res = "";
		if($query->num_rows() > 0){
			$res = $query->result_array();
		}
		return $res;
	}
	function main_cat_list($sec_name){
		$this->db->select('*');
		$this->db->where('parent_id', 0);
		$this->db->where('inactive',0);
		$this->db->where('section',$sec_name);
		$query = $this->db->get('categories');
		$res = "";
		if($query->num_rows() > 0){
			$res = $query->result_array();
		}
		return $res;
	}
	function check_routes($last){
		$this->db->select('url_title');
		$this->db->where('url_title', $last);
		$query = $this->db->get('products');
		$res = "";
		if($query->num_rows() > 0){
			$res = 1;
		}
		else{
			$res = 0;
		}
		return $res;
	}
	function get_main_categories(){
		$this->db->select('*')->from('categories')->where('inactive',0)->where('parent_id',0);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_subcat_specific($catid){
		$this->db->select('*')->from('categories')->where('parent_id',$catid);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_cat_specific($caturl){
		$this->db->select('*')->from('categories')->where('url_title',$caturl);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_products_specific($catid){
		$this->db->select('*')->from('products')->where('category_id',$catid);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_subcat_url_specific($subcaturl){
		$this->db->select('*')->from('categories')->where('url_title',$subcaturl);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		/* echo "<pre>";
		print_r($response);die; */
		return $response;
	}
	function get_prod_for_subcat($subcat_id){
		$this->db->select('*')->from('products')->where('category_id',$subcat_id);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		/* echo "<pre>";
		print_r($response);die; */
		return $response;
	}
	function get_final_prod_data($produrl){
		$this->db->select('p.*,pl.final_inr');
		$this->db->from('products as p');
		$this->db->join('price_list as pl','pl.sku = p.sku','left');
		$this->db->where('p.url_title',$produrl);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0)
		{
			$response = $query->result_array();
		}
		/* echo "<pre>";
		print_r($response);die; */
		return $response;
	}
	function get_rel_prod_data($rel_id){
		$this->db->select('*')->from('products')->where('category_id',$rel_id);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_random_products(){
		$this->db->select('*')->from('products');
		$this->db->order_by('id','RANDOM');
		$this->db->limit(20);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_random_products1(){
		$this->db->select('*')->from('products');
		$this->db->order_by('id','RANDOM');
		$this->db->limit(20);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_meta_home(){
		$key = "home";
		$this->db->select('*')->from('pages')->where('name',$key);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_meta_product(){
		$key = "products";
		$this->db->select('*')->from('pages')->where('name',$key);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_meta_about(){
		$key = "about";
		$this->db->select('*')->from('pages')->where('name',$key);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function get_meta_contact(){
		$key = "contact";
		$this->db->select('*')->from('pages')->where('name',$key);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
	function retrieve($tableName, $tableFields, $where = null, $order = null, $group = null, $limit = null)
    {
        if (is_array($tableFields)) {
            $fields = implode(',', $tableFields['fields']);
        } else {
            $fields = $tableFields;
        }
        $condition = '';
        if (!empty($where['where'])) {
            $condition = 'WHERE ';
            $lastKey = count($where['where']);
            $i = 0;
            foreach ($where['where'] as $key => $val) {
                $condition .= "`$key` = '$val'";
                if (count($where['where']) > 1) {
                    if (++$i !== $lastKey) {
                        $condition .= ' AND ';
                    }
                }
            }
        }
        if (!empty($where['where_in'])) {
            $condition = 'WHERE inactive=0 AND ';
            foreach ($where['where_in'] as $k => $v) {
                $arr = '"' . implode('","', $v) . '"';
                $condition .= $k . ' IN ' . '(' . $arr . ')';
            }

        }
        if (!empty($order['orderby'])) {
            if (is_array($order['orderby'])) {
                $order = 'ORDER BY ' . implode(',', $order['orderby']);
            } else {
                $order = 'ORDER BY ' . $order['orderby'];
            }
        }
        if (!empty($group['groupBy'])) {
            if (is_array($group['groupBy'])) {
                $order = 'GROUP BY ' . implode(',', $group['groupBy']);
            } else {
                $order = 'GROUP BY ' . $group['groupBy'];
            }
        }
        $lim = '';
        if (!empty($limit)) {
            $lim = 'LIMIT ' . $limit['limit'];
        }
        $query = "SELECT $fields FROM $tableName $condition $order $lim";
        $result = $this->db->query($query);
        return $result->result_array();
    }
	function get_search_prod($keyword){
		$this->db->select('*')->from('products');
		$this->db->like('name',$keyword,'both');
		$this->db->limit(100);
        $query = $this->db->get();     
        $response = array();
		if($query->num_rows() > 0)
		{	$response = $query->result_array();		}
		return $response;
	}
	function get_all_subcats_products($catid){
		$this->db->select('p.*');
		$this->db->from('categories as ca');
		$this->db->join('categories as cb', 'ca.id = cb.parent_id', 'self');
		$this->db->join('products as p', 'cb.id = p.category_id', 'both');
		$this->db->where('ca.id',$catid);
		$this->db->order_by("p.name", "asc");
		$query = $this->db->get();
		$response = $query->result_array();
		return $response;
	}
		
	function get_all_subcats_products2($catid){
		$this->db->select('p.*');
		$this->db->from('categories as ca');
		$this->db->join('categories as cb', 'ca.id = cb.parent_id', 'self');
		$this->db->join('categories as cc', 'cb.id = cc.parent_id', 'self');
		$this->db->join('products as p', 'cc.id = p.category_id', 'both');		
		$this->db->where('ca.id',$catid);
		$this->db->order_by("p.name", "asc");
		$query = $this->db->get();
		$response = $query->result_array();
		return $response;
	}
	function get_prod_for_subcat1($subcat_id){
		
		$this->db->select('p.*');
		$this->db->where('ca.id',$subcat_id);
		$this->db->from('categories as ca');
		$this->db->join('categories as cb', 'cb.parent_id = ca.id', 'self');
		$this->db->join('products as p', 'p.category_id = cb.id', 'both');
		$this->db->order_by("p.name", "asc");
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		//echo "<pre>";print_r($response);die;
		return $response;
	}
	function get_all_final_subcat($finalcatid){
		$this->db->select('*');
		$this->db->from('categories');
		$this->db->where('parent_id',$finalcatid);
		$query = $this->db->get();
		$response = $query->result_array();
		return $response;
	}
	function get_prod_for_subcat_3rd($subcat_id){
		
		$this->db->select('*')->from('products')->where('category_id',$subcat_id);
		$query = $this->db->get();
		$response = array();
		if($query->num_rows() > 0){
			$response = $query->result_array();
		}
		return $response;
	}
}
?>