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

	public function bind_value_int($query, $params): static
	{
		$this->stmt = $this->pdo->prepare($query);
		foreach ($params as $key => $value)
		{
			$this->stmt->bindValue($key, $value, PDO::PARAM_INT);
		}
		$this->stmt->execute();

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

	public function getColumn(): false|array
	{
		return $this->stmt->fetchAll(PDO::FETCH_COLUMN);
	}
}
