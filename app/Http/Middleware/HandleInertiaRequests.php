<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Support\Facades\Storage;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'recaptcha_site_key' => config('services.google_recaptcha.site_key'),
            'auth' => [
                'user' => $request->user(),
            ],
            'parentCategory'=>Category::with("children")->whereNull("parent_id")->get(),
            'vendors'=>User::where([["role","vendor"],["status","active"]])->limit(30)->get(),
            'flash'=>[
                'successMessage'=>session('success'),
                'errorMessage'=>session('error'),

            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
