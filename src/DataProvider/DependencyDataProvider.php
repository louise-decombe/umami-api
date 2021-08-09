<?php


namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Dependency;
use Ramsey\Uuid\Uuid;

class DependencyDataProvider implements ContextAwareCollectionDataProviderInterface,
    RestrictedDataProviderInterface, ItemDataProviderInterface
{

    private string $rootPath;

    public function __construct(string $rootPath) {
        $this->rootPath = $rootPath;
    }

    private function getDependencies(): array{

        $path = $this->rootPath . '/composer.json';
        //   $json = file_get_contents($path);
        $json = json_decode(file_get_contents($path), true);

            return $json['require'];
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {


        $items = [];

        foreach ($this->getDependencies() as $name => $version){
            $items[] = new Dependency(Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString(), $name, $version);
        }

        return $items;

    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {

        return $resourceClass == Dependency::class;

    }


    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {

        $dependencies = $this->getDependencies();

        foreach ($dependencies as $name-> $version) {

            $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();

            if ($uuid == $id){
                return new Dependency($uuid, $name, $version
                );
            }

        }

    }
}