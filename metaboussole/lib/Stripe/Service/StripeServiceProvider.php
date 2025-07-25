<?php

namespace Lib\Stripe\Service;

use Doctrine\ORM\EntityManager;
use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
	
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton(
			StripeService::class,
			function () {
				$clientSecret = config('services.stripe.secret') ?? env('STRIPE_SECRET');
				if (!$clientSecret) {
					throw new \RuntimeException('La clé Stripe (STRIPE_SECRET) est manquante dans .env ou config/services.php');
				}
				return new StripeService(
					$clientSecret,
					app()->get(EntityManager::class)
				);
			}
		);
	}
}
