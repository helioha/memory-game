<?php

namespace Drupal\memory_game\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\memory_game\Helper\MemoryGameHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MemoryGameController extends ControllerBase {

  /**
   * Create a new memory game.
   *
   * @param Request $request
   *   The request object.
   *
   * @return JsonResponse
   *    The information of the new memory game.
   */
  public function createGame(Request $request): JsonResponse {
    try {
      $rows = $this->getRowsCount($request);
      $columns = $this->getColumnsCount($request);

      $memoryGameData = MemoryGameHelper::createGame($rows, $columns);
      $memoryGameData['status'] = 'ok';
    }
    catch (\Exception $e) {
      $memoryGameData = [
        'status' => 'error',
        'message' => $e->getMessage(),
      ];
    }

    return new JsonResponse($memoryGameData);
  }

  /**
   * Get the number of rows from the request.
   *
   * @param Request $request
   *   The request object.
   * @return int
   *   The number of rows.
   *
   * @throws \Exception
   */
  protected function getRowsCount(Request $request): int {
    $rows = $request->query->get('rows');

    if ($rows === NULL) {
      throw new \Exception('The required rows query parameter is missing.');
    }

    return (int) $rows;
  }

  /**
   * Get the number of columns from the request.
   *
   * @param Request $request
   *   The request object.
   * @return int
   *   The number of columns.
   *
   * @throws \Exception
   */
  protected function getColumnsCount(Request $request): int {
    $columns = $request->query->get('columns');

    if ($columns === NULL) {
      throw new \Exception('The required columns query parameter is missing.');
    }

    return (int) $columns;
  }
}
