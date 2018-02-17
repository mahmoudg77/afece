<?
namespace Framework;

class Context implements \JsonSerializable{
    protected $data=[];
    var $SERIALIZED_OBJECTS=[];
    //var $user;
    public function __get($name) {
	    return  $this->data[$name];
	}

	public function __set($name, $value) {
	    $this->data[$name] = $value;
	}

		// From JsonSerializable
    public function jsonSerialize(){
        return $this->data;
    }


}
?>
