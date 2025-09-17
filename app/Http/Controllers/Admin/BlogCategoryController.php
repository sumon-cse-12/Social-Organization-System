<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Traits\HandlesImageUpload;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryStoreRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;

class BlogCategoryController extends Controller
{
    use HandlesImageUpload;
    public function index(Request $request)
    {
        $blog_categories = BlogCategory::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(fn($member) => [
                'id' => $member->id,
                'name' => $member->name,
                'image' => $member->image,
                'is_active' => $member->is_active,
                'created_at' => $member->created_at->format('Y-m-d'),
            ]);

        return Inertia::render('Admin/BlogCategory/Index', [
            'blog_categories' => $blog_categories,
            'filters' => $request->only('search'),
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

    public function edit($id)
    {
        $blogCategory = BlogCategory::findOrFail($id);

        return Inertia::render('Admin/BlogCategory/Edit', [
            'blog_category' => [
                'id' => $blogCategory->id,
                'name' => $blogCategory->name,
                'slug' => $blogCategory->slug,
                'description' => $blogCategory->description,
                'image' => $blogCategory->image,
                'is_active' => (bool) $blogCategory->is_active,
            ]
        ]);
    }
    public function update(Request $request, $id)
    {
          $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $blogCategory = BlogCategory::findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'blog_categories', true, $blogCategory->image );
        }
        $validatedData['image'] = $imagePath;

        $blogCategory->update($validatedData);

        return redirect()->route('admin.blog.category.index')
            ->with('success', 'Blog Category updated successfully!');
    }
    public function destroy($id)
{
    $blogCategory = BlogCategory::findOrFail($id);

    // Delete image if exists
    if ($blogCategory->image && \Storage::disk('public')->exists($blogCategory->image)) {
        \Storage::disk('public')->delete($blogCategory->image);
    }

    $blogCategory->delete();

    return redirect()->route('admin.blog.category.index')
        ->with('success', 'Blog Category deleted successfully!');
}

}
