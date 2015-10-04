<?php
namespace MaxS\RandomMovie\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "MaxS.RandomMovie".      *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class MovieRepository extends Repository {

	// add customized methods here

  /**
   * @todo add ability to filter by genre/minRating
   */
  public function findRandom($genre, $minRating) {
    $rows = $this->createQuery()->execute()->count();
    $row_number = mt_rand(0, max(0, ($rows - 1)));
    return $this->createQuery()->setOffset($row_number)->setLimit(1)->execute()->getFirst();
  }

}
