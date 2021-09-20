<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\RecipeCountController;
use App\Controller\RecipePublishController;
use App\Repository\RecipeRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post',
        'count' => [
            'method' => 'GET',
            'path' => '/post/count',
            'controller' => RecipeCountController::class,
            'read'=> false,
            'pagination_enabled'=> false,
            'filters'=>  [],
            'openapi_context'=> [
                'summary'=>'Nombre de rectte correspondantes',
                'parameters'=> [],
            ]
        ]
],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:collection', 'read:item', 'read:Recipe'],
            'openapi_definition_name' => 'Detail'
            ]
        ],
        'publish' => [
            'method' => 'POST',
            'path'=> '/posts/{id}/publish',
            'controller'=> RecipePublishController::class,
            'openapi_context'=> [
                'summary' => 'permet de publier une recette de cuisine',
                'requestBody'=> [
                    'content' => [
                        'application/json' => [
                            'schema' => []
                        ]
                    ]
                ]
            ]
        ]
    ],
    normalizationContext: [
        'groups' => ['read:collection'],
        'openapi_definition_name' => 'Collection'
    ],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 2,
    paginationMaximumItemsPerPage: 2
)]
    #[ApiFilter(
        SearchFilter::class, properties: ['id'=> 'exact', 'title'=>'partial']
    )]

class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $slug;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $content;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="recipes")
     */
    private ?Category $category;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    #[Groups(['read:collection']),
    ApiProperty(openapiContext: ['type'=>'boolean', 'description' => 'description'])
    ]
    private ?bool $online;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated�_at): self
    {
        $this->updated_at = $updated�_at;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }
}
