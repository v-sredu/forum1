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
		return $this;
	}

	public function bind_value_str($query, $params): static
	{
		$this->stmt = $this->pdo->prepare($query);
		foreach ($params as $key => $value)
		{
			$this->stmt->bindValue($key, $value);
		}
		return $this;
	}

	public function execute(): static
	{
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

	public function getPdo(): PDO
	{
		return $this->pdo;
	}
	public function delete($string, $params) : void
	{
		$sql = 'DELETE FROM ' . $string;
		$this->query($sql, $params);
	}
	public function insert($string, $params) : void
	{
		$sql = 'INSERT INTO ' . $string;
		$this->query($sql, $params);
	}
	public function check($string, $params): bool {
		$sql = 'SELECT 1 FROM ' . $string;
		$res = $this->query($sql, $params)->getOne();
		return (bool)$res;
	}
}
