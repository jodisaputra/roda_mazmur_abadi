<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case GUEST = 'guest';
    case CUSTOMER = 'customer';
    case TENANT = 'tenant';

    /**
     * Get role display name
     */
    public function getLabel(): string
    {
        return match($this) {
            self::ADMIN => 'Administrator',
            self::GUEST => 'Guest User',
            self::CUSTOMER => 'Customer',
            self::TENANT => 'Tenant',
        };
    }
}
