<?php namespace Berpcor\Sauth\Logic\Adapter;

interface AdapterInterface
{
    /**
     * Authenticate and return bool result of authentication
     *
     * @return bool
     */
    public function authenticate();
}