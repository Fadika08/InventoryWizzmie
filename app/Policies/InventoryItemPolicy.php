<?php

namespace App\Policies;

use App\Models\InventoryItem;
use App\Models\User;

class InventoryItemPolicy
{
    /**
     * Super Admin boleh melakukan semua tindakan.
     */
    public function before(
        User $user,
        string $ability
    ): ?bool {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Melihat inventaris.
     */
    public function view(
        User $user,
        InventoryItem $inventoryItem
    ): bool {
        if ($user->isHoAdmin()) {
            return $inventoryItem->location_type === 'head_office';
        }

        if ($user->isOutletAdmin()) {
            return (
                $inventoryItem->location_type === 'outlet'
                && $inventoryItem->outlet_id === $user->outlet_id
            );
        }

        return false;
    }

    /**
     * Membuat inventaris.
     */
    public function create(User $user): bool
    {
        return $user->isHoAdmin()
            || $user->isOutletAdmin();
    }

    /**
     * Update inventaris.
     */
    public function update(
        User $user,
        InventoryItem $inventoryItem
    ): bool {
        return $this->view(
            $user,
            $inventoryItem
        );
    }

    /**
     * Delete inventaris.
     */
    public function delete(
        User $user,
        InventoryItem $inventoryItem
    ): bool {
        return $this->view(
            $user,
            $inventoryItem
        );
    }
}
