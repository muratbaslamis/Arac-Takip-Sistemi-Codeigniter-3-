<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anasayfa extends CI_Controller {

	public function index()
	{
		$data['aracmarkalari'] = $this->veriler->aracmarkalari();
		$data['tamirturleri'] = $this->veriler->tamirturleri();
		$this->load->view('arackayit',$data);
	}


/*
Araç markasına göre model listelemesi
*/
	public function aracmodelgetir(){

	if($this->input->post('aracmarkaid')){

	$aracmarkaid = $this->input->post('aracmarkaid');
	$modellistesi = $this->veriler->modellistesi($aracmarkaid);

	$data = array();
	foreach ($modellistesi as $key => $modelliste) {

	$data[] = '<option value="'.$modelliste['id'].'">'.$modelliste['modeladi'].'</option>';

	}

	echo json_encode($data);

	}
	}


/*
Tamir türüne göre tamir yeri listelemesi
*/
	public function tamiryerigetir(){

	if($this->input->post('tamirturid')){

	$tamirturid = $this->input->post('tamirturid');
	$tamirtarihi = $this->input->post('tamirtarihi');
	$tamirturveyerler = $this->veriler->tamirturveyerler($tamirturid,$tamirtarihi);



	$data = array();
	foreach ($tamirturveyerler as $key => $tamirturveyer) {

	$servissayisi = $this->db->from('servisbilgisi')->where(array('tamiryerid'=>$tamirturveyer['tamiryerid'],'tamirtarihi'=>$tamirtarihi))->count_all_results();
	$veriler = array();
	$veriler['yogunluk'] = $servissayisi;
	$veriler['tamiryerid'] = $tamirturveyer['tamiryerid'];
	$veriler['yeradi'] = $tamirturveyer['yeradi'];
	$data[] = $veriler;
	}


	$yogunluksirasi = array_column($data, 'yogunluk');
	$yogunluksirasiarray  = array_multisort($yogunluksirasi, SORT_ASC, $data);

	echo json_encode($data);


	
	}
	}


/*
Form Kayıt Ekleme İşlemi
*/
public function kayitekle(){


$tamiryeridolumu = $this->veriler->dolulukkontrolu($this->input->post('tamirtarihi'),$this->input->post('tamirsaati'),$this->input->post('tamiryeri'));


if($tamiryeridolumu > 0){

echo '<div class="alert alert-danger" role="alert">
Seçtiğiniz tarihte tamir yeri doludur.
</div>';

}else{


$this->form_validation->set_rules('adsoyad', 'Ad, Soyad', 'trim|required|min_length[3]');
$this->form_validation->set_rules('aracmarkasi', 'Araç Markası', 'trim|required');
$this->form_validation->set_rules('aracmodeli', 'Araç Modeli', 'trim|required');
$this->form_validation->set_rules('tamirtarihi', 'Tamir Tarihi', 'trim|required');
$this->form_validation->set_rules('tamirsaati', 'Tamir Saati', 'trim|required');
$this->form_validation->set_rules('tamirturu', 'Tamir Türü', 'trim|required');
$this->form_validation->set_rules('tamiryeri', 'Tamir Yeri', 'trim|required');

$hatalar = array(

'required' 				=> '{field} alanları boş gönderilemez!',
'min_length'			=> '{field} alanı minimum 3 karakter olmalıdır!'
);

$this->form_validation->set_message($hatalar);
if ($this->form_validation->run()==FALSE) {
echo '<div class="alert alert-danger" role="alert">
'.validation_errors().'
</div>';
} else {


$musterisorgula = $this->veriler->musterivarmi(seflink($this->input->post('adsoyad')));

if($musterisorgula){

$musteriid = $musterisorgula['id'];

}else{

$musteriid = $this->veriler->musteriekle($this->input->post('adsoyad'),seflink($this->input->post('adsoyad')));

}


$data = array(

	'musteriid' => $musteriid, 
	'aracmarkaid' => $this->input->post('aracmarkasi'), 
	'aracmodelid' => $this->input->post('aracmodeli'), 
	'tamirturid' => $this->input->post('tamirturu'), 
	'tamiryerid' => $this->input->post('tamiryeri'), 
	'tamirtarihi' => $this->input->post('tamirtarihi')." ".$this->input->post('tamirsaati'), 
	'tarih' => date('Y-m-d h:i:s'),


);


$ekle = $this->veriler->kayitekle($data);


if($ekle){

echo '<div class="alert alert-success" role="alert">
Kayıt başarıyla eklendi!
</div>';
}else{

echo '<div class="alert alert-danger" role="alert">
Kayıt eklenemedi!
</div>';

}

}


}
}


/*
Sql Sorguları
*/
public function sqlsorgulari(){

/*
- Tamir yerlerine göre ortalama tamire alım süresini (Tamir tarihi ile kayıt girme tarihi arasındaki fark) saat bazında veren SQL’i yazınız.
*/

$query = $this->db->select("id,tamiryerid, AVG(TIMESTAMPDIFF(HOUR, tarih, tamirtarihi)) as saatler")->from("servisbilgisi")->group_by('tamiryerid')->get()->result_array();

//print_r($query);


/*
- Araç sayılarını, hafta bazında ve araç segmenti (Araç modeli tablosunda tutulmalıdır) bazında veren SQL’i yazınız.

Hafta bazında araç sayısı
*/
$query2 = $this->db->select("id,modeladi,aracsegmenti")->from("aracmodelleri")->where('WEEKOFYEAR(tarih) = WEEKOFYEAR(NOW())')->count_all_results();

//print_r($query2);


/*
- Araç sayılarını, hafta bazında ve araç segmenti (Araç modeli tablosunda tutulmalıdır) bazında veren SQL’i yazınız.

Segment bazında araç sayısı
*/

$query3 = $this->db->select("aracsegmenti, COUNT(aracsegmenti) as segmentsayisi")->from("aracmodelleri")->group_by('aracsegmenti')->get()->result_array();

//print_r($query3);


/*
- Ay bazında, tamir yerlerinin yoğunluğunu veren SQL’i yazınız. Tamir yerleri tablosunda aylık araç bakım kapasitesi alanı olmalıdır.
*/
$query4 = $this->db->select("id,tamiryerid, Count(tamiryerid) as servissayisi")->from("servisbilgisi")->where('MONTH(tamirtarihi) = MONTH(CURRENT_DATE())')->group_by('tamiryerid')->get()->result_array();

//print_r($query4);

}



}
