<main class="mt-5 px-4">
	<div class="row justify-content-center">
    	<div class="col-12">
		  	<form id="service-request-form" method="POST">
			  	<div class="form-group mb-3">
			    	<label for="fullName" class="form-label">Adınız ve Soyadınız</label>
			    	<input type="email" class="form-control"  placeholder="Adınız ve Soyadınız" name="fullName" id="fullName">
			  	</div>
			  	<div class="form-group">
			  		<label for="cars" class="form-label">Aracın Markası</label>
				 	<select class="form-select mb-3 cars" name="cars" id="cars">
					  <option value="">Aracınızın Markasını Seçiniz</option>
					    <?php if ($cars) {
					  	foreach ($cars as $car) {
					  	 ?>
					  		<option value="<?=$car->id?>"><?=$car->brand?></option>
						<?php } } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="carModel" class="form-label">Aracın Modeli</label>
					<select class="form-select mb-3 car-models" name="carModel" id="carModel">
					  <option>Aracınızın Modelini Seçiniz</option>
					</select>
				</div>
				<div class="row mb-3">
					<div class="form-group col-md-6">
					    <label for="repairDate" class="form-label">Tarih</label>
					    <input type="text" class="form-control" id="repairDate" name="repairDate" placeholder="Tamir Tarihi Seçiniz">
					</div>
					<div class="form-group col-md-4">
					    <label for="repairHour" class="form-label">Saat</label>
					    <select id="repairHour" name="repairHour" class="form-select">
					      <option value="">Saat Seçiniz</option>
					      <?php for ($i=9; $i < 19; $i++) {  ?>
					      	<option><?=$i?></option>
						  <?php } ?>
					    </select>
					</div>
					<div class="form-group col-md-2">
						<label for="repairMinute" class="form-label">Dakika</label>
					    <select id="repairMinute" name="repairMinute" class="form-select">
					      <option value="00">00</option>
					      <option value="30">30</option>
					    </select>
					</div>
				</div>
				<div class="form-group">
					<label for="repairType" class="form-label">Tamir Türü</label>
					<select class="form-select mb-3 repair-types" name="repairType" id="repairType">
					  <option value="">Tamir Türü Seçiniz</option>
				 	    <?php if ($repairTypes) {
					  		foreach ($repairTypes as $type) {
					  	?>
					  		<option value="<?=$type->id?>"><?=$type->type?></option>
						<?php } } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="repairPlace" class="form-label">Tamir Yeri</label>
					<select class="form-select mb-3 repair-place" name="repairPlace" id="repairPlace">
					  <option value="">Tamir Yeri Seçiniz</option>
					</select>
				</div>
				<input type="hidden" name="type" value="addRequestService">
			  	<button type="submit" class="btn btn-primary add-request">Oluştur</button>
			</form>
		</div>
	</div>
</main>