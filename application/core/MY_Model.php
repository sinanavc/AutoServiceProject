<?php
class MY_Model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function get($table,$where = NULL,$type="row",$pagination = null,$order = NULL,$join = NULL){
		$limit 	   = "";
		$whereFrom = "";
		if($join){
			$join_table = $join[0];
			$join_data  = $join[1];
			$this->db->join($join_table,"$join_table.$join_data = $table.$join_data");
		}

		if($pagination){
			$limit 	   = $pagination[0] ? $pagination[0] : "";
			$whereFrom = $pagination[1] ? $pagination[1] : "";
		}

	    if($order){
	      list($colum,$order_type) = $order;
	      $this->db->order_by($colum,$order_type);
	    }

		if($where == NULL){
			return $this->db->get($table,$limit,$whereFrom)->$type();
		}else {
			if(is_array($where)){
				$this->db->where($where);
				return $this->db->get($table,$limit,$whereFrom)->$type();
			}
		}
	}

	public function insert($table,$data){
		$result = $this->db->insert($table,$data);
		if($result){
			return TRUE;
		}
		return FALSE;
	}

	public function update($table,$data,$where = NULL){
		if($where){
			if(isset($where) && is_array($where)){
				$this->db->where($where);
				$result = $this->db->update($table,$data);
				if($result){
					return TRUE;
				}
				return FALSE;
			}
		}else {
			$result = $this->db->update($table,$data);
			if($result)
				return TRUE;
			else 
				return FALSE;
		}
	}

	public function delete($table,$where = null){
		if($where){
      		$this->db->where($where);
			$result = $this->db->delete($table);
			if($result)
				return TRUE;
			else 
				return FALSE;
		}
	}

	public function count($table,$where = null,$where_in = null){
	  	if(is_array($where_in)){
	  		$this->db->where_in($where_in["column"],$where_in["data"]);
	  	}
	    if($where){
	      $this->db->where($where);
	    }
	    $result = $this->db->get($table);
	    if($result->num_rows()){
	      return $result->num_rows();
	    }else {
	      return 0;
	    }
	}
}