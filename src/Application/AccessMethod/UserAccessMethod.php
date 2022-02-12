<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;
use Generator;

/**
 * {
 * 	"lsusr_id":{"constrain":1},
 * 	"lslp_id":{"constrain":2},
 * 	"lsusr_status":{"constrain":0},
 * 	"lsusr_begin":{"constrain":0},
 * 	"lsusr_end":{"constrain":0},
 * }
 */
class UserAccessMethod implements SelectInterface
{

	private LoggerInterface $logger;
	private StatementInterface $statement;

	public function __construct(
		LoggerInterface $logger,
		StatementInterface $statement
	){
		$this->logger = $logger;
		$this->statement = $statement;
	}

	public function fetch(
		Condition $condition
	): Generator
	{
		yield [];
	}
}