<?php
namespace MaxS\RandomMovie\Domain\Service;

interface ImdbServiceInterface {
  public function extractID($imdb);
  public function getMovieData($imdbID);
}
