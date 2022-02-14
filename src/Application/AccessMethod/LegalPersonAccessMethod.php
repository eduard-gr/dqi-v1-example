<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use DataQueryInterface\Example\Application\Repository\LegalPersonRepository;
use Exception;
use Generator;
use Trackpoint\DataQueryInterface\Expression\Condition;
use Trackpoint\DataQueryInterface\Metadata\AttributeMetadata;
use Trackpoint\DataQueryInterface\Statement\InsertInterface;
use Trackpoint\DataQueryInterface\Statement\InsertStatement;
use Trackpoint\DataQueryInterface\Statement\SelectInterface;
use Trackpoint\DataQueryInterface\Statement\SelectStatement;
use Trackpoint\DataQueryInterface\Statement\StatementInterface;
use Trackpoint\DataQueryInterface\Statement\UpdateInterface;
use Trackpoint\DataQueryInterface\Statement\UpdateStatement;


class LegalPersonAccessMethod implements SelectInterface, InsertInterface, UpdateInterface
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
	private LegalPersonRepository $legal_person_repository;

	/**
	 * LegalPersonAccessMethod constructor.
	 * @param StatementInterface $statement
	 * @param LegalPersonRepository $legal_person_repository
	 */
	public function __construct(
		StatementInterface $statement,
		LegalPersonRepository $legal_person_repository
	){
		$this->statement = $statement;
		$this->legal_person_repository = $legal_person_repository;

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

		yield from $this->legal_person_repository->select(
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

		yield from $this->legal_person_repository->insert(
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

		yield from $this->legal_person_repository->update(
			$update->getReturning()->toArray(),
			$data,
			$condition);
	}
}