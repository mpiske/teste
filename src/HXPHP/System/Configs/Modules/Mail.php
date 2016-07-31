<?php

namespace HXPHP\System\Configs\Modules;

class Mail
{
	public $from;
	public $from_mail;

	public function __construct()
	{
		$this->setFrom([
			'from' => 'Sistema7Tech',
			'from_mail' => 'm.piske@hotmail.com.br'
		]);
		return $this;
	}

	public function setFrom(array $data)
	{
		$this->from = $data['from'];
		$this->from_mail = $data['from_mail'];

		return $this;
	}

	public function getFrom()
	{
		return [
			'from_mail' => $this->from_mail,
			'from_name' => $this->from
		];
	}
}