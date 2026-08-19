<?php

namespace App\Models;
use App\Models\Role;
use App\Models\Department;
use App\Models\Outlet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'department_id',
        'outlet_id',
        'phone',
        'profile_photo',
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
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Role user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Department user.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Outlet user.
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * Inventaris yang dibuat user.
     */
    public function createdInventoryItems(): HasMany
    {
        return $this->hasMany(
            InventoryItem::class,
            'created_by'
        );
    }

    /**
     * Inventaris yang terakhir diubah user.
     */
    public function updatedInventoryItems(): HasMany
    {
        return $this->hasMany(
            InventoryItem::class,
            'updated_by'
        );
    }

    /**
     * History inventaris.
     */
    public function inventoryHistories(): HasMany
    {
        return $this->hasMany(InventoryHistory::class);
    }

    /**
     * Pengajuan yang dibuat user.
     */
    public function inventoryRequests(): HasMany
    {
        return $this->hasMany(
            InventoryRequest::class,
            'requester_id'
        );
    }

    /**
     * Pengajuan yang disetujui user.
     */
    public function approvedRequests(): HasMany
    {
        return $this->hasMany(
            InventoryRequest::class,
            'approved_by'
        );
    }

    /**
     * Aktivitas user.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Mutasi yang diminta user.
     */
    public function requestedMutations(): HasMany
    {
        return $this->hasMany(
            InventoryMutation::class,
            'requested_by'
        );
    }

    /**
     * Mutasi yang disetujui user.
     */
    public function approvedMutations(): HasMany
    {
        return $this->hasMany(
            InventoryMutation::class,
            'approved_by'
        );
    }

    /**
     * Maintenance yang dilaporkan user.
     */
    public function reportedMaintenances(): HasMany
    {
        return $this->hasMany(
            InventoryMaintenance::class,
            'reported_by'
        );
    }

    /**
     * Maintenance yang ditangani user.
     */
    public function assignedMaintenances(): HasMany
    {
        return $this->hasMany(
            InventoryMaintenance::class,
            'technician_id'
        );
    }

    /**
     * Peminjaman barang.
     */
    public function inventoryLoans(): HasMany
    {
        return $this->hasMany(
            InventoryLoan::class,
            'borrower_id'
        );
    }

    /**
     * Mengecek role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isHoAdmin(): bool
    {
        return $this->hasRole('ho_admin');
    }

    public function isOutletAdmin(): bool
    {
        return $this->hasRole('outlet_admin');
    }


}