# Teviant OMS

Teviant's Order Management System

## Setup

To setup, run the following:
`git clone git@bitbucket.org:boomtechco/teviant-oms.git`
`cd teviant-oms`
`composer install`
`cp env.example .env` (the edit the `.env` file accordingly)
`php artisan migrate`

## Branches

This repository tries to follow the semantic versioning specifications at [SemVer](https://semver.org/) and [Vincent Driessen's](http://nvie.com/posts/a-successful-git-branching-model/) git model with some minor additionals.

With SemVer, versioning is done like so
`<MAJOR>.<FEATURE>.PATCH` examples: `1.0.0`, `1.1.0` and `2.0.1`

With the git model, we add the prefixes: feature, staging, release, hotfix, the version, and suffix it the name of the feature just for brevity as follows:

* Master
* Features
	* feature/1.1.0-backpack-base
    * feature/1.2.0-backpack-crud
	* feature/1.3.0-backpack-permission-manager
	* feature/1.4.0-passport
	* feature/1.5.0-inventory
	* feature/1.5.1-metrics
	* feature/1.5.2-categories
	* feature/1.5.3-inventories
	* feature/1.5.31-custom-sku
	* feature/1.5.4-stocks
	* feature/1.5.5-suppliers
	* feature/1.5.6-stocks-movements
	* feature/1.6.0-orders
* Stagings
	* staging/1.0.0 
* Releases
	* release/1.0.0
* Hotfixes
	* hotfix/1.0.1-app-info

## Developer

[Boomtech.co](http://boomtech.co/)