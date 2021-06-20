<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Content-type:application/json");

class Ajax extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$type = $this->input->post("type");
		switch ($type) {
			case 'addRequestService':
			    $this->form_validation->set_rules("fullName","Adınız ve Soyadınız","trim|required");
			    $this->form_validation->set_rules("cars","Araç Markası","trim|required");
			    $this->form_validation->set_rules("carModel","Araç Modeli","trim|required");
			    $this->form_validation->set_rules("repairType","Tamir Türü","trim|required");
			    $this->form_validation->set_rules("repairPlace","Tamir Yeri","trim|required");
			    $this->form_validation->set_rules("repairDate","Tamir Tarihi","trim|required");
			    $this->form_validation->set_rules("repairHour","Tamir Saati","trim|required");
			    $this->form_validation->set_message("required","Lütfen gerekli alanı doldurunuz. Bakınız: %s");
			    if($this->form_validation->run()){
					$fullName 	  = $this->input->post("fullName");
					$carId 	  	  = $this->input->post("cars");
					$carModel 	  = $this->input->post("carModel");
					$repairType   = $this->input->post("repairType");
					$repairPlace  = $this->input->post("repairPlace");
					$repairDate   = $this->input->post("repairDate");
					$repairHour   = $this->input->post("repairHour");
					$repairMinute = $this->input->post("repairMinute");
					$repairDate   = $repairDate." ".$repairHour.":".$repairMinute;
					$code 		  = mb_strtoupper(bin2hex(openssl_random_pseudo_bytes(6)));

					$checkUser 	  = $this->my_model->get("users",array("userFullName" => $fullName),"row");
					if (!$checkUser) {
						$this->my_model->insert("users",array("userFullName" => $fullName));
						$userId = $this->db->insert_id();
					}else{
						$userId = $checkUser->userId;
					}

					$dataService = array(
						"code" 			 => $code,
						"userId"		 => $userId,
						"carId " 		 => $carId,
						"carModelId" 	 => $carModel,
						"repairTypeId" 	 => $repairType,
						"repairPlaceId " => $repairPlace,
						"repairDate" 	 => $repairDate,
					);
					$checkService = $this->my_model->get("services",array("repairPlaceId" => $repairPlace,"repairDate" => $repairDate),"row");
					if (!$checkService) {
						$insertService = $this->my_model->insert("services",$dataService);
						if ($insertService) {
							$json["success"] = "Servis talebiniz başarılı bir şekilde oluşturuldu.";
						}else{
							$json["error"] = "Beklenmedik bir sorun oluştu. Lütfen tekrar deneyiniz!";
						}
					}else{
						$json["error"] = "Seçtiğiniz tarihte tamir yeri dolu olduğu için işleminizi gerçekleştiremiyoruz. Lütfen farklı bir tarih seçerek tekrar deneyiniz!";
					}

			    }else{
			    	$json["error"] = validation_errors('');
			    }

				echo json_encode($json);
				break;
			case 'getCarModels':
				$carId = $this->input->post("id");
				if ($carId) {
					$getCarModels = $this->my_model->get("models",array("carId" => $carId),"result");
					if (!empty($getCarModels)) {
						$theme = '';
						foreach ($getCarModels as $model) {
							$theme .= '<option value="'.$model->id.'">'.$model->model.' ('.$model->year.')</option>';
						}
						$json["theme"] 	 = $theme;
						$json["success"] = 1;
					}else{
						$json["error"] = "Seçtiğiniz araç markasına ait herhangi bir model bulunamadı!";
					}
				}else{
					$json["error"] = "Lütfen bir araç markası seçimi yapınız!";
				}
				echo json_encode($json);
				break;

			case 'getRepairPlace':
				$typeId 	  = $this->input->post("id");
				$repairDate   = $this->input->post("repairDate");

				if ($typeId) {
					if ($repairDate) {
						$this->db->join("repairtypeandplace","repairtypeandplace.place_id=repairplace.id");
						$getRepairPlace = $this->my_model->get("repairplace",array("repairtypeandplace.type_id" => $typeId),"result");
						if (!empty($getRepairPlace)) {
							$theme = '';
							foreach ($getRepairPlace as $place) {
								$leastIntenseId = $this->service_m->getLeastIntenseCount($place->id,$repairDate);
								if ($leastIntenseId) {
									$selected = $leastIntenseId == $place->id ? "selected" : "";
								}else{
									$selected = "";
								}
								$theme .= '<option value="'.$place->id.'" '.$selected.'>'.$place->place.'</option>';
							}
							$json["theme"] 	 = $theme;
							$json["success"] = 1;
						}else{
							$json["error"] = "Seçtiğiniz tamir türüne ait herhangi bir tamir yeri bulunamadı!";
						}
					}else{
						$json["error"] = "Lütfen tamir türü seçimi yapmadan önce tarih alanlarını eksiksiz doldurunuz!";
					}
				}else{
					$json["error"] = "Lütfen bir tamir türü seçimi yapınız!";
				}
				echo json_encode($json);
				break;
			
			default:
				break;
		}
	}
}
