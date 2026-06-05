<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class PageSeoController extends Controller
{
    public function index()
    {
        $pageSeos = PageSeo::orderBy('id', 'asc')->get();
        return view('backend.pageseo.index', compact('pageSeos'));
    }

    public function edit($id)
    {
        $pageSeo = PageSeo::findOrFail($id);
        return view('backend.pageseo.edit', compact('pageSeo'));
    }

    public function create()
    {
        return view('backend.pageseo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'route_name' => 'required|string|max:255',
            'page_slug' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // check uniqueness manually
        $exists = PageSeo::where('route_name', $request->route_name)
                         ->where('page_slug', $request->page_slug)
                         ->exists();
        
        if ($exists) {
            return back()->withErrors(['route_name' => 'SEO settings for this Route Name and Slug already exist.'])->withInput();
        }

        $data = $request->except(['og_image']);

        // Handle OG Image Upload
        if ($request->hasFile('og_image')) {
            $image = $request->file('og_image');
            $imageName = time() . '_og_' . uniqid() . '.' . $image->getClientOriginalExtension();
            // Ensure directory exists
            if (!file_exists(public_path('uploads/pages'))) {
                mkdir(public_path('uploads/pages'), 0777, true);
            }
            $image->move(public_path('uploads/pages'), $imageName);
            $data['og_image'] = $imageName;
        }

        PageSeo::create($data);

        return redirect()->route('admin.pageseo.index')->with('success', 'New Page SEO created successfully.');
    }
public function destroy($id)
{
    $pageSeo = PageSeo::findOrFail($id);
    
    // Delete OG image if exists
    if ($pageSeo->og_image && file_exists(public_path('uploads/pages/' . $pageSeo->og_image))) {
        unlink(public_path('uploads/pages/' . $pageSeo->og_image));
    }
    
    $pageSeo->delete();
    return redirect()->route('admin.pageseo.index')->with('success', 'Page SEO deleted successfully.');
}
    public function update(Request $request, $id)
    {
        $request->validate([
            'page_slug' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $pageSeo = PageSeo::findOrFail($id);
        
        $data = $request->except(['og_image']);

        // Handle OG Image Upload
        if ($request->hasFile('og_image')) {
            // Delete old image if exists
            if ($pageSeo->og_image && file_exists(base_path('../uploads/pages/' . $pageSeo->og_image))) {
                unlink(base_path('../uploads/pages/' . $pageSeo->og_image));
            }
            
            $image = $request->file('og_image');
            $imageName = time() . '_og_' . uniqid() . '.' . $image->getClientOriginalExtension();
            // Ensure directory exists
            if (!file_exists(public_path('uploads/pages'))) {
                mkdir(public_path('uploads/pages'), 0777, true);
            }
            $image->move(public_path('uploads/pages'), $imageName);
            $data['og_image'] = $imageName;
        }

        $pageSeo->update($data);

        return redirect()->route('admin.pageseo.index')->with('success', 'SEO settings updated successfully.');
    }
}
