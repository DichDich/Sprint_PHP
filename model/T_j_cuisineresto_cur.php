<?php
	class T_j_cuisineresto_cur extends Model{
		protected $cui_id;
		protected $res_id;

		//Retourne la liste de resto = a l'id de type cuisine saisie en parametre
		public static function restoTypeCui($idTypeCui){
			$requete = db()->prepare("SELECT * FROM t_j_cuisineresto_cur WHERE cui_id = $idTypeCui");
			$requete->execute();
			$list = array();
			while($row = $requete->fetch(PDO::FETCH_ASSOC)){
				$list[] = new T_e_restaurant_res($row['res_id']);
			}
			return $list;
		}

	}