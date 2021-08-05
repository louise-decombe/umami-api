<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    itemOperations: ['get'], collectionOperations: ['get']
)]
class Dependency {


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


    }

}
