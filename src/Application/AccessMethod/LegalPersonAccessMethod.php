<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use Generator;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;

/**
 * [
 * 	"lslp_id",
 * 	"lslp_type",
 * 	"lslp_status",
 * 	"lslp_begin",
 * 	"lslp_end"
 * ]
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