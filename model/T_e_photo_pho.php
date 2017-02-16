<?php 
class T_e_photo_pho extends Model{
	protected $pho_id;
    protected $res_id;
    protected $avi_id;
    protected $pho_url;

    public static function insertImg($url, $res_id){
    	$req=db()->prepare("INSERT INTO t_e_photo_pho (res_id, pho_url) VALUES ('".$res_id."','".$url."');");
    	$req->execute();
    }
}