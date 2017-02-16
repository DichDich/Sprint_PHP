<?php 
class T_j_badgeabonne_baa extends Model{
	protected $abo_id;
    protected $bad_id;

    public static function allBadgeAbo($abo_id){
    	$req=db()->prepare("SELECT * FROM t_j_badgeabonne_baa WHERE abo_id=".$abo_id.";");
    	$req->execute();
		$list = array();
		while ($row=$req->fetch(PDO::FETCH_ASSOC)){
			$list[] = new T_r_badge_bad($row['bad_id']);
		}
		return $list;
    } 
}