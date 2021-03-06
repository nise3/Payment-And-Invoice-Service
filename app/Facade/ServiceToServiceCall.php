<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class AuthUser
 * @package App\Facade
 *
 * @method static array|mixed getAuthUserWithRolePermission(string $idpUserId)
 * @method static array|mixed getIndustryAssociationCode(int $industryAssociationId)
 * @method static array|mixed getIndustryAssociationData(int $industryAssociationId)
 * @method static array|mixed getYouthProfilesByIds(array $youthIds)
 * @method static array|mixed createTrainerYouthUser(array $trainer)
 * @method static array|mixed createTrainerCoreUser(array $trainer, array $youth)
 * @method static array|mixed rollbackTrainerYouthUser(array $youth)
 *
 * @see \App\Helpers\Classes\ServiceToServiceCallHandler
 */
class ServiceToServiceCall extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'service_to_service_call';
    }
}
