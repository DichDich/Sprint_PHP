<?php
	class T_j_reservation_rst{
		protected $res_id;
		protected $phr_plage;

		public function __construct($res_id, $phr_plage){
			$this->res_id=$res_id;
			$this->phr_plage=$phr_plage;
		}

		public function __get($fieldName) {
			if (property_exists(get_class($this), $fieldName)) {
				return $this->$fieldName;
			} else {
				return null;
			}
		}

		public function __set($fieldName, $value) {

			if (property_exists(get_class($this), $fieldName)) {
				$this->$fieldName = $value;
			} else {
				// die("VTFF");
			}
		}

		public static function allReserv($res_id){
			$req = db()->prepare("SELECT * FROM T_j_reservation_rst WHERE res_id = $res_id");
			$req->execute();
			$list = array();
			while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
				$list[] = new T_j_reservation_rst($row['res_id'], $row['phr_plage']);
			}
			return $list;
		}

		public static function insertReserv($res_id, $plageH){
			$req = db()->prepare("INSERT INTO t_j_reservation_rst VALUES ('".$res_id."', '".$plageH."')");
			$req->execute();
		}
	}