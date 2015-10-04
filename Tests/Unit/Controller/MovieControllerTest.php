<?php
namespace MaxS\RandomMovie\Tests\Unit\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "MaxS.RandomMovie".      *
 *                                                                        *
 *                                                                        */

/**
 * Testcase for MovieController
 */
class MovieControllerTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @test
	 */
	public function createsMovies() {
		$movieController = $this->getMock(\MaxS\RandomMovie\Controller\MovieController::class,
      array('addFlashMessage', 'redirect'));

    $imdbService = $this->getMockBuilder(\MaxS\RandomMovie\Domain\Service\ImdbService::class)
      ->disableOriginalConstructor()
      ->getMock();

    $movieController->expects($this->once())
      ->method('addFlashMessage');

    $movieController->expects($this->once())
      ->method('redirect');

    $imdbService->expects($this->once())
      ->method('getMovieData')
      ->with('tt0111161')
      ->willReturn(array('False'));


    $this->inject($movieController, 'imdbService', $imdbService);

    $movieController->createAction('tt0111161');
	}
}
