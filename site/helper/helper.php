<?php
namespace helper;
use config\Config;
class helper
{

    public function importCsv($request) :array
    {

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        $spreadsheet = $reader->load($request['tmp_name']);

        return $spreadsheet->getActiveSheet()->toArray();
    }
    public function createDBData($data)
    {
        try {
            $db = $this->connectionDB();
            $sql = "INSERT INTO users (name, surname, email, employee_id, phone, point) VALUES (:name, :surname, :email, :employee_id, :phone, :point)";
            $dbCreate = $db->prepare($sql);
            $dbCreate->execute($data);
        }catch (\Exception $exception){
            // sql dublicate hatalarında kayıt eklemeyıp devam etmesi için böyle return true edildi
            // geliştirme olarak dublıcate kayıtları loglana bılır...
            return true;
        }


    }
    public function getDBData(){
        try {
            $db = $this->connectionDB();
            $sql = "SELECT * FROM users";
            $dbAll = $db->prepare($sql);
            $dbAll->execute();
            $result = $dbAll->fetchAll();
            return $result;

        }catch (\Exception $exception){
            return $exception;
        }
    }
    public function connectionDB()
    {
        $host   = Config::$databaseHost;
        $db     = Config::$databaseName;
        $user   = Config::$databaseUser;
        $pass   = Config::$databasePass;
        $port   = Config::$databasePort;
        $charset= Config::$databaseCharset;

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        try {
            $pdo = new \PDO($dsn, $user, $pass, $options);
            return $pdo;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    public function phoneFormatter($phone) :int
    {
        $first = substr($phone,"0","1");
        if($first == 0){
            $phone = str_replace(str_split('()-'),'',ltrim($phone,0));
        }
        $phone = str_replace(str_split('()-'),'',$phone);
        return $phone;
    }
}