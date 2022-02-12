<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;
use Generator;
/**
 * {
 * 	"lslp_id":{"constrain":2},
 * 	"lsle_name":{"constrain":0},
 * 	"lsle_legal_form":{"constrain":0},
 * 	"lsle_registration_date":{"constrain":0},
 * 	"lsle_registration_number":{"constrain":0},
 * }
 */
class LegalEntityAccessMethod implements SelectInterface
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