<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;
use Generator;

/**
 * [
 * 	"lsusr_id",
 * 	"lslp_id",
 * 	"lsusr_status",
 * 	"lsusr_begin",
 * 	"lsusr_end"
 * ]
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