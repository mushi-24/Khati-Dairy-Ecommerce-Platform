<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User — central identity for all roles (customer, admin, manager, employee, shop_owner).
 *
 * Relationships:
 * - belongsTo Shop (shop_id) when linked to one shop
 * - hasMany Order as customer
 * - hasMany Shop as owner (owner_id on shops)
 * - hasOne Employee profile when role is employee
 * - hasMany ProductionRecord / Distribution as recorder
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_CUSTOMER = 'customer';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_EMPLOYEE = 'employee';
    public const ROLE_SHOP_OWNER = 'shop_owner';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'shop_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isManager(): bool
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function isShopOwner(): bool
    {
        return $this->role === self::ROLE_SHOP_OWNER;
    }

    public function isEmployee(): bool
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    public function canAccessAdminPanel(): bool
    {
        return in_array($this->role, [
            self::ROLE_ADMIN,
            self::ROLE_MANAGER,
            self::ROLE_EMPLOYEE,
            self::ROLE_SHOP_OWNER,
        ], true);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function ownedShops(): HasMany
    {
        return $this->hasMany(Shop::class, 'owner_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function employeeProfile(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function productionRecords(): HasMany
    {
        return $this->hasMany(ProductionRecord::class, 'recorded_by');
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(Distribution::class, 'recorded_by');
    }
}
