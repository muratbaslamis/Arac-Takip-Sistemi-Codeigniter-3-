<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Veriler extends CI_Model {


/* 
Araç Marka Listesini Çekiyoruz 
*/	

public function aracmarkalari(){

return $this->db->from('aracmarkalari')->get()->result_array();

}

/* 
Araç Marka Id'sine göre Modelleri Çekiyoruz
*/	
public function modellistesi($aracmarkaid){

return $this->db->from('aracmodelleri')->where('aracmarkaid',$aracmarkaid)->get()->result_array();

}


/* 
Tamir türleri Listesini Çekiyoruz 
*/	

public function tamirturleri(){

return $this->db->from('tamirturleri')->get()->result_array();

}


/*
Tamir türüne göre ve yoğunluğa göre tamir yerlerini çekiyoruz
*/	
public function tamirturveyerler($tamirturid,$tamirtarihi){


    $this->db->select('tamirturveyerler.id , tamirturveyerler.tamiryerid, tamirturveyerler.tamirturid, tamiryerleri.yeradi, tamiryerleri.id');
    $this->db->from('tamirturveyerler');
    $this->db->where('tamirturveyerler.tamirturid',$tamirturid);
    $this->db->join('tamiryerleri','tamiryerleri.id = tamirturveyerler.tamiryerid','left');
    $this->db->group_by('tamiryerleri.id');
    $this->db->order_by('tamiryerleri.id',"asc");
	$ver = $this->db->get()->result_array();
	return $ver;

}


/*
Tamir Yeri Doluluk Sorgusu
*/
public function dolulukkontrolu($tamirtarihi,$tamirsaati,$tamiryeri){

return $this->db->from('servisbilgisi')->where(array('tamirtarihi'=>$tamirtarihi." ".$tamirsaati,'tamiryerid'=>$tamiryeri))->count_all_results();

}


/*
Müşteri ekleme işlemi
*/
public function musteriekle($adsoyad,$kullaniciadi){

$this->db->insert('musteriler',array('adsoyad'=>$adsoyad,'kullaniciadi'=>$kullaniciadi,'uyeliktarihi'=>date('Y-m-d h:i:s')));

return $this->db->insert_id();
}

/*
Müşteri sorgulama işlemi
*/
public function musterivarmi($kullaniciadi){

return $this->db->from('musteriler')->where('kullaniciadi',$kullaniciadi)->get()->row_array();

}


/*
Servis kaydı ekleme işlemi
*/
public function kayitekle($data){

$this->db->insert('servisbilgisi',$data);

return true;
}




}


 ?>