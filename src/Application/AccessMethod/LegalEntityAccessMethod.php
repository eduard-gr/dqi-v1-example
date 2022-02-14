<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use DataQueryInterface\Example\Application\Repository\LegalEntityRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Metadata\AttributeMetadata;
use Trackpoint\DataQueryInterface\Statement\InsertInterface;
use Trackpoint\DataQueryInterface\Statement\InsertStatement;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\SelectStatement;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;
use Generator;
use Trackpoint\DataQueryInterface\Statement\UpdateInterface;
use Trackpoint\DataQueryInterface\Statement\UpdateStatement;

class LegalEntityAccessMethod implements SelectInterface, InsertInterface, UpdateInterface
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
	private LegalEntityRepository $legal_entity_repository;

	public function __construct(
		LoggerInterface $logger,
		StatementInterface $statement,
		LegalEntityRepository $legal_entity_repository
	){
		$this->logger = $logger;
		$this->statement = $statement;
		$this->legal_entity_repository = $legal_entity_repository;

		if($statement instanceof InsertStatement){
			if($statement->getData()->hasKey('lslp_id')){
				throw new Exception('value lslp_id is autoincrement');
			}
		}
	}


	public function fetch(
		Condition $condition
	): Generator
	{

		/**
		 * @var SelectStatement $select
		 */
		$select = $this->statement;

		yield from $this->legal_entity_repository->select(
			$select->getReturning()->toArray(),
			$select->getCondition());

	}


	public function insert(
		array $data
	): Generator
	{

		/**
		 * @var InsertStatement $insert
		 */
		$insert = $this->statement;

		yield from $this->legal_entity_repository->insert(
			$insert->getReturning()->toArray(),
			$data);

	}

	public function update(
		Condition $condition,
		array $data
	): Generator
	{
		/**
		 * @var UpdateStatement $update
		 */
		$update = $this->statement;

		yield from $this->legal_entity_repository->update(
			$update->getReturning()->toArray(),
			$data,
			$condition);
	}
}