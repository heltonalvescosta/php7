<?

namespace Hcode

class Model {
	
	private $value = [];
	
	public function __call($name, $args)
	{
		//para descobrir se é GET ou POST
		$method = substr($name, 0, 3);
		$fieldName = substr($name, 3, strlen($name));
		//var_dump($method, $fieldName);

		switch ($method)
		{
			case "get":
				return (isset($this->values[$fieldName]))?$this->values[$fieldname] : NULL;
				break;
			case "set":
				$this->values[$fieldName] = $args[0]
				break;		
			
		}
		
		
	}
	
	public function setData($data = array())
	{
		foreach ($data as $key => $value){
		
			$this->{"set".$key}($value);
		
		}		
	}
	
	public function getValues()
	{
		
		return $this->values;
		
	}
	
}





?>