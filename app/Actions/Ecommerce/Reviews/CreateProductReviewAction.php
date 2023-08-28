<?php

namespace App\Actions\Ecommerce\Reviews;

use App\Models\ProductReview;

class CreateProductReviewAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): ProductReview
    {
        $productReview = ProductReview::create([
            "product_id" => $data["product_id"],
            "shop_id" => $data["shop_id"],
            "user_id" => $data["user_id"],
            "review_text" => $data["review_text"],
            "status" => $data["status"],
            "rating" => $data["rating"],
        ]);

        return $productReview;
    }
}
