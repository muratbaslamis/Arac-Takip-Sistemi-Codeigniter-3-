<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Araç Kayıt</title>
<link rel="stylesheet" href="<?php echo base_url();?>front/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>front/datepicker/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>front/css/style.css">
</head>
<body>

<div class="container">

<div class="row">

<div class="col-lg-12 align-items-center margin-top-lg">

<form id="form" onsubmit="return false;">

    <div class="form-group">
      <label for="inputEmail4">Ad Soyad</label>
      <input type="text" class="form-control" name="adsoyad" placeholder="Adınız, Soyadınız" required>
    </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="aracmarkasi">Araç Markası Seçiniz</label>
      <select id="aracmarkasi" class="form-control" name="aracmarkasi" required>
        <option selected value="">Seçiniz</option>
        <?php foreach ($aracmarkalari as $key => $aracmarka) { ?>
        	<option value="<?php echo $aracmarka['id']; ?>"><?php echo $aracmarka['markaadi']; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="aracmodeli">Araç Modeli Seçiniz</label>
      <select id="aracmodeli" class="form-control" name="aracmodeli" required>
        <option selected value="">Araç Markası Seçiniz</option>
      </select>
    </div>
  </div>
      <div class="form-row">
    <div class="form-group col-md-6">
      <label for="tamirtarihi">Tamir Tarihi Seçiniz</label>
<input type="text" name="tamirtarihi" required class="form-control" id="tamirtarihi" readonly placeholder="Tamir Tarihi Seçiniz">
    </div>
    <div class="form-group col-md-6">
      <label for="tamirsaati">Tamir Saati/Dakikası Seçiniz</label>
      <select id="tamirsaati" class="form-control" name="tamirsaati" required>
        <option selected value="">Tamir Saatini Seçiniz</option>

<?php 

  $start=strtotime('00:00');
  $end=strtotime('23:30');

  for ($i=$start;$i<=$end;$i = $i + 30*60)
  {

 ?>

        <option value="<?php echo date('H:i',$i); ?>"><?php echo date('H:i',$i); ?></option>


  <?php } ?>
      </select>
    </div>
  </div>

      <div class="form-row">
    <div class="form-group col-md-6">
      <label for="tamirturu">Tamir Türü Seçiniz</label>
      <select id="tamirturu" class="form-control" name="tamirturu" required disabled>
        <option selected value="">Seçiniz</option>
                <?php foreach ($tamirturleri as $key => $tamirturu) { ?>
        	<option value="<?php echo $tamirturu['id']; ?>"><?php echo $tamirturu['turadi']; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="tamiryeri">Tamir Yeri Seçiniz</label>
      <select id="tamiryeri" class="form-control" name="tamiryeri" required disabled>
        <option selected value="">Tamir Türü Seçiniz</option>
      </select>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Gönder</button>
<br><br>
<div class="spinner-border" role="status" style="display:none;">
  <span class="sr-only">Loading...</span>
</div>

<div id="msg"></div>
</form>

</div>
</div>
</div>


<script src="<?php echo base_url();?>front/js/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url();?>front/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>front/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>front/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>front/datepicker/locales/bootstrap-datepicker.tr.min.js"></script>

<script type="text/javascript">
	

// Datepicker tamir tarihi	
$('#tamirtarihi').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '<?php echo date('Y-m-d')?>',
    language: 'tr'
});

        $("#tamirtarihi").on("change", function() {

       $( "#tamirturu" ).prop( "disabled", false );
      $( "#tamiryeri" ).prop( "disabled", false );

        });

//Araç markasına göre model listesi
$('#aracmarkasi').on('change',function(){
$.ajax({
	url: '<?php echo base_url(); ?>aracmodelgetir',
	type: 'POST',
	data: {aracmarkaid: $(this).val()},
})
.done(function(data) {
dataver = 	JSON.parse(data);
$('#aracmodeli').html(dataver);
})
.fail(function(data) {
	console.log("error");
})
});


//Tamir türüne göre Tamir Yeri listesi
$('#tamirturu').on('change',function(){
$.ajax({
	url: '<?php echo base_url(); ?>tamiryerigetir',
	type: 'POST',
	data: {tamirturid: $(this).val(),tamirtarihi:$('#tamirtarihi').val()},
})
.done(function(data) {
var dataver = 	JSON.parse(data);
$('#tamiryeri').empty();
$.each(dataver, function(index) {
$('#tamiryeri').append('<option value='+dataver[index].tamiryerid+'>'+dataver[index].yeradi+'</option>');
});
})
.fail(function(data) {
	console.log("error");
})
});


/*
Formu Gönderiyoruz
*/

                $("#form").on('submit',(function(){
                    $(".spinner-border").css('display','block');
                    $.ajax({
                        url: "<?php echo base_url();?>kayitekle",
                        type: "POST",
                        data:  new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data){
                   $("#msg").html(data);
                $(".spinner-border").css('display','none');
                        },
                        error: function(data){
                   $("#msg").html(data);
                $(".spinner-border").css('display','none');
                        }           
                    });
                }));
</script>


</body>
</html>
