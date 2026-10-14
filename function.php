<?php
// FUNCTION VALIDASI FORM TIDAK BOLEH KOSONG
function tidak_boleh_kosong($data) {
	return !empty($data);
}

// FUNCTION VALIDASI ALFANUMERIK
function alfaNumerik($data) {
    return preg_match("/^[a-zA-Z0-9\s]+$/", $data);
}

// FUNCTION VALIDASI EMAIL
function validasiEmail($email) {
    return preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email);
}

// FUNCTION VALIDASI ALFABET
function alfabet($data){
	return preg_match("/^[a-zA-Z ]+$/", $data);
}

// FUNCTION VALIDASI NUMERIK
function numerik($data){
	return preg_match("/^[0-9]+$/",$data);
}

// FUNCTION VALIDASI PANJANG INPUTAN
function panjang($data,$jumlah){
	return preg_match("/^.{{$jumlah},}$/",$data);
}

// FUNCTION VALIDASI ALFABET DAN NUMERIK
function alfabetDanNumerik($data){
    return preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z0-9]+$/', $data);
}

// FUNCTION VALIDASI RENTANG PANJANG INPUTAN
function rentangPanjang($data,$min,$max){
	return preg_match("/^[0-9]{{$min},{$max}}$/", $data);
}

// FUNCTION VALIDASI TAHUN (4 DIGIT)
function validasitahun($data){
	return preg_match("/^[0-9]{4}$/", $data);
}
?>