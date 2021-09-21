<?php

namespace App\Repository;

use App\Entity\Dependency;

class DependencyRepository {

    public function __construct(private string $rootPath)
    {
    }

    private function getDependencies() {

        $path = $this->rootPath . './composer.json';
        $json = json_decode(file_get_contents($path), true);
return $json['require'];
    }

    public function findAll()
    {

        $items = [];

        foreach ($dependencies as $name->$version) {

            $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();

            if ($uuid == $id) {
                return new Dependency($name, $version);
            }


        }

        return $items;

    }
      //  public function find(string $uuid){
      //  }


}