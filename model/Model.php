<?php

class Model
{
	public function __construct($id = null)
    {
		$className = strtolower(get_class($this));
		$classNameAttrib = substr($className, strlen($className)-3);
		$classNameAttrib .= "_id";
		$_SESSION["debug"] = $classNameAttrib;
		if($id!=null)
		{
			$requette = db()->prepare("SELECT * from $className where $classNameAttrib =:id");
			$requette->bindValue(":id",$id);
			$requette->execute();
			$row = $requette->fetch(PDO::FETCH_ASSOC);
			foreach ($row as $attr => $value) 
			{
				$this->$attr = $value;
			}
		}
		else
		{
			$req = db()->prepare("INSERT into $className default values returning $classNameAttrib");
			$req->execute();
			$row = $req->fetch();
			$this->$classNameAttrib = $row[$classNameAttrib];
		}
	}
	
	public function __get($attr)
	{
		if(property_exists(get_class($this), $attr))
		{
			return $this->$attr;
		}
		else
		{
			die("Plantage __get");
			return null;
		}
	}
	
	public function __set($attr, $value)
	{
        
		if(property_exists(get_class($this), $attr))
		{
			$this->$attr = $value;
			$className = strtolower(get_class($this));
			$classNameAttrib = substr($className, strlen($className)-3);
			$classNameAttrib .= "_id";
			$req = db()->prepare("UPDATE $className set $attr=:value where $classNameAttrib =:id");
			$id = $classNameAttrib;
			$req->bindValue(":id", $this->$id);
			$req->bindValue(":value", $value);
			$req->execute();
            
		}
		else
		{
			die("Plantage __set");
		}
	}
	
	public function __toString() 
	{
		$affich = "<ul>".get_class($this)." : ";
		foreach ($this as $attr => $value) 
		{
			$affich .= "<li>".$attr." = ".$value;
		}
		$affich .= "</ul>";
		return $affich;
	}

	public static function findAll() 
	{
        $className = strtolower(get_called_class());
		$table = substr($className, strlen($className)-3);
		$table .= "_id";
        $st = db()->prepare("SELECT * from $className");
        $st->execute();
        $stuffList = array();
        while ($row = $st->fetch(PDO::FETCH_ASSOC)) 
        {
            $stuffList[] = new $className($row[$table]);
        }
        return $stuffList;
    }
    
    //Fonction permettant de récupérer les attributs contenus dans la classe courante
    public function getAttrs() 
    {
    	return get_class_vars(get_called_class());
    }

}

?>