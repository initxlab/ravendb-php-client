<?php

namespace RavenDB\Dev\Toolkit;

class Parser
{
    private $file;
    private const MIGRATION_CONFIG="_migration/";
    private const MIGRATION_GENERATOR_PATH="_migration/config/";
    public function __construct($file)
    {
        $this->file = self::MIGRATION_CONFIG.$file;
        if(!is_file($this->file)){
            exit("Ups");
        }
    }

    public function toObject(){
        return json_decode(file_get_contents($this->file));
    }

    public function loopObject(object $objects): array
    {
        $collect=[];
        foreach($objects as $name=>$object){
            $collect[$name] = $objects;
        }
        return $collect;
    }

    public function exceptionsGenerator(object $objects,string $targetPath):void
    {
        $path = self::MIGRATION_GENERATOR_PATH.$targetPath;

        if(!is_dir($path)){ exit("UPS ::: Undefined target Path");}

        $exceptions = $this->loopObject($objects);
        $files=[];

        foreach($exceptions as $name=>$exception){
            $generate = $path."/".$name.".php";
            if(is_file($generate)) unlink($generate);
                $data = <<<EOT
<?php
namespace RavenDB\Migration\Exceptions; 

/**
 * Class $name
 * @package RavenDB\Migration\Exception
 * Auto generated from ravenDB Nodejs Client Env Config. Subject to manual adjustements
 */
class $name extends \Exception { 
   protected \$message = "Throw $name message";
}
EOT;
                echo "File regenerated ".PHP_EOL;
                file_put_contents($generate,$data);
        }
    }
}