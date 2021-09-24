<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Recipe;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class RecipeTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     */
    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', 'api/recipes');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/Recipe',
            '@id' => '/recipes',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 100,
            'hydra:view' => [
                '@id' => '/recipes?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/recipe?page=1',
                'hydra:last' => '/recipe?page=4',
                'hydra:next' => '/recipe?page=2',
            ],
        ]);

        $this->assertCount(30, $response->toArray()['hydra:member']);

        $this->assertMatchesResourceCollectionJsonSchema(Recipe::class);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     */
    public function testCreateRecipe(): void
    {
        $response = static::createClient()->request('POST', '/api/post/recipes', ['json' => [
            'title' => 'Omelette norvégienne',
            'content' => 'Omelette norvégienne, pour préparer cette recette, prenez soin de récupérer tout les ingrédients',
            'slug' => 'omelette',
            'createdAt' => '1985-07-31T00:00:00+00:00',
            'updatedAt' => '1999-07-31T00:00:00+00:00',
            'online' => '1'

        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Recipe',
            '@type' => 'Recipe',
            'content' => 'Omelette norvégienne, pour préparer cette recette, prenez soin de récupérer tout les ingrédients',
            'slug' => 'omelette',
            'createdAt' => '1985-07-31T00:00:00+00:00',
            'updatedAt' => '1999-07-31T00:00:00+00:00',
            'online' => '1'
        ]);
        $this->assertMatchesRegularExpression('~^/recipe/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Recipe::class);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function testCreateInvalidRecipe(): void
    {
        static::createClient()->request('POST', '/api/post/recipes', ['json' => [
            'id' => 'invalid',
        ]]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'hydra:title' => 'An error occurred',
            'hydra:content' => 'isbn: This is not a right value.
        title: This value should not be blank.
        content: This value should not be blank.
        slug: This value should not be blank.
        createdAt: This value should not be null.
        updatedAt: This value should not be blank.
        online: This value should not be blank.
',
        ]);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function testUpdateRecipe(): void
    {
        $client = static::createClient();
        // findIriBy allows to retrieve the IRI of an item by searching for some of its properties.
        $iri = $this->findIriBy(Recipe::class, ['id' => '1']);

        $client->request('PUT', $iri, ['json' => [
            'title' => 'updated title',
        ]]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'isbn' => '9781344037075',
            'title' => 'updated title',
        ]);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testDeleteRecipe(): void
    {
        $client = static::createClient();
        $iri = $this->findIriBy(Recipe::class, ['id' => '1']);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::$container->get('doctrine')->getRepository(Recipe::class)->findOneBy(['id' => '1'])
        );
    }

}