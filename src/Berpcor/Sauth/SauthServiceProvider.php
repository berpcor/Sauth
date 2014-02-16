<?php namespace Berpcor\Sauth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class SauthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	public function boot(){
		 $this->package('berpcor/sauth');
		 AliasLoader::getInstance()->alias('Sauth', 'Berpcor\Sauth\Sauth');
	}
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}