<?php

namespace App\Project\CatrobatCode\Statements;

use App\Project\CatrobatCode\SyntaxHighlightingConstants;

class LoopEndlessStatement extends Statement
{
  /**
   * @var string
   */
  final public const BEGIN_STRING = 'endless loop';
  /**
   * @var string
   */
  final public const END_STRING = '<br/>';

  /**
   * LoopEndlessStatement constructor.
   *
   * @param mixed $statementFactory
   * @param mixed $xmlTree
   * @param mixed $spaces
   */
  public function __construct($statementFactory, $xmlTree, $spaces)
  {
    $stmt = SyntaxHighlightingConstants::LOOP.self::BEGIN_STRING.SyntaxHighlightingConstants::END;
    parent::__construct($statementFactory, $xmlTree, $spaces - 1,
      $stmt,
      self::END_STRING);
  }

  public function getBrickText(): string
  {
    return 'End of loop';
  }

  public function getBrickColor(): string
  {
    return '1h_brick_orange.png';
  }
}
