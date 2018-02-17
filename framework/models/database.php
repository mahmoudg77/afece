<?
namespace Framework;
use \PDO as PDO;
class Database extends PDO{


 protected $options=[
        PDO::ATTR_TIMEOUT => 120,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => true
        ];

     public function __construct(){

        $dns="mysql:host=".env('db_host','localhost').";dbname=".env('db_name').";charset=".env('db_char','utf8').";wait_timeout=".env('db_timeout',60);
        $user=env('db_user','root');
        $pass=env('db_pass','');
        parent::__construct($dns,$user,$pass,$option);
     }
}

?>
