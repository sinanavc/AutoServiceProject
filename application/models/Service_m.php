<?php
class Service_m extends MY_Model {
	public function __construct(){
		 parent::__construct();
	}

  public function getLeastIntenseCount($placeId,$date){
    if ($placeId && $date) {
      $this->db->select("*,COUNT(*) as total");
      $this->db->group_by("repairPlaceId");
      $getLeastIntenseCount = $this->my_model->get("services",array("DATE(repairDate)" => $date,"repairPlaceId" => $placeId),"row","",array("total","asc"));
      if (!empty($getLeastIntenseCount)) {
        return $getLeastIntenseCount->repairPlaceId;
      }else{
        return false;
      }
    }
    return false;
  }
}

