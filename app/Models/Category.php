<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use Searchable;
    use HasSlug;


    /**
    * @var string[]
    */
    protected array $cascadeDeletes = ['subCategories'];
    protected $guarded=[];


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }


    /**
    *     @return array<string>
    */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'status' => $this->status,
        ];
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Category, never>
    */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if ($value && str_starts_with($value, "http")) {
                    return $value;
                } elseif ($value) {
                    return asset("storage/categories/$value");
                } else {
                    return null;
                }
            },
            get:fn ($value) => $value ?? "https://media.istockphoto.com/id/1357365823/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg?s=612x612&w=0&k=20&c=PM_optEhHBTZkuJQLlCjLz-v3zzxp-1mpNQZsdjrbns="
        );
    }



    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Category, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<SubCategory>
    */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }


    public static function deleteImage(Category $category): void
    {
        if (!empty($category->image) && file_exists(storage_path("app/public/categories/".pathinfo($category->image, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/categories/".pathinfo($category->image, PATHINFO_BASENAME)));
        }
    }
}
