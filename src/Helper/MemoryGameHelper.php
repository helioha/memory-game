<?php

namespace Drupal\memory_game\Helper;

class MemoryGameHelper {

  /**
   * Create a new memory game.
   *
   * @param int $rows
   *   The number of rows.
   * @param int $columns
   *   The number of columns.
   *
   * @return array
   *    The information of the new memory game.
   *
   * @throws \Exception
   */
  public static function createGame(int $rows, int $columns): array {
    $uniqueCardsCount = ($rows * $columns) / 2;
    $uniqueCards = self::getUniqueCards($uniqueCardsCount);
    $board = self::createBoard($rows, $columns, $uniqueCards);

    return [
      'rowsCount' => $rows,
      'columnsCount' => $columns,
      'uniqueCards' => $uniqueCards,
      'board' => $board,
    ];
  }

  /**
   * Create the memory game board.
   *
   * @param int $rows
   *   The number of rows.
   * @param int $columns
   *   The number of columns.
   * @param array $uniqueCards
   *   The unique cards.
   *
   * @return array
   *   The memory game board.
   *
   * @throws \Exception
   */
  public static function createBoard(int $rows, int $columns, array $uniqueCards): array {
    // Validate the board dimensions.
    self::validateDimensions($rows, $columns);

    // Create and shuffle the memory cards.
    $memoryCards = array_merge($uniqueCards, $uniqueCards);
    shuffle($memoryCards);

    // Sanity check
    if (count($memoryCards) !== $rows * $columns) {
      throw new \Exception('The number of cards is not equal to the number of rows and columns.');
    }

    // Create the memory game board.
    $board = [];
    for ($row = 0; $row < $rows; $row++) {
      $board[$row] = [];
      for ($column = 0; $column < $columns; $column++) {
        $board[$row][$column] = array_pop($memoryCards);
      }
    }

    return $board;
  }

  /**
   * This function returns an array of integers that represent the unique cards.
   *
   * @param int $count
   *   The number of cards to create.
   *
   * @return array
   *   An array of cards.
   */
  public static function getUniqueCards(int $count): array {
    $cardElements = [];
    for ($i = 0; $i < $count; $i++) {
      $cardElements[] = $i;
    }
    return $cardElements;
  }

  /**
   * Validate the board dimensions.
   *
   * @param int $rows
   *   The number of rows.
   * @param int $columns
   *   The number of columns.
   *
   * @return void
   *
   * @throws \Exception
   */
  public static function validateDimensions(int $rows, int $columns): void {
    if ($rows < 1) {
      throw new \Exception('The number of rows must be greater than 0.');
    }

    if ($rows > 6) {
      throw new \Exception('The number of rows must be less than or equal to 6.');
    }

    if ($columns < 1) {
      throw new \Exception('The number of columns must be greater than 0.');
    }

    if ($columns > 6) {
      throw new \Exception('The number of columns must be less than or equal to 6.');
    }

    if ($columns % 2 !== 0 && $rows % 2 !== 0) {
      throw new \Exception('Either the number of rows or columns must be even.');
    }
  }
}
