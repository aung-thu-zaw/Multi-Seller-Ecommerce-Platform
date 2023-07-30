<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\SiteSettings;

use App\Actions\Admin\AdminWebControlArea\Settings\WebsiteSettings\UpdateWebsiteSettingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteSettingRequest;
use App\Models\WebsiteSetting;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;

class AdminWebsiteSettingController extends Controller
{
    public function edit(): Response|ResponseFactory
    {
        $websiteSetting=WebsiteSetting::findOrFail(1);

        return inertia("Admin/AdminWebControlArea/Settings/WebsiteSettings/Edit", compact("websiteSetting"));
    }

    public function update(WebsiteSettingRequest $request, WebsiteSetting $websiteSetting): RedirectResponse
    {
        (new UpdateWebsiteSettingAction())->handle($request->validated(), $websiteSetting);

        return back()->with("success", "Website Setting has been successfully updated.");
    }

}
