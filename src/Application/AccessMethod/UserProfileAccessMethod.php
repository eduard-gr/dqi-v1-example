<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;
use Generator;

/**
 * {
 * 	"lsusr_id":{"constrain":2},
 * 	"lsusr_first_name":{"constrain":0},
 * 	"lsusr_last_name":{"constrain":0},
 * 	"lsusr_gender":{"constrain":0},
 * 	"lsusr_description":{"constrain":0},
 * }
 */
class UserProfileAccessMethod implements SelectInterface
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