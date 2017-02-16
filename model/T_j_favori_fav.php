<?php
	class T_j_favori_fav{
		protected $abo_id;
		protected $res_id;

		public static function listResFav($userID){
			$requete = db()->prepare("SELECT * FROM t_j_favori_fav WHERE abo_id = $userID");
			$requete->execute();
			$list = array();
			while($row = $requete->fetch(PDO::FETCH_ASSOC)){
				$list[] = new T_e_restaurant_res($row['res_id']);
			}
			return $list;
		}

		public static function ajoutFav($userID, $resID){
			$requete = db()->prepare("INSERT INTO t_j_favori_fav VALUES ('".$userID."','".$resID."');");
			$requete->execute();
		}

		public static function supprFav($userID, $resID){
			$requete = db()->prepare("DELETE FROM t_j_favori_fav WHERE res_id = $resID AND abo_id = $userID;");
			$requete->execute();
		}

	}