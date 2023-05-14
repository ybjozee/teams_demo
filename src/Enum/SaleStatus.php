<?php

namespace App\Enum;

enum SaleStatus: string {

    case PENDING = 'PENDING';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';

    public static function isApproved(SaleStatus $status)
    : bool {

        return $status === SaleStatus::APPROVED;
    }

    public static function isCompleted(SaleStatus $status)
    : bool {

        return in_array($status, [SaleStatus::APPROVED, SaleStatus::REJECTED]);
    }
}
