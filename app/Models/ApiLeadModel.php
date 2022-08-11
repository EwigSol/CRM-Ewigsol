<?php

/*
namespace App;

use App\Observers\LeadObserver;
use App\Scopes\CompanyScope;
use App\Traits\CustomFieldsTrait;
use Illuminate\Notifications\Notifiable;

*/

namespace Froiden\RestAPI\Models;

use Froiden\RestAPI\ApiModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ApiLeadModel extends ApiModel
{
	protected $table = "lead";
}