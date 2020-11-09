<?php

namespace App\Services;

class CreateInfoForIndexService {
  public function generateGenreArrayForNav($items)
  {
    $genre = [];
    foreach($items as $item)
    {
        $genre[] = $item->genre;
    };
    $genre_for_nav = array_unique($genre);
    return $genre_for_nav;
  }
}
