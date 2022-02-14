<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Metadata\AttributeMetadata;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;
use Generator;

class UserAccessMethod implements SelectInterface
{

	const METADATA = [
		"lsusr_id" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::PRIMARY_CONSTRAINT
		],
		"lslp_id" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::FOREIGN_CONSTRAINT
		],
		"lsusr_status" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::NO_CONSTRAINT
		],
		"lsusr_begin" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::NO_CONSTRAINT
		],
		"lsusr_end" => [
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