<?php
namespace MaxS\RandomMovie\Domain\Service;


class ImdbServiceRegex implements MovieServiceInterface {

  /**
   * Regex definitions
   */
  const TITLE_PATTERN = '/<h1 class=\"header\"> <span class=\"itemprop\" itemprop=\"name\">(.*)<\/span>/';
  const ORIGINAL_TITLE_PATTERN = '/<span class="title-extra" itemprop="name">\s*"([\w\s]*)"\s*<i>\(original title\)<\/i>\s*<\/span>/';
  const RATING_PATTERN = '/<div class="titlePageSprite star-box-giga-star">(.*)<\/div>/';
  const SHORT_DESCRIPTION_PATTERN = '/<p itemprop="description">\s(.*)<\/p>/';
  const DESCRIPTION_PATTERN = '/<div class=\"inline canwrap\" itemprop=\"description\">\s*<p>\s*(.*)\s*<em class=\"nobr\">/';
  const GENRE_PATTERN = '/<span class="itemprop" itemprop="genre">(.*)<\/span><\/a>/';
  const YEAR_PATTERN = '/<a href="\/year\/[0-9]{4}\/.*>([0-9]{4})<\/a>/s';
  const METASCORE_PATTERN = '/review excerpts provided by Metacritic.com\" >\s*(.*)\s*<\/a>/';

  /**
   * @param string $imdbID - the imdbID
   * @return array
   */
  public function getMovieData($link) {

    $imdbID = $this->extractID($link);
    $requestUrl = $this->buildRequestUrl($imdbID);

    if (($imdbContent = $this->fetchData($requestUrl)) !== FALSE) {
      return $this->buildArray($imdbContent, $requestUrl);
    } else {
      throw new \TYPO3\Flow\Exception('Can\'t conntect to IMDB.');
    }
  }

  /**
   * @param string $imdb - the imdbID or url of a movie
   * @return string
   */
  protected function extractID($imdb) {
    $pattern = '/tt[0-9]{7}/';

    if(preg_match_all($pattern, $imdb, $matches) == 1) {
      $matches = $matches[0][0];
    } else {
      throw new \TYPO3\Flow\Exception('Invalid IMDB-Link or ID!');
    }

    return $matches;
  }

  /**
   * @var string $imdbID
   * @return string
   */
  protected function buildRequestUrl($imdbID) {
    return 'http://www.imdb.com/title/' . $imdbID . '/';
  }

  /**
   * @var string $url
   * @return string
   */
  protected function fetchData($url) {
    return file_get_contents($url);
  }

  /**
   * @var string $imdbContent
   * @var string $requestUrl
   * @return array
   */
  protected function buildArray($imdbContent, $requestUrl) {
    if (empty(preg_match(self::ORIGINAL_TITLE_PATTERN, $imdbContent, $matches))) {
      preg_match(self::TITLE_PATTERN, $imdbContent, $matches);
    }

    $movie['title'] = $this->getResult($matches);

    preg_match(self::SHORT_DESCRIPTION_PATTERN, $imdbContent, $matches);
    $movie['shortDescription'] = $this->getResult($matches);

    preg_match(self::DESCRIPTION_PATTERN, $imdbContent, $matches);
    $movie['description'] = $this->getResult($matches);

    preg_match_all(self::GENRE_PATTERN, $imdbContent, $matches);
    $movie['genre'] = $this->getResult($matches);

    preg_match(self::RATING_PATTERN, $imdbContent, $matches);
    $movie['rating'] = $this->getResult($matches) . ' / 10';

    preg_match(self::METASCORE_PATTERN, $imdbContent, $matches);
    $movie['metascore'] = $this->getResult($matches);

    preg_match(self::YEAR_PATTERN, $imdbContent, $matches);
    $movie['year'] = $this->getResult($matches);

    $movie['link'] = $requestUrl;

    return $movie;
  }

  /**
   * @var string $result
   * @return string
   */
  protected function getResult($result) {
    if (empty($result)) {
      $value = "";
    } else {
      $value = !is_array($result) ? trim($result[1]) : $result[1];
    }

    return $value;
  }

}
