<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Traits\HandlesImageUpload;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryStoreRequest;

class BlogCategoryController extends Controller
{
    use HandlesImageUpload;
    public function index(Request $request)
    {
        $meetings = [];
        return Inertia::render('Admin/BlogCategory/Index', [
            'filters'   => $request->only('search'),
            'meetings'   => $meetings,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/BlogCategory/Create');
    }

    public function store(BlogCategoryStoreRequest $request)

    {

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'blog_categories');
        }

        BlogCategory::create($data);

        return redirect()->back()->with('success', 'Category created successfully.');
    }
}
