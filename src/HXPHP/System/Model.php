<?php

namespace HXPHP\System;

class Model extends \ActiveRecord\Model
{
	public function __construct($attributes=[], $guard_attributes=TRUE, $instantiating_via_find=FALSE, $new_record=TRUE)
	{
		parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);

		return $this;
	}

}