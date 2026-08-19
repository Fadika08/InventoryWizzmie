<?php

namespace App\Services;

use App\Models\InventoryItem;

class InventoryCodeGenerator
{
    public function generate(
        InventoryItem $inventory
    ): string {

        $categoryCode = strtoupper(
            $inventory->category?->code ?? 'GEN'
        );


        /*
        |--------------------------------------------------------------------------
        | Head Office
        |--------------------------------------------------------------------------
        */

        if ($inventory->location_type === 'head_office') {

            $departmentCode = strtoupper(
                $inventory->department?->code ?? 'GEN'
            );

            $departmentCode = preg_replace(
                '/[^A-Z0-9]/',
                '',
                $departmentCode
            );

            $categoryCode = preg_replace(
                '/[^A-Z0-9]/',
                '',
                $categoryCode
            );

            $prefix =
                "HO-{$departmentCode}-{$categoryCode}";
        }


        /*
        |--------------------------------------------------------------------------
        | Outlet
        |--------------------------------------------------------------------------
        */

        else {

            $outletCode = strtoupper(
                $inventory->outlet?->code ?? '001'
            );

            $outletCode = preg_replace(
                '/^OUT[-_]?/i',
                '',
                $outletCode
            );

            $outletCode = preg_replace(
                '/[^A-Z0-9]/',
                '',
                $outletCode
            );

            $categoryCode = preg_replace(
                '/[^A-Z0-9]/',
                '',
                $categoryCode
            );

            $prefix =
                "OUT-{$outletCode}-{$categoryCode}";
        }


        /*
        |--------------------------------------------------------------------------
        | Nomor berikutnya
        |--------------------------------------------------------------------------
        */

        $lastInventory = InventoryItem::query()
            ->withTrashed()
            ->where(
                'inventory_code',
                'like',
                $prefix . '-%'
            )
            ->orderByDesc('id')
            ->first();


        if (!$lastInventory) {

            $number = 1;

        } else {

            $lastCode =
                $lastInventory->inventory_code;

            $lastNumber = (int) substr(
                $lastCode,
                strrpos($lastCode, '-') + 1
            );

            $number = $lastNumber + 1;
        }


        /*
        |--------------------------------------------------------------------------
        | Final code
        |--------------------------------------------------------------------------
        */

        return sprintf(
            '%s-%06d',
            $prefix,
            $number
        );
    }
}