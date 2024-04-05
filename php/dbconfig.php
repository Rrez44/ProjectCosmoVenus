<?php



//function getDbCon()
//{


//    $host = 'localhost';
//    $port = 3306;
//    $dbname = 'cosmo';
//    $username = 'root';
//    $password = '1234';
//
//
//    try {
//        $connection = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
//        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        return $connection;
//    } catch (PDOException $e) {
//        echo "Connection failed: " . $e->getMessage();
//        exit;
//    }


    class DbConn{
        private static $instance=null;
        private $conn;
        private function __construct(){
            $host = 'localhost';
            $port = 3306;
            $dbname = 'cosmo';
            $username = 'root';
            $password = '1234';

            try {
                $this->conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $this->conn;
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                exit;
            }

        }

        public static function instanceOfDb(){
            if(self::$instance ==null){
                self::$instance = new self();

            }
                return self::$instance;

        }

        public function getConnection(){
            return $this->conn;
        }

    }



//}
?>