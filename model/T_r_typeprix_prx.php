<?php
	class T_r_typeprix_prx{

		protected $prx_prix;

		public static function listTypePrix(){
			$req = db()->prepare("SELECT * FROM t_r_typeprix_prx");
			$req->execute();
			$list = array();
			while($row = $req->fetch(PDO::FETCH_ASSOC)){
				$list[] = $row['prx_prix'];
			}
			return $list;
		}

	}