<?php

namespace App\Actions\Admin\Coupons;

use App\Models\Coupon;

class CreateCouponAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): void
    {
        Coupon::create([
            'code' => $data['code'],
            'discount_type' => $data['discount_type'],
            'discount_amount' => $data['discount_amount'],
            'min_spend' => $data['min_spend'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'max_uses' => $data['max_uses'],
        ]);
    }
}
