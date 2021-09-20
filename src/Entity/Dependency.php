<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints\Uuid;

#[ApiResource(
     collectionOperations: ['get', 'post'],
    itemOperations: ['get'],
)]
class Dependency
{


    #[ApiProperty(
        identifier: true
    )]
    private string $uuid;

    #[ApiProperty(
        description: 'nom de la dépendance'
    )]
    private string $name;


    #[ApiProperty(
        description: 'version de la dépendance',
        openapiContext: [
            'example' => "2.3*"
        ]
    )]
    private string $version;

    public function __construct(
        string $uuid,
        string $name,
        string $version
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->version = $version;

    }

    public function getUuid(): string
    {
        return $this->uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

}
