<?php
	class T_j_reponsequestionresto_req{
		protected $avi_id;
		protected $que_id;
		protected $req_reponse;

		public function __construct($avi_id, $que_id, $req_reponse) {
			$this->avi_id = $avi_id;
			$this->que_id = $que_id;
			$this->req_reponse = $req_reponse;
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

		public static function allQuestion($avi_id){
			$req=db()->prepare("SELECT * FROM t_j_reponsequestionresto_req WHERE avi_id = ".$avi_id.";");
			$req->execute();
			$list = array();
			while ($row=$req->fetch(PDO::FETCH_ASSOC)) {
				$list[] = new T_j_reponsequestionresto_req($row['avi_id'], $row['que_id'], $row['req_reponse']);
			}
			return $list;
		}
	}