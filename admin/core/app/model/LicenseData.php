<?php
class LicenseData {
	public static $tablename = "license";

	public function LicenseData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->category_id = "NULL";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function getProject(){ return ProjectData::getById($this->project_id); }
	public function getUser(){ return UserData::getById($this->user_id); }

	public function add(){
		$sql = "insert into ".self::$tablename." (date_at,is_active,project_id,user_id,created_at) ";
		$sql .= "value (\"$this->date_at\",\"$this->is_active\",$this->project_id,$this->user_id,$this->created_at)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto LicenseData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set title=\"$this->title\",project_id=$this->project_id,category_id=$this->category_id,description=\"$this->description\" where id=$this->id";
		Executor::doit($sql);
	}

	public function activate(){
		$sql = "update ".self::$tablename." set is_active=\"$this->is_active\" where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new LicenseData());
	}

	public static function getByUP($user,$project){
		$sql = "select * from ".self::$tablename." where user_id=$user and project_id=$project and is_active=1";
		$query = Executor::doit($sql);
		return Model::one($query[0],new LicenseData());
	}


	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new LicenseData());
	}

	public static function getPendings(){
		$sql = "select * from ".self::$tablename." where is_done=0";
		$query = Executor::doit($sql);
		return Model::many($query[0],new LicenseData());
	}

	public static function getPendingsL($l){
		$sql = "select * from ".self::$tablename." where is_done=0 limit $l";
		$query = Executor::doit($sql);
		return Model::many($query[0],new LicenseData());
	}


	public static function getAllByProjectId($id){
		$sql = "select * from ".self::$tablename." where project_id=$id order by created_at";
		$query = Executor::doit($sql);
		return Model::many($query[0],new LicenseData());
	}


	public static function getBySQL($sql){
		$query = Executor::doit($sql);
		return Model::many($query[0],new LicenseData());
	}
	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where title like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new LicenseData());
	}


}

?>