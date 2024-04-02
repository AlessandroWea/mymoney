<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;

class Permission extends Model
{
    static protected string $tableName = 'permissions';
    static public array $enabledCols = ['user1_id', 'user2_id', 'permission', 'active'];

    public array $errors = [];

    const int WALLET_PERMISSION = 1;
    const int INCOME_EXPENSIS_PERMISSION = 1;
    const int ANALYTICS_PERMISSION = 1;


}
