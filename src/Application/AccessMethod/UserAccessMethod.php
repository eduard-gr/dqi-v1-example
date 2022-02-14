<?php


namespace DataQueryInterface\Example\Application\AccessMethod;

use DataQueryInterface\Example\Application\Repository\UserRepository;
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

class UserAccessMethod implements SelectInterface, InsertInterface, UpdateInterface
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
	private UserRepository $user_repository;


	public function __construct(
		LoggerInterface $logger,
		StatementInterface $statement,
		UserRepository $user_repository
	){
		$this->logger = $logger;
		$this->statement = $statement;
		$this->user_repository = $user_repository;

		if($statement instanceof InsertStatement){
			if($statement->getData()->hasKey('lslp_id') == false){
				throw new Exception('value lslp_id is autoincrement is required');
			}

			if($statement->getData()->hasKey('lsusr_id')){
				throw new Exception('value lsusr_id is autoincrement');
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

		yield from $this->user_repository->select(
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

		yield from $this->user_repository->insert(
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

		yield from $this->user_repository->update(
			$update->getReturning()->toArray(),
			$data,
			$condition);
	}
}