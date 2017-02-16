<?php
	class T_r_plagehoraire_phr{
		protected $phr_plage;

		public static function allPlage(){
			$req = db()->prepare("SELECT * FROM T_r_plagehoraire_phr");
			$req->execute();
			$listPlage = array();
			while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
				$listPlage[] = $row['phr_plage'];
			}
			return $listPlage;
		}
	}