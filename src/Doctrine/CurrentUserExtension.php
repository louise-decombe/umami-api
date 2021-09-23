<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Recipe;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class CurrentUserExtension implements QueryCollectionExtensionInterface
{

    public function __construct(private Security $security){

    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ){

        if($resourceClass == Recipe::class){

$alias = $queryBuilder->getRootAliases()[0];
$queryBuilder
    ->andWhere("$alias.user = :current_user")
    ->setParameter('current_user', $this->security->getUser());
        }

    }


}