<?php
namespace MaxS\RandomMovie\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "MaxS.RandomMovie".      *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Movie {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $shortDescription;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $genre;

	/**
	 * @var float
	 */
	protected $rating;

	/**
	 * @var integer
	 */
	protected $metascore;

	/**
	 * @var integer
	 */
	protected $year;

	/**
	 * @var string
	 */
	protected $imdbID;

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return integer
	 */
	public function getYear() {
		return $this->year;
	}

	/**
	 * @param integer $year
	 * @return void
	 */
	public function setYear($year) {
		$this->year = $year;
	}

	/**
	 * @return string
	 */
	public function getGenre() {
		return $this->genre;
	}

	/**
	 * @param string $genre
	 * @return void
	 */
	public function setGenre($genre) {
		$this->genre = $genre;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getShortDescription() {
		return $this->shortDescription;
	}

	/**
	 * @param string $description
	 * @return void
	 */
	public function setShortDescription($shortDescription) {
		$this->shortDescription = $shortDescription;
	}

	/**
	 * @return integer
	 */
	public function getMetascore() {
		return $this->metascore;
	}

	/**
	 * @param integer $metascore
	 * @return void
	 */
	public function setMetascore($metascore) {
		$this->metascore = $metascore;
	}

	/**
	 * @return float
	 */
	public function getRating() {
		return $this->rating;
	}

	/**
	 * @param float $imdbRating
	 * @return void
	 */
	public function setRating($rating) {
		$this->rating = $rating;
	}

	/**
	 * @return string
	 */
	public function getImdbID() {
		return $this->imdbID;
	}

	/**
	 * @param string $imdbId
	 * @return void
	 */
	public function setImdbID($imdbID) {
		$this->imdbID = $imdbID;
	}

}
