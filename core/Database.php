<?php

class Database
{
	private PDO $pdo;

	public function __construct($hostname, $database, $username, $password, $charset, $option)
	{
		$dsn = 'mysql:host=' . $hostname . '; dbname=' . $database . '; charset=' . $charset;
		$this->pdo = new PDO($dsn, $username, $password, $option);
	}

	public function query($sql, $vars = []): array|false
	{
		$res = $this->pdo->prepare($sql);
		$res->execute($vars);
		return $res->fetchAll(PDO::FETCH_ASSOC);
	}

}
