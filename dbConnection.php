<?php 

class dbConnection 
{
	
	protected $username="root";
		protected $password="";
		protected $database="db_upload_image";
		protected $host="localhost";
		protected $port=3303;
		protected $tableName="hinh_anh";
		protected static $connectionInstance=null;
		protected $queryParams=[];


		public function __construct()
		{
			$this->connect();
		}
		public function connect()
		{
			if(self::$connectionInstance ===null)
			{
				try
				{
					self::$connectionInstance = new PDO("mysql:host=".$this->host.":".$this->port.";dbname=".$this->database, $this->username, $this->password);		
					self::$connectionInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
				catch(Exception $e)
				{
					echo "ERROR: ".$e->getMessage();
					die();
				}

			}
			else
				return self::$connectionInstance;
		}

		public function query($sql, $params=[])
		{
			$q=self::$connectionInstance->prepare($sql);
			
			if(is_array($params)&&$params)
			{
				$q->execute($params);
			}
			else
			{
				$q->execute();
			}
			
			return $q;
		}

		public function select()
		{
			$sql="select * from hinh_anh;";
			$query=$this->query($sql, []);
			
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		public function insert($id=0, $image_name="")
		{
			$sql="insert into hinh_anh value(".$id.",'".$image_name."') ";

			var_dump($sql);
			return $this->query($sql);
		}
}

 ?>