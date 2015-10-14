<?php
namespace MaxS\RandomMovie\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "MaxS.RandomMovie".      *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use MaxS\RandomMovie\Domain\Model\Movie;

// Snippet to fill up the database
// for ($i=1; $i <= 100; $i++) {
// 	//max nr 2719848
// 	$this->createAction(sprintf('tt%07d', $i));
// }


class MovieController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \MaxS\RandomMovie\Domain\Repository\MovieRepository
	 */
	protected $movieRepository;

	/**
	 * @Flow\Inject
	 * @var \MaxS\RandomMovie\Domain\Service\ImdbServiceRegex
	 */
	protected $movieService;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('movies', $this->movieRepository->findAll());
	}

	/**
	 * @param \MaxS\RandomMovie\Domain\Model\Movie $movie
	 * @return void
	 */
	public function showAction(Movie $movie) {
		$this->view->assign('movie', $movie);
	}

	/**
	 * Finds a random movie in general or by genre and/or minrating
	 *
	 * @param string $genre
	 * @param integer $minRating
	 * @return void
	 */
	public function randomMovieAction($genre = NULL, $minRating = NULL) {
		$this->view->assign('movie', $this->movieRepository->findRandom($genre, $minRating));
	}

	/**
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * @param string $link
	 * @return void
	 */
	public function createAction($link) {

		$newMovie = $this->movieService->getMovieData($link);

		if (NULL === $this->movieRepository->findByLink($newMovie['link'])->getFirst()) {
			$newMovie = $this->setMovieProperties($newMovie);
			$this->movieRepository->add($newMovie);
			$this->addFlashMessage($newMovie->getTitle() . ' successfully added.');
		} else {
			$this->addFlashMessage('Movie already exists');
		}

		$this->redirect('index');
	}

	/**
	 * Just for now some shiity code
	 * @todo refactor
	 *
	 * @var array $newMovie
	 * @return \MaxS\RandomMovie\Domain\Model\Movie
	 */
	protected function setMovieProperties($newMovie) {
		$movie = new Movie();

		$movie->setTitle($newMovie['title']);
		$movie->setDescription($newMovie['description']);
		$movie->setGenre($this->buildGenreString($newMovie['genre']));
		$movie->setMetascore($newMovie['metascore']);
		$movie->setRating($newMovie['rating']);
		$movie->setLink($newMovie['link']);
		$movie->setYear($newMovie['year']);

		return $movie;
	}

	/**
	 * Just for now some shiity code
	 * @todo refactor
	 *
	 * @var array $genreArray
	 * @return string
	 */
	protected function buildGenreString($genreArray) {
		$genres = '';
		$maxIndex = count($genreArray) - 1;

		foreach ($genreArray as $index => $genre) {
			$genres .= $genre;
			if ($index < $maxIndex) {
				$genres .= ', ';
			}
		}

		return $genres;
	}

	/**
	 * @param \MaxS\RandomMovie\Domain\Model\Movie $movie
	 * @return void
	 */
	public function updateAction(Movie $movie) {
		$this->movieRepository->update($movie);
		$this->addFlashMessage('Updated the movie.');
		$this->redirect('index');
	}

	/**
	 * @param \MaxS\RandomMovie\Domain\Model\Movie $movie
	 * @return void
	 */
	public function deleteAction(Movie $movie) {
		$this->movieRepository->remove($movie);
		$this->addFlashMessage('Successfully deleted ' . $movie->getTitle());
		$this->redirect('index');
	}

}
