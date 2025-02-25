<?php

class Database
{
	private PDO $pdo;
	private \PDOStatement $stmt;

	public function __construct()
	{
		$dsn = 'mysql:host=' . DB_SETTINGS['host'] . '; dbname=' . DB_SETTINGS['database'] . '; charset=' . DB_SETTINGS['charset'];
		$this->pdo = new PDO($dsn, DB_SETTINGS['username'], DB_SETTINGS['password'], DB_SETTINGS['options']);
	}

	public function query(string $query, array $params = []): static
	{
		$this->stmt = $this->pdo->prepare($query);
		$this->stmt->execute($params);

		return $this;
	}

	public function prepare($query): static
	{
		$this->stmt = $this->pdo->prepare($query);

		return $this;
	}

	public function execute($params = []): static
	{
		$this->stmt->execute($params);

		return $this;
	}

	public function getAll(): array|false
	{
		return $this->stmt->fetchAll();
	}

	public function getOne(): array|false
	{
		return $this->stmt->fetch();
	}

	public function getLastId(): bool|string
	{
		return $this->getPdo()->lastInsertId();
	}

	public function getColumn(): false|array
	{
		return $this->stmt->fetchAll(PDO::FETCH_COLUMN);
	}

	public function getPdo(): PDO
	{
		return $this->pdo;
	}

	public function check($string, $params): bool
	{
		$sql = 'SELECT 1 FROM ' . $string;
		$res = $this->query($sql, $params)->getOne();

		return (bool)$res;
	}
}
