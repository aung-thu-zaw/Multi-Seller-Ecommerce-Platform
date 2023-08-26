<?php

namespace App\Services;

use App\Models\ProductBanner;
use App\Models\SellerProductBanner;
use App\Models\VendorProductBanner;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductBannerImageUploadService
{
    public function createImage(UploadedFile $image): string
    {
        $originalName = $image->getClientOriginalName();

        $finalName = time()."-".$originalName;

        $image->move(storage_path("app/public/product-banners/"), $finalName);

        return $finalName;
    }

    public function updateImage(UploadedFile $image, string $productBannerImage): string
    {
        if(is_string($productBannerImage)) {

            ProductBanner::deleteImage($productBannerImage);
        }

        $originalName = $image->getClientOriginalName();

        $finalName = time()."-".$originalName;

        $image->move(storage_path("app/public/product-banners/"), $finalName);

        return $finalName;
    }

}
