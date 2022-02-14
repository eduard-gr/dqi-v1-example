<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use Generator;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Metadata\AttributeMetadata;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;


class LegalPersonAccessMethod implements SelectInterface
{
	const METADATA = [
		"lslp_id" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::PRIMARY_CONSTRAINT
		],
		"lslp_type" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::NO_CONSTRAINT
		],
		"lslp_status" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::NO_CONSTRAINT
		],
		"lslp_begin" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::NO_CONSTRAINT
		],
		"lslp_end" => [
			AttributeMetadata::CONSTRAINT => AttributeMetadata::NO_CONSTRAINT
		],
	];


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