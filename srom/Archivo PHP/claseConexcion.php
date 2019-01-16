<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
ini_set("display_errors","-1");
set_time_limit ( 0 );

class conexion
{
	private $user = "usuario";
	private $pass = "contraseña";
	private $arrBddCnx = array('DES' => array("ALS" => "server",
							   				  "IP" => "0.0.0.0"),
							   'PRO' => array("ALS" => "server",
							   				  "IP" => "0.0.0.0"),
							   'WEB' => array("ALS" => "server",
							   				  "IP" => "server")
								);

	private $tipoConexion;
	private $servidor;

	public $cnx;
	private $strSql;
	private $arrValores;

	public $arrResultado;
	public $strJson;

	public function __construct()
	{
		$params = func_get_args();
		$num_params = func_num_args();
		$funcion_constructor ='__construct'.$num_params;
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}


	public function __construct3($tipCnx, $svr, $aUsrPass)
	{	$this->servidor = $svr;
		$this->tipoConexion = $tipCnx;
		$this->user = $aUsrPass['usr'];
		$this->pass = $aUsrPass['pass'];
		$this->cnx = $this->establecerTipoCnx($tipCnx);
	}

	public function __construct4($tipCnx, $svr, $sql = "", $arrVal = null)
	{
		$this->servidor = $svr;
		$this->strSql = $sql;
		$this->tipoConexion = $tipCnx;
		$this->cnx = $this->establecerTipoCnx($tipCnx);
	}

	private function establecerTipoCnx($tipCnx)
	{
		$dbconect = NULL;
		$this->servidor = strtoupper($this->servidor);
		switch ($tipCnx)
		 {
			case 'ODBC':
				 if (array_key_exists(strtoupper($this->servidor), $this->arrBddCnx))
				 {
				 	$dsn = "DRIVER={iSeries Access ODBC Driver};SYSTEM=$servidor;Uid=$this->user;Pwd=$this->$pass;";
				 	$dbconect = odbc_connect($dsn, $user, $pass);
				 }
				break;

			case 'DB2':
				if (array_key_exists(strtoupper($this->servidor), $this->arrBddCnx))
				{
					if(!$dbconect = db2_connect($this->servidor,$this->user,$this->pass))
					echo "Error al acceder a la base de datos!" . db2_conn_errormsg();
					$schema = "WE400DB.";
				}
				break;

			case 'PDO':
				if (array_key_exists(strtoupper($this->servidor), $this->arrBddCnx))
				{
					$servidor = "ibm:" . $this->arrBddCnx[$this->servidor]['ALS'];
					try
					{
					    $dbconect = new PDO($servidor, $this->user, $this->pass,
					       array(
					               PDO::ATTR_PERSISTENT => FALSE,
					               PDO::ATTR_AUTOCOMMIT => TRUE,
					           )
					       );
					}
					catch (Exception $e)
					{
					     echo "<br>Error: ".$e;
					     $dbconect = FALSE;
					}
				}
				break;

			default:
				echo "<br>Tipo no valido.<br>";
				$dbconect = FALSE;
				break;
		}
		if ($dbconect === FALSE)
		{
			echo "Ha fallado la conexion a la BBDD </br>";
			return FALSE;
		}
		else
		{
			return $dbconect;
		}
	}

	public function recuperaConsecutiovo($nomtab)
	{
		switch ($this->tipoConexion)
		{
			case 'ODBC':
				break;

			case 'DB2':
				break;

			case 'PDO':
				$sql = "UPDATE tabla ";
				$sql .= " SET CNSTAB = CNSTAB + 1 ";
				$sql .= " WHERE NOMTAB = '" . $nomtab . "'";

				$this->cnx->beginTransaction();

				$x = $this->cnx->prepare($sql);
				$aux = $this->cnx->errorInfo();

				$resultado = $x->execute();

				if ($resultado === FALSE)
				{
				  $x->rollBack();
				  return FALSE;
				}
				else
				{

					$sql = " SELECT * FROM tabla ";
					$sql .= "WHERE NOMTAB = '" . $nomtab . "'";
					$x = $this->cnx->prepare($sql);
					$resultado = $x->execute();
					$resultado = $x->fetchAll(PDO::FETCH_ASSOC);

					if (count($resultado) > 0)
					{
						$this->arrResultado = $resultado;
						return $resultado;
					}
					else
					{
						$this->strJson = json_encode(array('ststus' => '404' , 'msg' => "Sin resultados..."));
						return false;
					}

				}
				break;

		}

	}

	public function selectSimple($sql = "")
	{
		if ($sql == "")
		{
			if ($this->strSql == "")
			{
				return false;
			}
			else
			{
				$sql = $this->strSql;
			}
		}
		else
		{
			$this->strSql = $sql;
		}

		if ($this->cnx === FALSE)
		{
			echo "Ha fallado la conexion a la BBDD </br>";
		}
		else
		{
			$x = $this->cnx->prepare($sql);
			$CUENTA = 0;
						$x = $this->cnx->prepare($sql);
						$aux = $this->cnx->errorInfo();
						if(intval($aux[0]) != 0)
						{
				            $this->strJson = json_encode(array('ststus' => '02' , 'msg' => $aux[2]));
				            return false;
				        }
				        else
				        {
				        	$resultado = $x->execute();
				        	$aux = $this->cnx->errorInfo();

				        		if(intval($aux[0]) != 0)
				        		{
			        	            $this->strJson = json_encode(array('ststus' => '03' , 'msg' => $aux[2]));
			        	            return false;
				        	    }
				        	    else
				        	    {
				        	    	$resultado = $x->fetchAll(PDO::FETCH_ASSOC);
				        	    	if (count($resultado) > 0)
				        	    	{
				        	    		$this->arrResultado = $resultado;
				        	    		return $resultado;
				        	    	}
				        	    	else
				        	    	{
				        	    		$this->strJson = json_encode(array('ststus' => '404' , 'msg' => "Sin resultados..."));
				        	    		return false;
				        	    	}
				        	    }
				        }
		}
	}

	public function insertSimple($sql = "")
	{
		if ($sql == "")
		{
			if ($this->strSql == "")
			{
				return false;
			}
			else
			{
				$sql = $this->strSql;
			}
		}
		else
		{
			$this->strSql = $sql;
		}

		if ($this->cnx === FALSE)
		{
			echo "Ha fallado la conexion a la BBDD </br>";
		}
		else
		{
			$x = $this->cnx->prepare($sql);
			$CUENTA = 0;
						$x = $this->cnx->prepare($sql);
						$aux = $this->cnx->errorInfo();
						if(intval($aux[0]) != 0)
						{
										$this->strJson = json_encode(array('ststus' => '02' , 'msg' => $aux[2]));
										return false;
								}
								else
								{
									$resultado = $x->execute();
									$aux = $this->cnx->errorInfo();

										if(intval($aux[0]) != 0)
										{
														$this->strJson = json_encode(array('ststus' => '03' , 'msg' => $aux[2]));
														return false;
										}
										else
										{
											return true;
										}

									}
								}
		}



	public function __call($name, $args)
	{
		echo "<br>funcion no definida<br>";
		header("Location: err/ErrorMsg.php");
	}

	public function __get($dt)
	{
		throw new Exception("Error variable $dt no definida. ", 1);
	}

	public function __set($dt, $val)
	{
		throw new Exception("Error variable $dt no definida. ", 1);

		echo "<br>variable no definida/inaccesible set<br>";
		header("Location: err/ErrorMsg.php");
	}


	function ConexionMain()
	{

	}
}


?>
