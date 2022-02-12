<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;
use Generator;
/**
 * [
 * 	"lslp_id",
 * 	"lsle_name",
 * 	"lsle_legal_form",
 * 	"lsle_registration_date",
 * 	"lsle_registration_number"
 * ]
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