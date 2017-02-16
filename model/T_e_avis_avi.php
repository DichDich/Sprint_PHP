<?php
	class T_e_avis_avi extends Model{
		protected $avi_id;
		protected $res_id;
		protected $rep_id;
		protected $per_id;
		protected $abo_id;
		protected $avi_date;
		protected $avi_titre;
		protected $avi_detail;
		protected $avi_noteglobale;
		protected $avi_platsconseilles;
		protected $avi_reponserestaurateur;
		protected $avi_langue;

		//Retourne liste d'avis = id resto passer en parametre
		public static function listAvisResto($id_res){
			$requete = db()->prepare("SELECT * FROM t_e_avis_avi WHERE res_id = $id_res");
			$requete->execute();
			$list = array();
			while ($row=$requete->fetch(PDO::FETCH_ASSOC)){
				$list[] = new T_e_avis_avi($row['avi_id']);
			}
			return $list;
		}

		public static function listAvisAbo($id_abo){
			$requete = db()->prepare("SELECT * FROM t_e_avis_avi WHERE abo_id = $id_abo");
			$requete->execute();
			$list = array();
			while ($row=$requete->fetch(PDO::FETCH_ASSOC)){
				$list[] = new T_e_avis_avi($row['avi_id']);
			}
			return $list;
		}
		
		public static function avistriLangue($avi_langue, $id_res){
            //echo $avi_langue;
			$requete = db()->prepare("SELECT * FROM t_e_avis_avi WHERE avi_langue = '" . $avi_langue . "' and res_id = $id_res");
			$requete->execute();
            //print_r(db()->errorInfo());
			$list = array();
			while ($row=$requete->fetch(PDO::FETCH_ASSOC)){
				$list[] = new T_e_avis_avi($row['avi_id']);
			}
			return $list;
		}

		public static function ajoutReponse($avi_id, $descr_rep){
			$req = db()->prepare("UPDATE t_e_avis_avi set avi_reponserestaurateur=:descr_rep where avi_id =:id");
			$req->bindValue(":descr_rep", $descr_rep);
			$req->bindValue(":id", $avi_id);
			$req->execute();
		}

	}