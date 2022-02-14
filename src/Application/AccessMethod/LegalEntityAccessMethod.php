<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Metadata\AttributeMetadata;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;
use Generator;

class LegalEntityAccessMethod implements SelectInterface
{

	const METADATA = [
		"lslp_id" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::FOREIGN_CONSTRAINT
		],
		"lsle_name" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::NO_CONSTRAINT
		],
		"lsle_legal_form" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::NO_CONSTRAINT
		],
		"lsle_registration_date" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::NO_CONSTRAINT
		],
		"lsle_registration_number" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::NO_CONSTRAINT
		],
	];

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