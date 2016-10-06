<?php

namespace UserBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle
{
	/**
	 * {@inheritdoc}
	 */
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}