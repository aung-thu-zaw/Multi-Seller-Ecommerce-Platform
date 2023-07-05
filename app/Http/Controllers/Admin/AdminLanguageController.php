<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminLanguageController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $languages=Language::search(request("search"))
                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                           ->paginate(request("per_page", 10))
                           ->appends(request()->all());

        return inertia("Admin/Languages/Index", compact("languages"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/Languages/Create", compact("per_page"));
    }

    public function store(LanguageRequest $request): RedirectResponse
    {
        Language::create($request->validated());

        $copyData=file_get_contents(resource_path("lang/en.json"));

        file_put_contents(resource_path('lang/'.$request->short_name.'.json'), $copyData);

        return to_route("admin.languages.index", "per_page=$request->per_page")->with("success", "Language has been successfully created.");
    }

    public function edit(Language $language): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Languages/Edit", compact("language", "paginate"));
    }

    public function update(LanguageRequest $request, Language $language): RedirectResponse
    {
        $language->update($request->validated());

        return to_route("admin.languages.index", "page=$request->page&per_page=$request->per_page")->with("success", "Language has been successfully updated.");
    }

    public function destroy(Request $request, Language $language): RedirectResponse
    {
        $language->delete();

        return to_route("admin.languages.index", "page=$request->page&per_page=$request->per_page")->with("success", "Language has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashLanguages=Language::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/Languages/Trash", compact("trashLanguages"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $language = Language::onlyTrashed()->findOrFail($id);

        $language->restore();

        return to_route('admin.languages.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Language has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $language = Language::onlyTrashed()->findOrFail($id);

        $language->forceDelete();

        return to_route('admin.languages.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The language has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $languages = Language::onlyTrashed()->get();

        $languages->each(function ($language) {

            $language->forceDelete();

        });

        return to_route('admin.languages.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Languages have been successfully deleted.");
    }
}
