<?php

namespace App\Controller;

use App\Entity\Recipe;

class RecipeCountController
{
    public function __invoke(Recipe $data): Recipe
    {
        $data->setOnline(true);
        return $data;
    }
}