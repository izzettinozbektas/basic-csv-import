<?php
use helper\helper;
class ImportFileClass
{
    public function create(){
        // request file
        $file = $_FILES['file'];
        $help = new helper;
        $csvData = $help->importCsv($file);
        // mapping data
        for ($i=1; $i< count($csvData); $i++){
            foreach ($csvData[$i] as $key => $cvDt){
                $data[$csvData[0][$key]]=$cvDt;
            }
            $data['phone'] = $help->phoneFormatter($data['phone']);
            $help->createDBData($data);

        }
        return "true";
    }
    public function getData(){
        $help = new helper;
        $data = $help->getDBData();
        return json_encode(['data' =>$data]);
    }
}
// basic
$impStart = new ImportFileClass();
switch ($_SERVER['REQUEST_URI']){
    case "/importFile":
        echo $impStart->create();
        break;
    case "/getData"   :
        print_r($impStart->getData());
        break;
}


































