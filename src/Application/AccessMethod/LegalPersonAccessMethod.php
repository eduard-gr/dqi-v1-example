<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use Generator;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;

/**
 * {
 * 	"lslp_id":{"constrain": 1},
 * 	"lslp_type":{"constrain":0},
 * 	"lslp_status":{"constrain":0},
 * 	"lslp_begin":{"constrain":0},
 * 	"lslp_end":{"constrain":0}
 * }
 */
class LegalPersonAccessMethod implements SelectInterface
{

	private StatementInterface $statement;

	public function __construct(StatementInterface $statement)
	{
		$this->statement = $statement;
	}

	public function fetch(
		Condition $condition
	): Generator
	{
		yield [];
	}
}