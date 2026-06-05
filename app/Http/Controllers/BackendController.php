<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Slider;
use App\Models\WhatWeDo;
use App\Models\OurService;
use App\Models\OurWorkProcess;
use App\Models\IndustryWeServe;
use App\Models\OurServiceMain;
use App\Models\IndustriesWeServeMain;
use App\Models\OurWorkProcessMain;
use App\Models\Menu;
use App\Models\Logo;
use App\Models\HomeContact;
use App\Models\FooterMain;
use App\Models\Offering;
use App\Models\CoreValueMain;
use App\Models\CoreValue;
use App\Models\ExperienceThePower;
use App\Models\Industry;
use App\Models\PrintingFaq;
use App\Models\ScanningFaq;
use App\Models\EngineeringFaq; 
use App\Models\RoutingFaq;
use App\Models\ThreeDScanning;
use App\Models\ThreeDPrinting;
use App\Models\PlasticFabrication;
use App\Models\RouterCutting;
use App\Models\Prototyping;
use App\Models\ReverseEngineering;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Contact;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\HomeCategory;
use App\Models\HomeProductSection;
use App\Models\HomeBrand;
use App\Models\HomeBrandSection;
use App\Models\HomeLogo;
use App\Models\FooterNew;
use App\Models\PrivacyPolicy;
use App\Models\TermsOfService;
use App\Models\HomeVideoSection;
use App\Models\AnnouncementBar;
use App\Models\Discount;
use App\Models\DiscountRule;
use App\Models\DiscountBxgy;
use App\Models\DiscountProduct;
use App\Models\DiscountUsage;
use App\Models\ShippingZone;
use App\Models\ShippingMethod;
use App\Models\ShippingRate;
use App\Models\ContactUs;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\GalleryMedia;


class BackendController extends Controller
{
// ============= MENU MANAGEMENT =============
// Replace lines 18 to approximately 450 in your BackendController.php

/**
 * Display all menus with hierarchical structure
 */


public function logo()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $logos = Logo::orderBy('created_at', 'desc')->get();
    $canAdd = Logo::count() < 1; // Only 1 logo allowed
    return view('backend.logo', compact('logos', 'canAdd'));
}

public function logoStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Check if already exists
    if (Logo::count() >= 1) {
        return redirect()->route('logo')->with('error', 'Only one logo is allowed!');
    }

    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_logo.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/logo'), $imageName);
        }

        Logo::create([
            'image' => $imageName,
        ]);

        return redirect()->route('logo')->with('success', 'Logo added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('logo')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function logoEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $logo = Logo::findOrFail($id);
    $logos = Logo::orderBy('created_at', 'desc')->get();
    $canAdd = true;
    
    return view('backend.logo', [
        'logos' => $logos,
        'editLogo' => $logo,
        'canAdd' => $canAdd
    ]);
}

public function logoUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
    ]);

    try {
        $logo = Logo::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($logo->image && file_exists(public_path('uploads/logo/' . $logo->image))) {
                unlink(public_path('uploads/logo/' . $logo->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_logo.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/logo'), $imageName);
            $logo->image = $imageName;
        }

        $logo->save();

        return redirect()->route('logo')->with('success', 'Logo updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('logo')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function logoDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $logo = Logo::findOrFail($id);
        
        // Delete image file
        if ($logo->image && file_exists(public_path('uploads/logo/' . $logo->image))) {
            unlink(public_path('uploads/logo/' . $logo->image));
        }
        
        $logo->delete();

        return redirect()->route('logo')->with('success', 'Logo deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('logo')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}


public function menuIndex()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    // Get all parent menus with their children (nested)
    $menus = Menu::with(['children' => function($query) {
                    $query->orderBy('order');
                }, 'children.children' => function($query) {
                    $query->orderBy('order');
                }])
                 ->whereNull('parent_id')
                 ->orderBy('order')
                 ->get();
    
    // Get parent menus for dropdown (exclude children temporarily)
    $parentMenus = Menu::with(['children' => function($query) {
                        $query->orderBy('order');
                    }])
                      ->whereNull('parent_id')
                      ->orderBy('order')
                      ->get();
    
    return view('backend.menu', compact('menus', 'parentMenus'));
}

/**
 * Show create menu form (if separate page needed)
 */
public function menuCreate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    // Get all parent menus for dropdown
    $parentMenus = Menu::with(['children' => function($query) {
                        $query->orderBy('order');
                    }])
                      ->whereNull('parent_id')
                      ->orderBy('order')
                      ->get();
    
    return view('backend.menus.create', compact('parentMenus'));
}

/**
 * Store new menu item
 */
public function menuStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Validation rules
    $request->validate([
        'title' => 'required|string|max:255',
        'url' => 'nullable|string|max:255',
        'parent_id' => 'nullable|exists:menus,id',
        'order' => 'required|integer|min:0',
        'icon' => 'nullable|string|max:100',
        'target' => 'nullable|in:_self,_blank',
    ], [
        'title.required' => 'Menu title is required',
        'title.max' => 'Menu title cannot exceed 255 characters',
        'order.required' => 'Display order is required',
        'order.integer' => 'Display order must be a number',
        'order.min' => 'Display order must be 0 or greater',
        'parent_id.exists' => 'Selected parent menu does not exist',
        'target.in' => 'Invalid link target selected'
    ]);

    try {
        // Check if parent_id is creating circular reference
        if ($request->parent_id) {
            $parent = Menu::find($request->parent_id);
            if ($parent && $parent->parent_id) {
                // This would create 3rd level - check if allowed
                // Uncomment below to limit to 2 levels only
                // return back()->with('error', 'Cannot create more than 2 levels of menus')->withInput();
            }
        }

        // Create menu
        $menu = Menu::create([
            'title' => $request->title,
            'url' => $request->url ?: '#',
            'parent_id' => $request->parent_id,
            'order' => $request->order,
            'icon' => $request->icon,
            'target' => $request->target ?? '_self',
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('backend.menu.index')
                       ->with('success', 'Menu "' . $menu->title . '" created successfully!');
                       
    } catch (\Exception $e) {
        return back()
            ->with('error', 'Error creating menu: ' . $e->getMessage())
            ->withInput();
    }
}

/**
 * Show edit menu form
 */
public function menuEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    // Find menu to edit
    $editMenu = Menu::findOrFail($id);
    
    // Get all menus for the table display
    $menus = Menu::with(['children' => function($query) {
                    $query->orderBy('order');
                }, 'children.children' => function($query) {
                    $query->orderBy('order');
                }])
                 ->whereNull('parent_id')
                 ->orderBy('order')
                 ->get();
    
    // Get parent menus for dropdown (exclude current menu and its descendants)
    $excludeIds = $this->getDescendantIds($id);
    $excludeIds[] = $id; // Also exclude current menu
    
    $parentMenus = Menu::with(['children' => function($query) use ($excludeIds) {
                        $query->whereNotIn('id', $excludeIds)->orderBy('order');
                    }])
                      ->whereNull('parent_id')
                      ->whereNotIn('id', $excludeIds)
                      ->orderBy('order')
                      ->get();
    
    return view('backend.menu', compact('menus', 'parentMenus', 'editMenu'));
}

/**
 * Update menu item
 */
public function menuUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Validation rules
    $request->validate([
        'title' => 'required|string|max:255',
        'url' => 'nullable|string|max:255',
        'parent_id' => 'nullable|exists:menus,id',
        'order' => 'required|integer|min:0',
        'icon' => 'nullable|string|max:100',
        'target' => 'nullable|in:_self,_blank',
    ], [
        'title.required' => 'Menu title is required',
        'order.required' => 'Display order is required',
        'parent_id.exists' => 'Selected parent menu does not exist',
    ]);

    try {
        $menu = Menu::findOrFail($id);
        
        // Prevent circular reference (menu cannot be parent of itself)
        if ($request->parent_id == $id) {
            return back()
                ->with('error', 'Menu cannot be its own parent!')
                ->withInput();
        }
        
        // Prevent setting a descendant as parent
        $descendantIds = $this->getDescendantIds($id);
        if ($request->parent_id && in_array($request->parent_id, $descendantIds)) {
            return back()
                ->with('error', 'Cannot set a submenu as parent of its parent menu!')
                ->withInput();
        }
        
        // Update menu
        $menu->update([
            'title' => $request->title,
            'url' => $request->url ?: '#',
            'parent_id' => $request->parent_id,
            'order' => $request->order,
            'icon' => $request->icon,
            'target' => $request->target ?? '_self',
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('backend.menu.index')
                       ->with('success', 'Menu "' . $menu->title . '" updated successfully!');
                       
    } catch (\Exception $e) {
        return back()
            ->with('error', 'Error updating menu: ' . $e->getMessage())
            ->withInput();
    }
}

/**
 * Delete menu item
 */
public function menuDestroy($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $menu = Menu::findOrFail($id);
        
        // Check if menu has children
        $childrenCount = $menu->children()->count();
        if ($childrenCount > 0) {
            return back()->with('error', 
                'Cannot delete "' . $menu->title . '" because it has ' . $childrenCount . ' submenu(s). Please delete or move the submenus first.'
            );
        }
        
        $menuTitle = $menu->title;
        $menu->delete();
        
        return redirect()->route('backend.menu.index')
                       ->with('success', 'Menu "' . $menuTitle . '" deleted successfully!');
                       
    } catch (\Exception $e) {
        return back()->with('error', 'Error deleting menu: ' . $e->getMessage());
    }
}

/**
 * Toggle menu active status
 */
public function menuToggleStatus($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $menu = Menu::findOrFail($id);
        
        // Toggle status
        $menu->is_active = !$menu->is_active;
        $menu->save();
        
        $status = $menu->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', 
            'Menu "' . $menu->title . '" ' . $status . ' successfully!'
        );
        
    } catch (\Exception $e) {
        return back()->with('error', 'Error toggling menu status: ' . $e->getMessage());
    }
}

/**
 * Get submenus by parent ID (AJAX endpoint)
 */
public function getSubMenus($parentId)
{
    if (!Session::has('user_id')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    try {
        $subMenus = Menu::where('parent_id', $parentId)
                       ->where('is_active', 1)
                       ->orderBy('order')
                       ->get(['id', 'title', 'url', 'icon', 'order']);
        
        return response()->json([
            'success' => true,
            'data' => $subMenus
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}

/**
 * Helper: Get all descendant IDs of a menu (recursive)
 */
private function getDescendantIds($menuId)
{
    $descendants = [];
    $children = Menu::where('parent_id', $menuId)->pluck('id')->toArray();
    
    foreach ($children as $childId) {
        $descendants[] = $childId;
        $descendants = array_merge($descendants, $this->getDescendantIds($childId));
    }
    
    return $descendants;
}
	
	
	
	
	
    public function dashboard()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        
        return view('backend.dashboard');
    }

    public function login()
    {
        if (Session::has('user_id')) {
            return redirect()->route('dashboard');
        }
        
        return view('backend.login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = DB::connection('mysql')->table('login')
            ->where('username', $username)
            ->first();

        if ($user && $password === $user->password) {
            Session::put('user_id', $user->id);
            Session::put('username', $user->username);
            
            if ($request->has('remember')) {
                cookie()->queue('remember_token', $user->username, 43200);
            }
            
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid username or password')->withInput();
    }









    // SLIDER MANAGEMENT - All in one page
    public function slider()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        
        $sliders = Slider::orderBy('created_at', 'desc')->get();
        return view('backend.slider', compact('sliders'));
    }





    public function sliderStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'slide_type'  => 'required|in:image,video',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'alt_tag'     => 'nullable|string|max:255',
        'video'       => 'nullable|mimes:mp4,webm,ogg|max:51200', // 50MB max
        'video_alt_tag' => 'nullable|string|max:255',
        'heading'     => 'nullable|string|max:255',
        'sub_heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'button_text' => 'nullable|string|max:255',
        'button_url'  => 'nullable|string|max:500',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/slider'), $imageName);
        }

        $videoName = null;
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            
            // Video folder create karo agar nahi hai
            $videoPath = public_path('uploads/slider/videos');
            if (!file_exists($videoPath)) {
                mkdir($videoPath, 0755, true);
            }
            $video->move($videoPath, $videoName);
        }

        Slider::create([
            'slide_type'  => $request->slide_type,
            'image'       => $imageName,
            'alt_tag'     => $request->alt_tag ?? '',
            'video'       => $videoName,
            'video_alt_tag' => $request->video_alt_tag ?? '',
            'sub_heading' => $request->sub_heading ?? '',
            'heading'     => $request->heading ?? '',
            'description' => $request->description ?? '',
            'button_text' => $request->button_text ?? '',
            'button_url'  => $request->button_url ?? '',
        ]);

        return redirect()->route('slider')->with('success', 'Slider added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('slider')->with('error', 'Failed to add slider: ' . $e->getMessage());
    }
}

    public function sliderEdit($id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        
        $slider = Slider::findOrFail($id);
        $sliders = Slider::orderBy('created_at', 'desc')->get();
        
        return view('backend.slider', [
            'sliders' => $sliders,
            'editSlider' => $slider
        ]);
    }

  public function sliderUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'slide_type'    => 'required|in:image,video',
        'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'alt_tag'       => 'nullable|string|max:255',
        'video'         => 'nullable|mimes:mp4,webm,ogg|max:51200',
        'video_alt_tag' => 'nullable|string|max:255',
        'heading'       => 'nullable|string|max:255',
        'sub_heading'   => 'nullable|string|max:255',
        'description'   => 'nullable|string',
        'button_text'   => 'nullable|string|max:255',
        'button_url'    => 'nullable|string|max:500',
    ]);

    try {
        $slider = Slider::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($slider->image && file_exists(public_path('uploads/slider/' . $slider->image))) {
                unlink(public_path('uploads/slider/' . $slider->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/slider'), $imageName);
            $slider->image = $imageName;
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            if ($slider->video && file_exists(public_path('uploads/slider/videos/' . $slider->video))) {
                unlink(public_path('uploads/slider/videos/' . $slider->video));
            }
            $video = $request->file('video');
            $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            $videoPath = public_path('uploads/slider/videos');
            if (!file_exists($videoPath)) mkdir($videoPath, 0755, true);
            $video->move($videoPath, $videoName);
            $slider->video = $videoName;
        }

        $slider->slide_type    = $request->slide_type;
        $slider->alt_tag       = $request->alt_tag ?? '';
        $slider->video_alt_tag = $request->video_alt_tag ?? '';
        $slider->sub_heading   = $request->sub_heading ?? '';
        $slider->heading       = $request->heading ?? '';
        $slider->description   = $request->description ?? '';
        $slider->button_text   = $request->button_text ?? '';
        $slider->button_url    = $request->button_url ?? '';
        $slider->save();

        return redirect()->route('slider')->with('success', 'Slider updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('slider')->with('error', 'Failed to update slider: ' . $e->getMessage());
    }
}

   public function sliderDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $slider = Slider::findOrFail($id);
        
        if ($slider->image && file_exists(public_path('uploads/slider/' . $slider->image))) {
            unlink(public_path('uploads/slider/' . $slider->image));
        }
        // Video bhi delete karo
        if ($slider->video && file_exists(public_path('uploads/slider/videos/' . $slider->video))) {
            unlink(public_path('uploads/slider/videos/' . $slider->video));
        }
        
        $slider->delete();
        return redirect()->route('slider')->with('success', 'Slider deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('slider')->with('error', 'Failed to delete slider: ' . $e->getMessage());
    }
}




// WHAT WE DO MANAGEMENT - All in one page
public function whatWeDo()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $whatWeDos = WhatWeDo::orderBy('created_at', 'desc')->get();
    return view('backend.what-we-do', compact('whatWeDos'));
}

public function whatWeDoCreate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    return view('backend.what-we-do-create');
}

public function whatWeDoStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'alt_tag' => 'nullable|string|max:255',
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'button_text' => 'nullable|string|max:255',
        'button_url' => 'nullable|string|max:500',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/whatwedo'), $imageName);
        }

        WhatWeDo::create([
            'image' => $imageName,
            'alt_tag' => $request->alt_tag,
            'heading' => $request->heading,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
        ]);

        return redirect()->route('whatwedo')->with('success', 'What We Do added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('whatwedo')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function whatWeDoEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $whatWeDo = WhatWeDo::findOrFail($id);
    $whatWeDos = WhatWeDo::orderBy('created_at', 'desc')->get();
    
    return view('backend.what-we-do', [
        'whatWeDos' => $whatWeDos,
        'editWhatWeDo' => $whatWeDo
    ]);
}

public function whatWeDoUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'alt_tag' => 'nullable|string|max:255',
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'button_text' => 'nullable|string|max:255',
        'button_url' => 'nullable|string|max:500',
    ]);

    try {
        $whatWeDo = WhatWeDo::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($whatWeDo->image && file_exists(public_path('uploads/whatwedo/' . $whatWeDo->image))) {
                unlink(public_path('uploads/whatwedo/' . $whatWeDo->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/whatwedo'), $imageName);
            $whatWeDo->image = $imageName;
        }

        $whatWeDo->alt_tag = $request->alt_tag;
        $whatWeDo->heading = $request->heading;
        $whatWeDo->description = $request->description;
        $whatWeDo->button_text = $request->button_text;
        $whatWeDo->button_url = $request->button_url;
        $whatWeDo->save();

        return redirect()->route('whatwedo')->with('success', 'What We Do updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('whatwedo')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function whatWeDoDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $whatWeDo = WhatWeDo::findOrFail($id);
        
        // Delete image file
        if ($whatWeDo->image && file_exists(public_path('uploads/whatwedo/' . $whatWeDo->image))) {
            unlink(public_path('uploads/whatwedo/' . $whatWeDo->image));
        }
        
        $whatWeDo->delete();

        return redirect()->route('whatwedo')->with('success', 'What We Do deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('whatwedo')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}













public function ourServiceMain()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $ourServices = OurServiceMain::orderBy('created_at', 'desc')->get();
    $canAdd = OurServiceMain::count() < 1; // Check if can add more
    return view('backend.ourservicemain', compact('ourServices', 'canAdd'));
}

public function ourServiceMainStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Check if already exists
    if (OurServiceMain::count() >= 1) {
        return redirect()->route('ourservicemain')->with('error', 'Only one service item is allowed!');
    }

    $request->validate([
        'heading1' => 'required|string|max:255',
        'image1' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image1')) {
            $image = $request->file('image1');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/ourservice'), $imageName);
        }

        OurServiceMain::create([
            'heading1' => $request->heading1,
            'image1' => $imageName,
        ]);

        return redirect()->route('ourservicemain')->with('success', 'Our Service added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('ourservicemain')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function ourServiceMainEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $ourService = OurServiceMain::findOrFail($id);
    $ourServices = OurServiceMain::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing
    
    return view('backend.ourservicemain', [
        'ourServices' => $ourServices,
        'editOurService' => $ourService,
        'canAdd' => $canAdd
    ]);
}

public function ourServiceMainUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading1' => 'required|string|max:255',
        'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $ourService = OurServiceMain::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image1')) {
            // Delete old image
            if ($ourService->image1 && file_exists(public_path('uploads/ourservice/' . $ourService->image1))) {
                unlink(public_path('uploads/ourservice/' . $ourService->image1));
            }
            
            $image = $request->file('image1');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/ourservice'), $imageName);
            $ourService->image1 = $imageName;
        }

        $ourService->heading1 = $request->heading1;
        $ourService->save();

        return redirect()->route('ourservicemain')->with('success', 'Our Service updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('ourservicemain')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function ourServiceMainDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $ourService = OurServiceMain::findOrFail($id);
        
        // Delete image file
        if ($ourService->image1 && file_exists(public_path('uploads/ourservice/' . $ourService->image1))) {
            unlink(public_path('uploads/ourservice/' . $ourService->image1));
        }
        
        $ourService->delete();

        return redirect()->route('ourservicemain')->with('success', 'Our Service deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('ourservicemain')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}
// OUR SERVICE MANAGEMENT - All in one page
public function ourService()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $ourServices = OurService::orderBy('created_at', 'desc')->get();
    return view('backend.ourservice', compact('ourServices'));
}

public function ourServiceCreate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    return view('backend.ourservice-create');
}

public function ourServiceStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'main_heading' => 'nullable|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'button_text' => 'nullable|string|max:255',
        'button_url' => 'nullable|string|max:500',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
        'meta_keywords' => 'nullable|string',
        'og_title' => 'nullable|string|max:255',
        'og_description' => 'nullable|string',
        'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Upload directly to root uploads folder (web-accessible location)
            $rootUploadPath = public_path('../uploads/ourservice');
            if (!file_exists($rootUploadPath)) {
                mkdir($rootUploadPath, 0755, true);
            }
            $image->move($rootUploadPath, $imageName);
        }

        $iconName = null;
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            
            // Upload directly to root uploads/icons folder
            $rootIconPath = public_path('../uploads/ourservice/icons');
            if (!file_exists($rootIconPath)) {
                mkdir($rootIconPath, 0755, true);
            }
            $icon->move($rootIconPath, $iconName);
        }

        $ogImageName = null;
        if ($request->hasFile('og_image')) {
            $ogImage = $request->file('og_image');
            $ogImageName = time() . '_og_' . uniqid() . '.' . $ogImage->getClientOriginalExtension();
            
            // Upload directly to root uploads/ourservice/og folder
            $rootOgPath = public_path('../uploads/ourservice/og');
            if (!file_exists($rootOgPath)) {
                mkdir($rootOgPath, 0755, true);
            }
            $ogImage->move($rootOgPath, $ogImageName);
        }

        OurService::create([
            'main_heading' => $request->main_heading,
            'image' => $imageName,
            'icon' => $iconName,
            'icon_class' => $request->icon_class,
            'heading' => $request->heading,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $ogImageName,
        ]);

        return redirect()->route('ourservice')->with('success', 'Our Service added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('ourservice')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function ourServiceEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $ourService = OurService::findOrFail($id);
    $ourServices = OurService::orderBy('created_at', 'desc')->get();
    
    return view('backend.ourservice', [
        'ourServices' => $ourServices,
        'editOurService' => $ourService
    ]);
}

public function ourServiceUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'main_heading' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'button_text' => 'nullable|string|max:255',
        'button_url' => 'nullable|string|max:500',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
        'meta_keywords' => 'nullable|string',
        'og_title' => 'nullable|string|max:255',
        'og_description' => 'nullable|string',
        'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $ourService = OurService::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image from both locations
            $rootUploadPath = public_path('../uploads/ourservice');
            if ($ourService->image && file_exists($rootUploadPath . '/' . $ourService->image)) {
                unlink($rootUploadPath . '/' . $ourService->image);
            }
            if ($ourService->image && file_exists(public_path('uploads/ourservice/' . $ourService->image))) {
                unlink(public_path('uploads/ourservice/' . $ourService->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Upload directly to root uploads folder
            if (!file_exists($rootUploadPath)) {
                mkdir($rootUploadPath, 0755, true);
            }
            $image->move($rootUploadPath, $imageName);
            $ourService->image = $imageName;
        }

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon from both locations
            $rootIconPath = public_path('../uploads/ourservice/icons');
            if ($ourService->icon && file_exists($rootIconPath . '/' . $ourService->icon)) {
                unlink($rootIconPath . '/' . $ourService->icon);
            }
            if ($ourService->icon && file_exists(public_path('uploads/ourservice/icons/' . $ourService->icon))) {
                unlink(public_path('uploads/ourservice/icons/' . $ourService->icon));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            
            // Upload directly to root uploads/icons folder
            if (!file_exists($rootIconPath)) {
                mkdir($rootIconPath, 0755, true);
            }
            $icon->move($rootIconPath, $iconName);
            $ourService->icon = $iconName;
        }
        
        // Handle OG Image upload
        if ($request->hasFile('og_image')) {
            $rootOgPath = public_path('../uploads/ourservice/og');
            if ($ourService->og_image && file_exists($rootOgPath . '/' . $ourService->og_image)) {
                unlink($rootOgPath . '/' . $ourService->og_image);
            }
            
            $ogImage = $request->file('og_image');
            $ogImageName = time() . '_og_' . uniqid() . '.' . $ogImage->getClientOriginalExtension();
            
            if (!file_exists($rootOgPath)) {
                mkdir($rootOgPath, 0755, true);
            }
            $ogImage->move($rootOgPath, $ogImageName);
            $ourService->og_image = $ogImageName;
        }

        $ourService->main_heading = $request->main_heading;
        $ourService->icon_class = $request->icon_class;
        $ourService->heading = $request->heading;
        $ourService->description = $request->description;
        $ourService->button_text = $request->button_text;
        $ourService->button_url = $request->button_url;
        
        $ourService->meta_title = $request->meta_title;
        $ourService->meta_description = $request->meta_description;
        $ourService->meta_keywords = $request->meta_keywords;
        $ourService->og_title = $request->og_title;
        $ourService->og_description = $request->og_description;
        
        $ourService->save();

        return redirect()->route('ourservice')->with('success', 'Our Service updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('ourservice')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function ourServiceDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $ourService = OurService::findOrFail($id);
        
        // Delete image file
        if ($ourService->image && file_exists(public_path('uploads/ourservice/' . $ourService->image))) {
            unlink(public_path('uploads/ourservice/' . $ourService->image));
        }
        
        // Delete icon file
        if ($ourService->icon && file_exists(public_path('uploads/ourservice/icons/' . $ourService->icon))) {
            unlink(public_path('uploads/ourservice/icons/' . $ourService->icon));
        }
        
        $ourService->delete();

        return redirect()->route('ourservice')->with('success', 'Our Service deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('ourservice')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}



public function ourWorkProcessMain()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $processes = OurWorkProcessMain::orderBy('created_at', 'desc')->get();
    $canAdd = OurWorkProcessMain::count() < 1; // Check if can add more
    return view('backend.ourworkprocessmain', compact('processes', 'canAdd'));
}

public function ourWorkProcessMainStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Check if already exists
    if (OurWorkProcessMain::count() >= 1) {
        return redirect()->route('ourworkprocessmain')->with('error', 'Only one work process item is allowed!');
    }

    $request->validate([
        'heading1' => 'required|string|max:255',
        'image1' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'button_text' => 'required|string|max:100',
        'button_url' => 'required|string|max:500',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image1')) {
            $image = $request->file('image1');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/workprocess'), $imageName);
        }

        OurWorkProcessMain::create([
            'heading1' => $request->heading1,
            'image1' => $imageName,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
        ]);

        return redirect()->route('ourworkprocessmain')->with('success', 'Work process added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('ourworkprocessmain')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function ourWorkProcessMainEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $process = OurWorkProcessMain::findOrFail($id);
    $processes = OurWorkProcessMain::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing (it will be used for update)
    
    return view('backend.ourworkprocessmain', [
        'processes' => $processes,
        'editProcess' => $process,
        'canAdd' => $canAdd
    ]);
}

public function ourWorkProcessMainUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading1' => 'required|string|max:255',
        'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'button_text' => 'required|string|max:100',
        'button_url' => 'required|string|max:500',
    ]);

    try {
        $process = OurWorkProcessMain::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image1')) {
            // Delete old image
            if ($process->image1 && file_exists(public_path('uploads/workprocess/' . $process->image1))) {
                unlink(public_path('uploads/workprocess/' . $process->image1));
            }
            
            $image = $request->file('image1');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/workprocess'), $imageName);
            $process->image1 = $imageName;
        }

        $process->heading1 = $request->heading1;
        $process->button_text = $request->button_text;
        $process->button_url = $request->button_url;
        $process->save();

        return redirect()->route('ourworkprocessmain')->with('success', 'Work process updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('ourworkprocessmain')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function ourWorkProcessMainDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $process = OurWorkProcessMain::findOrFail($id);
        
        // Delete image file
        if ($process->image1 && file_exists(public_path('uploads/workprocess/' . $process->image1))) {
            unlink(public_path('uploads/workprocess/' . $process->image1));
        }
        
        $process->delete();

        return redirect()->route('ourworkprocessmain')->with('success', 'Work process deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('ourworkprocessmain')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}
// OUR WORK PROCESS MANAGEMENT - All in one page
public function ourWorkProcess()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $ourWorkProcesses = OurWorkProcess::orderBy('created_at', 'desc')->get();
    return view('backend.our-work-process', compact('ourWorkProcesses'));
}

public function ourWorkProcessCreate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    return view('backend.our-work-process-create');
}

public function ourWorkProcessStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'heading' => 'required|string|max:255',
        'description' => 'nullable|string',
        'link_url' => 'nullable|string|max:500',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/our-work-process'), $imageName);
        }

        OurWorkProcess::create([
            'image' => $imageName,
            'heading' => $request->heading,
            'description' => $request->description,
            'link_url' => $request->link_url,
        ]);

        return redirect()->route('our-work-process')->with('success', 'Work Process added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('our-work-process')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function ourWorkProcessEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $ourWorkProcess = OurWorkProcess::findOrFail($id);
    $ourWorkProcesses = OurWorkProcess::orderBy('created_at', 'desc')->get();
    
    return view('backend.our-work-process', [
        'ourWorkProcesses' => $ourWorkProcesses,
        'editOurWorkProcess' => $ourWorkProcess
    ]);
}

public function ourWorkProcessUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'heading' => 'required|string|max:255',
        'description' => 'nullable|string',
        'link_url' => 'nullable|string|max:500',
    ]);

    try {
        $ourWorkProcess = OurWorkProcess::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($ourWorkProcess->image && file_exists(public_path('uploads/our-work-process/' . $ourWorkProcess->image))) {
                unlink(public_path('uploads/our-work-process/' . $ourWorkProcess->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/our-work-process'), $imageName);
            $ourWorkProcess->image = $imageName;
        }

        $ourWorkProcess->heading = $request->heading;
        $ourWorkProcess->description = $request->description;
        $ourWorkProcess->link_url = $request->link_url;
        $ourWorkProcess->save();

        return redirect()->route('our-work-process')->with('success', 'Work Process updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('our-work-process')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function ourWorkProcessDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $ourWorkProcess = OurWorkProcess::findOrFail($id);
        
        // Delete image file
        if ($ourWorkProcess->image && file_exists(public_path('uploads/our-work-process/' . $ourWorkProcess->image))) {
            unlink(public_path('uploads/our-work-process/' . $ourWorkProcess->image));
        }
        
        $ourWorkProcess->delete();

        return redirect()->route('our-work-process')->with('success', 'Work Process deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('our-work-process')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}





public function industriesWeServeMain()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $industries = IndustriesWeServeMain::orderBy('created_at', 'desc')->get();
    $canAdd = IndustriesWeServeMain::count() < 1; // Check if can add more
    return view('backend.industriesweservemain', compact('industries', 'canAdd'));
}

public function industriesWeServeMainStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Check if already exists
    if (IndustriesWeServeMain::count() >= 1) {
        return redirect()->route('industriesweservemain')->with('error', 'Only one industry item is allowed!');
    }

    $request->validate([
        'heading1' => 'required|string|max:255',
        'image1' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image1')) {
            $image = $request->file('image1');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/industries'), $imageName);
        }

        IndustriesWeServeMain::create([
            'heading1' => $request->heading1,
            'image1' => $imageName,
        ]);

        return redirect()->route('industriesweservemain')->with('success', 'Industry added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('industriesweservemain')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function industriesWeServeMainEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $industry = IndustriesWeServeMain::findOrFail($id);
    $industries = IndustriesWeServeMain::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing (it will be used for update)
    
    return view('backend.industriesweservemain', [
        'industries' => $industries,
        'editIndustry' => $industry,
        'canAdd' => $canAdd
    ]);
}

public function industriesWeServeMainUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading1' => 'required|string|max:255',
        'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $industry = IndustriesWeServeMain::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image1')) {
            // Delete old image
            if ($industry->image1 && file_exists(public_path('uploads/industries/' . $industry->image1))) {
                unlink(public_path('uploads/industries/' . $industry->image1));
            }
            
            $image = $request->file('image1');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/industries'), $imageName);
            $industry->image1 = $imageName;
        }

        $industry->heading1 = $request->heading1;
        $industry->save();

        return redirect()->route('industriesweservemain')->with('success', 'Industry updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('industriesweservemain')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function industriesWeServeMainDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $industry = IndustriesWeServeMain::findOrFail($id);
        
        // Delete image file
        if ($industry->image1 && file_exists(public_path('uploads/industries/' . $industry->image1))) {
            unlink(public_path('uploads/industries/' . $industry->image1));
        }
        
        $industry->delete();

        return redirect()->route('industriesweservemain')->with('success', 'Industry deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('industriesweservemain')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}
// INDUSTRIES WE SERVE MANAGEMENT - All in one page
public function industriesWeServe()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $industries = IndustryWeServe::orderBy('created_at', 'desc')->get();
    return view('backend.industries-we-serve', compact('industries'));
}

public function industriesWeServeCreate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    return view('backend.industries-we-serve-create');
}

public function industriesWeServeStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:1024',
        'icon_class' => 'nullable|string|max:255',
        'heading' => 'required|string|max:255',
        'description' => 'nullable|string',
        'link_url' => 'nullable|string|max:500',
    ]);

    try {
        if ($request->hasFile('image')) {
    $image = $request->file('image');
    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    
    $rootUploadPath = public_path('uploads/industries');  // fix
    if (!file_exists($rootUploadPath)) {
        mkdir($rootUploadPath, 0755, true);
    }
    $image->move($rootUploadPath, $imageName);
}

        $iconName = null;
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            
            // Upload directly to root uploads/industries/icons folder
            $rootIconPath = public_path('../uploads/industries/icons');
            if (!file_exists($rootIconPath)) {
                mkdir($rootIconPath, 0755, true);
            }
            $icon->move($rootIconPath, $iconName);
        }

        IndustryWeServe::create([
    'image' => $imageName,
    'icon' => $iconName,
    'icon_class' => $request->icon_class ?? '',
    'heading' => $request->heading,
    'description' => $request->description ?? '',
    'link_url' => $request->link_url ?? '',
]);

        return redirect()->route('industries-we-serve')->with('success', 'Industry added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('industries-we-serve')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function industriesWeServeEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $industry = IndustryWeServe::findOrFail($id);
    $industries = IndustryWeServe::orderBy('created_at', 'desc')->get();
    
    return view('backend.industries-we-serve', [
        'industries' => $industries,
        'editIndustry' => $industry
    ]);
}

public function industriesWeServeUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'heading' => 'required|string|max:255',
        'description' => 'nullable|string',
        'link_url' => 'nullable|string|max:500',
    ]);

    try {
        $industry = IndustryWeServe::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image from both locations
            $rootUploadPath  = public_path('uploads/industries');
            if ($industry->image && file_exists($rootUploadPath . '/' . $industry->image)) {
                unlink($rootUploadPath . '/' . $industry->image);
            }
            if ($industry->image && file_exists(public_path('uploads/industries/' . $industry->image))) {
                unlink(public_path('uploads/industries/' . $industry->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Upload directly to root uploads folder
            if (!file_exists($rootUploadPath)) {
                mkdir($rootUploadPath, 0755, true);
            }
            $image->move($rootUploadPath, $imageName);
            $industry->image = $imageName;
        }

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon from both locations
            $rootIconPath = public_path('../uploads/industries/icons');
            if ($industry->icon && file_exists($rootIconPath . '/' . $industry->icon)) {
                unlink($rootIconPath . '/' . $industry->icon);
            }
            if ($industry->icon && file_exists(public_path('uploads/industries/icons/' . $industry->icon))) {
                unlink(public_path('uploads/industries/icons/' . $industry->icon));
            }
            
            $icon = $request->file('icon');
            $iconName = time() . '_icon_' . uniqid() . '.' . $icon->getClientOriginalExtension();
            
            // Upload directly to root uploads folder
            if (!file_exists($rootIconPath)) {
                mkdir($rootIconPath, 0755, true);
            }
            $icon->move($rootIconPath, $iconName);
            $industry->icon = $iconName;
        }

        $industry->heading = $request->heading ?? '';
$industry->icon_class = $request->icon_class ?? '';
$industry->description = $request->description ?? '';
$industry->link_url = $request->link_url ?? '';
$industry->save();

        return redirect()->route('industries-we-serve')->with('success', 'Industry updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('industries-we-serve')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function industriesWeServeDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $industry = IndustryWeServe::findOrFail($id);
        
        // Delete image file
        if ($industry->image && file_exists(public_path('uploads/industries/' . $industry->image))) {
            unlink(public_path('uploads/industries/' . $industry->image));
        }
        
        $industry->delete();

        return redirect()->route('industries-we-serve')->with('success', 'Industry deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('industries-we-serve')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}

public function homeContact()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $homeContacts = HomeContact::orderBy('created_at', 'desc')->get();
    $canAdd = HomeContact::count() < 1; // Check if can add more
    return view('backend.homecontact', compact('homeContacts', 'canAdd'));
}

public function homeContactStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Check if already exists
    if (HomeContact::count() >= 1) {
        return redirect()->route('homecontact')->with('error', 'Only one item is allowed!');
    }

    $request->validate([
        'heading' => 'required|string|max:255',
        'description' => 'required|string',
        'phone' => 'nullable|string|max:50',
        'email' => 'nullable|email|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/homecontact'), $imageName);
        }

        HomeContact::create([
            'heading' => $request->heading,
            'description' => $request->description,
            'phone' => $request->phone,
            'email' => $request->email,
            'image' => $imageName,
        ]);

        return redirect()->route('homecontact')->with('success', 'Home Contact added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('homecontact')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function homeContactEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $homeContact = HomeContact::findOrFail($id);
    $homeContacts = HomeContact::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing
    
    return view('backend.homecontact', [
        'homeContacts' => $homeContacts,
        'editHomeContact' => $homeContact,
        'canAdd' => $canAdd
    ]);
}

public function homeContactUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'required|string|max:255',
        'description' => 'required|string',
        'phone' => 'nullable|string|max:50',
        'email' => 'nullable|email|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $homeContact = HomeContact::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($homeContact->image && file_exists(public_path('uploads/homecontact/' . $homeContact->image))) {
                unlink(public_path('uploads/homecontact/' . $homeContact->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/homecontact'), $imageName);
            $homeContact->image = $imageName;
        }

        $homeContact->heading = $request->heading;
        $homeContact->description = $request->description;
        $homeContact->phone = $request->phone;
        $homeContact->email = $request->email;
        $homeContact->save();

        return redirect()->route('homecontact')->with('success', 'Home Contact updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('homecontact')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function homeContactDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $homeContact = HomeContact::findOrFail($id);
        
        // Delete image file
        if ($homeContact->image && file_exists(public_path('uploads/homecontact/' . $homeContact->image))) {
            unlink(public_path('uploads/homecontact/' . $homeContact->image));
        }
        
        $homeContact->delete();

        return redirect()->route('homecontact')->with('success', 'Home Contact deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('homecontact')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}

// Contact Submissions Methods
public function contactSubmissions(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $query = Contact::orderBy('created_at', 'desc');

    if ($request->filled('date_from')) {
        $query->whereRaw('DATE(created_at) >= ?', [$request->date_from]);
    }

    if ($request->filled('date_to')) {
        $query->whereRaw('DATE(created_at) <= ?', [$request->date_to]);
    }

    dd([
        'date_from' => $request->date_from,
        'date_to'   => $request->date_to,
        'sql'       => $query->toSql(),
        'bindings'  => $query->getBindings(),
        'count'     => $query->count(),
        'sample'    => Contact::first()?->getRawOriginal('created_at'),
    ]);

    $contacts = $query->paginate(20)->withQueryString();
    return view('backend.contact-submissions', compact('contacts'));
}

public function contactSubmissionView($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $contact = Contact::findOrFail($id);
    return view('backend.contact-submission-view', compact('contact'));
}

public function contactSubmissionDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contact.submissions')->with('success', 'Contact submission deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('contact.submissions')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}


// FooterMain Methods - Add these to your BackendController.php

// Don't forget to import the model at the top of your controller:
// use App\Models\FooterMain;

public function footerMain()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $footers = FooterMain::orderBy('created_at', 'desc')->get();
    $canAdd = FooterMain::count() < 1;
    return view('backend.footermain', compact('footers', 'canAdd'));
}

public function footerMainStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Check if already exists
    if (FooterMain::count() >= 1) {
        return redirect()->route('footermain')->with('error', 'Only one footer item is allowed!');
    }

    $request->validate([
        'location1_icon' => 'required|string|max:100',
        'location1_text' => 'required|string|max:500',
        'location2_icon' => 'required|string|max:100',
        'location2_text' => 'required|string|max:500',
        'copyright_year' => 'required|string|max:4',
        'copyright_text' => 'required|string|max:100',
        'powered_by_text' => 'required|string|max:100',
        'powered_by_link' => 'required|url|max:255',
    ], [
        'location1_icon.required' => 'Location 1 icon is required',
        'location1_text.required' => 'Location 1 address is required',
        'location2_icon.required' => 'Location 2 icon is required',
        'location2_text.required' => 'Location 2 address is required',
        'copyright_year.required' => 'Copyright year is required',
        'copyright_text.required' => 'Copyright text is required',
        'powered_by_text.required' => 'Powered by text is required',
        'powered_by_link.required' => 'Powered by link is required',
    ]);

    try {
        FooterMain::create([
            'location1_icon' => $request->location1_icon,
            'location1_text' => $request->location1_text,
            'location2_icon' => $request->location2_icon,
            'location2_text' => $request->location2_text,
            'copyright_year' => $request->copyright_year,
            'copyright_text' => $request->copyright_text,
            'powered_by_text' => $request->powered_by_text,
            'powered_by_link' => $request->powered_by_link,
        ]);

        return redirect()->route('footermain')->with('success', 'Footer locations added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('footermain')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function footerMainEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $footer = FooterMain::findOrFail($id);
    $footers = FooterMain::orderBy('created_at', 'desc')->get();
    $canAdd = true;
    
    return view('backend.footermain', [
        'footers' => $footers,
        'editFooter' => $footer,
        'canAdd' => $canAdd
    ]);
}

public function footerMainUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'location1_icon' => 'required|string|max:100',
        'location1_text' => 'required|string|max:500',
        'location2_icon' => 'required|string|max:100',
        'location2_text' => 'required|string|max:500',
        'copyright_year' => 'required|string|max:4',
        'copyright_text' => 'required|string|max:100',
        'powered_by_text' => 'required|string|max:100',
        'powered_by_link' => 'required|url|max:255',
    ]);

    try {
        $footer = FooterMain::findOrFail($id);

        $footer->location1_icon = $request->location1_icon;
        $footer->location1_text = $request->location1_text;
        $footer->location2_icon = $request->location2_icon;
        $footer->location2_text = $request->location2_text;
        $footer->copyright_year = $request->copyright_year;
        $footer->copyright_text = $request->copyright_text;
        $footer->powered_by_text = $request->powered_by_text;
        $footer->powered_by_link = $request->powered_by_link;
        $footer->save();

        return redirect()->route('footermain')->with('success', 'Footer locations updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('footermain')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function footerMainDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $footer = FooterMain::findOrFail($id);
        $footer->delete();

        return redirect()->route('footermain')->with('success', 'Footer deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('footermain')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}





//About use

// OFFERING MANAGEMENT - All in one page
// OFFERING MANAGEMENT - All in one page
public function offering()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $offerings = Offering::orderBy('created_at', 'desc')->get();
    $offeringCount = Offering::count();
    return view('backend.offering', compact('offerings', 'offeringCount'));
}

public function offeringStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Check if already exists
    if (Offering::count() >= 1) {
        return redirect()->route('offering')->with('error', 'Only one offering can be added. Please delete the existing one first.');
    }

    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
        'alt_tag' => 'nullable|string|max:255',
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/offering'), $imageName);
        }

        Offering::create([
            'image' => $imageName,
            'alt_tag' => $request->alt_tag,
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()->route('offering')->with('success', 'Offering added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('offering')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function offeringEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $offering = Offering::findOrFail($id);
    $offerings = Offering::orderBy('created_at', 'desc')->get();
    $offeringCount = Offering::count();
    
    return view('backend.offering', [
        'offerings' => $offerings,
        'editOffering' => $offering,
        'offeringCount' => $offeringCount
    ]);
}

public function offeringUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        'alt_tag' => 'nullable|string|max:255',
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        $offering = Offering::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($offering->image && file_exists(public_path('uploads/offering/' . $offering->image))) {
                unlink(public_path('uploads/offering/' . $offering->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/offering'), $imageName);
            $offering->image = $imageName;
        }

        $offering->alt_tag = $request->alt_tag;
        $offering->heading = $request->heading;
        $offering->description = $request->description;
        $offering->save();

        return redirect()->route('offering')->with('success', 'Offering updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('offering')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function offeringDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $offering = Offering::findOrFail($id);
        
        // Delete image file
        if ($offering->image && file_exists(public_path('uploads/offering/' . $offering->image))) {
            unlink(public_path('uploads/offering/' . $offering->image));
        }
        
        $offering->delete();

        return redirect()->route('offering')->with('success', 'Offering deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('offering')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}



// CORE VALUES MANAGEMENT - All in one page
public function coreValues()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $coreValues = CoreValue::orderBy('created_at', 'desc')->get();
    return view('backend.corevalues', compact('coreValues'));
}

public function coreValuesCreate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    return view('backend.corevalues-create');
}

public function coreValuesStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
        'heading' => 'required|string|max:255',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/corevalues'), $imageName);
        }

        CoreValue::create([
            'image' => $imageName,
            'heading' => $request->heading,
        ]);

        return redirect()->route('corevalues')->with('success', 'Core Value added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('corevalues')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function coreValuesEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $coreValue = CoreValue::findOrFail($id);
    $coreValues = CoreValue::orderBy('created_at', 'desc')->get();
    
    return view('backend.corevalues', [
        'coreValues' => $coreValues,
        'editCoreValue' => $coreValue
    ]);
}

public function coreValuesUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'heading' => 'required|string|max:255',
    ]);

    try {
        $coreValue = CoreValue::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($coreValue->image && file_exists(public_path('uploads/corevalues/' . $coreValue->image))) {
                unlink(public_path('uploads/corevalues/' . $coreValue->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/corevalues'), $imageName);
            $coreValue->image = $imageName;
        }

        $coreValue->heading = $request->heading;
        $coreValue->save();

        return redirect()->route('corevalues')->with('success', 'Core Value updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('corevalues')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function coreValuesDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $coreValue = CoreValue::findOrFail($id);
        
        // Delete image file
        if ($coreValue->image && file_exists(public_path('uploads/corevalues/' . $coreValue->image))) {
            unlink(public_path('uploads/corevalues/' . $coreValue->image));
        }
        
        $coreValue->delete();

        return redirect()->route('corevalues')->with('success', 'Core Value deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('corevalues')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}

// CORE VALUES MAIN MANAGEMENT - Only 1 item allowed
public function coreValuesMain()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $coreValuesMain = CoreValueMain::orderBy('created_at', 'desc')->get();
    $canAdd = CoreValueMain::count() < 1; // Check if can add more
    return view('backend.corevaluesmain', compact('coreValuesMain', 'canAdd'));
}

public function coreValuesMainStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Check if already exists
    if (CoreValueMain::count() >= 1) {
        return redirect()->route('corevaluesmain')->with('error', 'Only one core value main item is allowed!');
    }

    $request->validate([
        'heading1' => 'required|string|max:255',
        'image1' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image1')) {
            $image = $request->file('image1');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/corevalues'), $imageName);
        }

        CoreValueMain::create([
            'heading1' => $request->heading1,
            'image1' => $imageName,
        ]);

        return redirect()->route('corevaluesmain')->with('success', 'Core Values Main added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('corevaluesmain')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function coreValuesMainEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $coreValueMain = CoreValueMain::findOrFail($id);
    $coreValuesMain = CoreValueMain::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing
    
    return view('backend.corevaluesmain', [
        'coreValuesMain' => $coreValuesMain,
        'editCoreValueMain' => $coreValueMain,
        'canAdd' => $canAdd
    ]);
}

public function coreValuesMainUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading1' => 'required|string|max:255',
        'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $coreValueMain = CoreValueMain::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image1')) {
            // Delete old image
            if ($coreValueMain->image1 && file_exists(public_path('uploads/corevalues/' . $coreValueMain->image1))) {
                unlink(public_path('uploads/corevalues/' . $coreValueMain->image1));
            }
            
            $image = $request->file('image1');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/corevalues'), $imageName);
            $coreValueMain->image1 = $imageName;
        }

        $coreValueMain->heading1 = $request->heading1;
        $coreValueMain->save();

        return redirect()->route('corevaluesmain')->with('success', 'Core Values Main updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('corevaluesmain')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function coreValuesMainDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $coreValueMain = CoreValueMain::findOrFail($id);
        
        // Delete image file
        if ($coreValueMain->image1 && file_exists(public_path('uploads/corevalues/' . $coreValueMain->image1))) {
            unlink(public_path('uploads/corevalues/' . $coreValueMain->image1));
        }
        
        $coreValueMain->delete();

        return redirect()->route('corevaluesmain')->with('success', 'Core Values Main deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('corevaluesmain')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}



  public function experienceThePower()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        
        $experiences = ExperienceThePower::orderBy('created_at', 'desc')->get();
        $experienceCount = ExperienceThePower::count();
        return view('backend.experience-the-power', compact('experiences', 'experienceCount'));
    }

    public function experienceThePowerStore(Request $request)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Check if already exists
        if (ExperienceThePower::count() >= 1) {
            return redirect()->route('experience.the.power')->with('error', 'Only one item can be added. Please delete the existing one first.');
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'alt_tag' => 'nullable|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'heading' => 'nullable|string|max:255',
            'tab' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $imageName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/experience-the-power'), $imageName);
            }

            ExperienceThePower::create([
                'image' => $imageName,
                'alt_tag' => $request->alt_tag,
                'sub_heading' => $request->sub_heading,
                'heading' => $request->heading,
                'tab' => $request->tab,
                'description' => $request->description,
            ]);

            return redirect()->route('experience.the.power')->with('success', 'Experience The Power added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('experience.the.power')->with('error', 'Failed to add: ' . $e->getMessage());
        }
    }

    public function experienceThePowerEdit($id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        
        $experience = ExperienceThePower::findOrFail($id);
        $experiences = ExperienceThePower::orderBy('created_at', 'desc')->get();
        $experienceCount = ExperienceThePower::count();
        
        return view('backend.experience-the-power', [
            'experiences' => $experiences,
            'editExperience' => $experience,
            'experienceCount' => $experienceCount
        ]);
    }

    public function experienceThePowerUpdate(Request $request, $id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'alt_tag' => 'nullable|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'heading' => 'nullable|string|max:255',
            'tab' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $experience = ExperienceThePower::findOrFail($id);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($experience->image && file_exists(public_path('uploads/experience-the-power/' . $experience->image))) {
                    unlink(public_path('uploads/experience-the-power/' . $experience->image));
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/experience-the-power'), $imageName);
                $experience->image = $imageName;
            }

            $experience->alt_tag = $request->alt_tag;
            $experience->sub_heading = $request->sub_heading;
            $experience->heading = $request->heading;
            $experience->tab = $request->tab;
            $experience->description = $request->description;
            $experience->save();

            return redirect()->route('experience.the.power')->with('success', 'Experience The Power updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('experience.the.power')->with('error', 'Failed to update: ' . $e->getMessage());
        }
    }

    public function experienceThePowerDelete($id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        try {
            $experience = ExperienceThePower::findOrFail($id);
            
            // Delete image file
            if ($experience->image && file_exists(public_path('uploads/experience-the-power/' . $experience->image))) {
                unlink(public_path('uploads/experience-the-power/' . $experience->image));
            }
            
            $experience->delete();

            return redirect()->route('experience.the.power')->with('success', 'Experience The Power deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('experience.the.power')->with('error', 'Failed to delete: ' . $e->getMessage());
        }
    }


public function industry()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $industries = Industry::orderBy('created_at', 'desc')->get();
    return view('backend.industry', compact('industries'));
}

public function industryStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'alt_tag' => 'nullable|string|max:255',
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'layout' => 'required|in:left,right',
    ]);

    try {
        $bgImageName = null;
        if ($request->hasFile('background_image')) {
            $bgImage = $request->file('background_image');
            $bgImageName = 'bg_' . time() . '_' . uniqid() . '.' . $bgImage->getClientOriginalExtension();
            $bgImage->move(public_path('uploads/industry'), $bgImageName);
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/industry'), $imageName);
        }

        Industry::create([
            'background_image' => $bgImageName,
            'image' => $imageName,
            'alt_tag' => $request->alt_tag,
            'heading' => $request->heading,
            'description' => $request->description,
            'layout' => $request->layout,
        ]);

        return redirect()->route('industry')->with('success', 'Industry added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('industry')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function industryEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $industry = Industry::findOrFail($id);
    $industries = Industry::orderBy('created_at', 'desc')->get();
    
    return view('backend.industry', [
        'industries' => $industries,
        'editIndustry' => $industry
    ]);
}

public function industryUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'alt_tag' => 'nullable|string|max:255',
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'layout' => 'required|in:left,right',
    ]);

    try {
        $industry = Industry::findOrFail($id);

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            if ($industry->background_image && file_exists(public_path('uploads/industry/' . $industry->background_image))) {
                unlink(public_path('uploads/industry/' . $industry->background_image));
            }
            
            $bgImage = $request->file('background_image');
            $bgImageName = 'bg_' . time() . '_' . uniqid() . '.' . $bgImage->getClientOriginalExtension();
            $bgImage->move(public_path('uploads/industry'), $bgImageName);
            $industry->background_image = $bgImageName;
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            if ($industry->image && file_exists(public_path('uploads/industry/' . $industry->image))) {
                unlink(public_path('uploads/industry/' . $industry->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/industry'), $imageName);
            $industry->image = $imageName;
        }

        $industry->alt_tag = $request->alt_tag;
        $industry->heading = $request->heading;
        $industry->description = $request->description;
        $industry->layout = $request->layout;
        $industry->save();

        return redirect()->route('industry')->with('success', 'Industry updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('industry')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function industryDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $industry = Industry::findOrFail($id);
        
        // Delete background image file
        if ($industry->background_image && file_exists(public_path('uploads/industry/' . $industry->background_image))) {
            unlink(public_path('uploads/industry/' . $industry->background_image));
        }
        
        // Delete main image file
        if ($industry->image && file_exists(public_path('uploads/industry/' . $industry->image))) {
            unlink(public_path('uploads/industry/' . $industry->image));
        }
        
        $industry->delete();

        return redirect()->route('industry')->with('success', 'Industry deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('industry')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}



public function printingFaq()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $printingFaqs = PrintingFaq::orderBy('created_at', 'desc')->get();
    $printingFaqCount = PrintingFaq::count();
    return view('backend.printing-faq', compact('printingFaqs', 'printingFaqCount'));
}

public function printingFaqStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        PrintingFaq::create([
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()->route('printing-faq')->with('success', 'Printing FAQ added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('printing-faq')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function printingFaqEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $printingFaq = PrintingFaq::findOrFail($id);
    $printingFaqs = PrintingFaq::orderBy('created_at', 'desc')->get();
    $printingFaqCount = PrintingFaq::count();
    
    return view('backend.printing-faq', [
        'printingFaqs' => $printingFaqs,
        'editPrintingFaq' => $printingFaq,
        'printingFaqCount' => $printingFaqCount
    ]);
}

public function printingFaqUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        $printingFaq = PrintingFaq::findOrFail($id);

        $printingFaq->heading = $request->heading;
        $printingFaq->description = $request->description;
        $printingFaq->save();

        return redirect()->route('printing-faq')->with('success', 'Printing FAQ updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('printing-faq')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function printingFaqDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $printingFaq = PrintingFaq::findOrFail($id);
        $printingFaq->delete();

        return redirect()->route('printing-faq')->with('success', 'Printing FAQ deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('printing-faq')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}
public function scanningFaq()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $scanningFaqs = ScanningFaq::orderBy('created_at', 'desc')->get();
    $scanningFaqCount = ScanningFaq::count();
    return view('backend.scanning-faq', compact('scanningFaqs', 'scanningFaqCount'));
}

public function scanningFaqStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        ScanningFaq::create([
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()->route('scanning-faq')->with('success', 'Scanning FAQ added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('scanning-faq')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function scanningFaqEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $scanningFaq = ScanningFaq::findOrFail($id);
    $scanningFaqs = ScanningFaq::orderBy('created_at', 'desc')->get();
    $scanningFaqCount = ScanningFaq::count();
    
    return view('backend.scanning-faq', [
        'scanningFaqs' => $scanningFaqs,
        'editScanningFaq' => $scanningFaq,
        'scanningFaqCount' => $scanningFaqCount
    ]);
}

public function scanningFaqUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        $scanningFaq = ScanningFaq::findOrFail($id);
        $scanningFaq->heading = $request->heading;
        $scanningFaq->description = $request->description;
        $scanningFaq->save();

        return redirect()->route('scanning-faq')->with('success', 'Scanning FAQ updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('scanning-faq')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function scanningFaqDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $scanningFaq = ScanningFaq::findOrFail($id);
        $scanningFaq->delete();

        return redirect()->route('scanning-faq')->with('success', 'Scanning FAQ deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('scanning-faq')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}

// ============================================
// ENGINEERING FAQ METHODS
// ============================================

public function engineeringFaq()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $engineeringFaqs = EngineeringFaq::orderBy('created_at', 'desc')->get();
    $engineeringFaqCount = EngineeringFaq::count();
    return view('backend.engineering-faq', compact('engineeringFaqs', 'engineeringFaqCount'));
}

public function engineeringFaqStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        EngineeringFaq::create([
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()->route('engineering-faq')->with('success', 'Engineering FAQ added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('engineering-faq')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function engineeringFaqEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $engineeringFaq = EngineeringFaq::findOrFail($id);
    $engineeringFaqs = EngineeringFaq::orderBy('created_at', 'desc')->get();
    $engineeringFaqCount = EngineeringFaq::count();
    
    return view('backend.engineering-faq', [
        'engineeringFaqs' => $engineeringFaqs,
        'editEngineeringFaq' => $engineeringFaq,
        'engineeringFaqCount' => $engineeringFaqCount
    ]);
}

public function engineeringFaqUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        $engineeringFaq = EngineeringFaq::findOrFail($id);
        $engineeringFaq->heading = $request->heading;
        $engineeringFaq->description = $request->description;
        $engineeringFaq->save();

        return redirect()->route('engineering-faq')->with('success', 'Engineering FAQ updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('engineering-faq')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function engineeringFaqDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $engineeringFaq = EngineeringFaq::findOrFail($id);
        $engineeringFaq->delete();

        return redirect()->route('engineering-faq')->with('success', 'Engineering FAQ deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('engineering-faq')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}

// ============================================
// ROUTING FAQ METHODS
// ============================================

public function routingFaq()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $routingFaqs = RoutingFaq::orderBy('created_at', 'desc')->get();
    $routingFaqCount = RoutingFaq::count();
    return view('backend.routing-faq', compact('routingFaqs', 'routingFaqCount'));
}

public function routingFaqStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        RoutingFaq::create([
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()->route('routing-faq')->with('success', 'Routing FAQ added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('routing-faq')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function routingFaqEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $routingFaq = RoutingFaq::findOrFail($id);
    $routingFaqs = RoutingFaq::orderBy('created_at', 'desc')->get();
    $routingFaqCount = RoutingFaq::count();
    
    return view('backend.routing-faq', [
        'routingFaqs' => $routingFaqs,
        'editRoutingFaq' => $routingFaq,
        'routingFaqCount' => $routingFaqCount
    ]);
}

public function routingFaqUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'nullable|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        $routingFaq = RoutingFaq::findOrFail($id);
        $routingFaq->heading = $request->heading;
        $routingFaq->description = $request->description;
        $routingFaq->save();

        return redirect()->route('routing-faq')->with('success', 'Routing FAQ updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('routing-faq')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function routingFaqDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $routingFaq = RoutingFaq::findOrFail($id);
        $routingFaq->delete();

        return redirect()->route('routing-faq')->with('success', 'Routing FAQ deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('routing-faq')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}





// BackendController.php methods

public function threeDScanning()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $scannings = ThreeDScanning::orderBy('created_at', 'desc')->get();
    $canAdd = ThreeDScanning::count() < 1; // Check if can add more
    return view('backend.threedscanning', compact('scannings', 'canAdd'));
}

public function threeDScanningStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Check if already exists
    if (ThreeDScanning::count() >= 1) {
        return redirect()->route('threedscanning')->with('error', 'Only one 3D scanning content is allowed!');
    }

    $request->validate([
        'content' => 'required|string',
    ]);

    try {
        ThreeDScanning::create([
            'content' => $request->content,
        ]);

        return redirect()->route('threedscanning')->with('success', '3D Scanning content added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('threedscanning')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function threeDScanningEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $scanning = ThreeDScanning::findOrFail($id);
    $scannings = ThreeDScanning::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing
    
    return view('backend.threedscanning', [
        'scannings' => $scannings,
        'editScanning' => $scanning,
        'canAdd' => $canAdd
    ]);
}

public function threeDScanningUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'content' => 'required|string',
    ]);

    try {
        $scanning = ThreeDScanning::findOrFail($id);
        $scanning->content = $request->content;
        $scanning->save();

        return redirect()->route('threedscanning')->with('success', '3D Scanning content updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('threedscanning')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function threeDScanningDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $scanning = ThreeDScanning::findOrFail($id);
        $scanning->delete();

        return redirect()->route('threedscanning')->with('success', '3D Scanning content deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('threedscanning')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}



// Add these methods in your BackendController.php

public function threeDPrinting()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $printings = ThreeDPrinting::orderBy('created_at', 'desc')->get();
    $canAdd = ThreeDPrinting::count() < 1; // Check if can add more
    return view('backend.threedprinting', compact('printings', 'canAdd'));
}

public function threeDPrintingStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    // Check if already exists
    if (ThreeDPrinting::count() >= 1) {
        return redirect()->route('threedprinting')->with('error', 'Only one 3D printing content is allowed!');
    }
    
    $request->validate([
        'content' => 'required|string',
    ]);
    
    try {
        ThreeDPrinting::create([
            'content' => $request->content,
        ]);
        
        return redirect()->route('threedprinting')->with('success', '3D Printing content added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('threedprinting')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function threeDPrintingEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $printing = ThreeDPrinting::findOrFail($id);
    $printings = ThreeDPrinting::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing
    
    return view('backend.threedprinting', [
        'printings' => $printings,
        'editPrinting' => $printing,
        'canAdd' => $canAdd
    ]);
}

public function threeDPrintingUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $request->validate([
        'content' => 'required|string',
    ]);
    
    try {
        $printing = ThreeDPrinting::findOrFail($id);
        $printing->content = $request->content;
        $printing->save();
        
        return redirect()->route('threedprinting')->with('success', '3D Printing content updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('threedprinting')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function threeDPrintingDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    try {
        $printing = ThreeDPrinting::findOrFail($id);
        $printing->delete();
        
        return redirect()->route('threedprinting')->with('success', '3D Printing content deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('threedprinting')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}




// Add these methods in your BackendController.php

public function plasticFabrication()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $fabrications = PlasticFabrication::orderBy('created_at', 'desc')->get();
    $canAdd = PlasticFabrication::count() < 1; // Check if can add more
    return view('backend.plasticfabrication', compact('fabrications', 'canAdd'));
}

public function plasticFabricationStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    // Check if already exists
    if (PlasticFabrication::count() >= 1) {
        return redirect()->route('plasticfabrication')->with('error', 'Only one plastic fabrication content is allowed!');
    }
    
    $request->validate([
        'content' => 'required|string',
    ]);
    
    try {
        PlasticFabrication::create([
            'content' => $request->content,
        ]);
        
        return redirect()->route('plasticfabrication')->with('success', 'Plastic Fabrication content added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('plasticfabrication')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function plasticFabricationEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $fabrication = PlasticFabrication::findOrFail($id);
    $fabrications = PlasticFabrication::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing
    
    return view('backend.plasticfabrication', [
        'fabrications' => $fabrications,
        'editFabrication' => $fabrication,
        'canAdd' => $canAdd
    ]);
}

public function plasticFabricationUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $request->validate([
        'content' => 'required|string',
    ]);
    
    try {
        $fabrication = PlasticFabrication::findOrFail($id);
        $fabrication->content = $request->content;
        $fabrication->save();
        
        return redirect()->route('plasticfabrication')->with('success', 'Plastic Fabrication content updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('plasticfabrication')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function plasticFabricationDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    try {
        $fabrication = PlasticFabrication::findOrFail($id);
        $fabrication->delete();
        
        return redirect()->route('plasticfabrication')->with('success', 'Plastic Fabrication content deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('plasticfabrication')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}




// Add these methods in your BackendController.php

public function routerCutting()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $cuttings = RouterCutting::orderBy('created_at', 'desc')->get();
    $canAdd = RouterCutting::count() < 1; // Check if can add more
    return view('backend.routercutting', compact('cuttings', 'canAdd'));
}

public function routerCuttingStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    // Check if already exists
    if (RouterCutting::count() >= 1) {
        return redirect()->route('routercutting')->with('error', 'Only one router cutting content is allowed!');
    }
    
    $request->validate([
        'content' => 'required|string',
    ]);
    
    try {
        RouterCutting::create([
            'content' => $request->content,
        ]);
        
        return redirect()->route('routercutting')->with('success', 'Router Cutting content added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('routercutting')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function routerCuttingEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $cutting = RouterCutting::findOrFail($id);
    $cuttings = RouterCutting::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing
    
    return view('backend.routercutting', [
        'cuttings' => $cuttings,
        'editCutting' => $cutting,
        'canAdd' => $canAdd
    ]);
}

public function routerCuttingUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $request->validate([
        'content' => 'required|string',
    ]);
    
    try {
        $cutting = RouterCutting::findOrFail($id);
        $cutting->content = $request->content;
        $cutting->save();
        
        return redirect()->route('routercutting')->with('success', 'Router Cutting content updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('routercutting')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function routerCuttingDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    try {
        $cutting = RouterCutting::findOrFail($id);
        $cutting->delete();
        
        return redirect()->route('routercutting')->with('success', 'Router Cutting content deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('routercutting')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}



// Add these methods in your BackendController.php

public function prototyping()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $prototypings = Prototyping::orderBy('created_at', 'desc')->get();
    $canAdd = Prototyping::count() < 1; // Check if can add more
    return view('backend.prototyping', compact('prototypings', 'canAdd'));
}

public function prototypingStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    // Check if already exists
    if (Prototyping::count() >= 1) {
        return redirect()->route('prototyping')->with('error', 'Only one prototyping content is allowed!');
    }
    
    $request->validate([
        'content' => 'required|string',
    ]);
    
    try {
        Prototyping::create([
            'content' => $request->content,
        ]);
        
        return redirect()->route('prototyping')->with('success', 'Prototyping content added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('prototyping')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function prototypingEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $prototyping = Prototyping::findOrFail($id);
    $prototypings = Prototyping::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing
    
    return view('backend.prototyping', [
        'prototypings' => $prototypings,
        'editPrototyping' => $prototyping,
        'canAdd' => $canAdd
    ]);
}

public function prototypingUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $request->validate([
        'content' => 'required|string',
    ]);
    
    try {
        $prototyping = Prototyping::findOrFail($id);
        $prototyping->content = $request->content;
        $prototyping->save();
        
        return redirect()->route('prototyping')->with('success', 'Prototyping content updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('prototyping')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function prototypingDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    try {
        $prototyping = Prototyping::findOrFail($id);
        $prototyping->delete();
        
        return redirect()->route('prototyping')->with('success', 'Prototyping content deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('prototyping')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}



// Add these methods in your BackendController.php

public function reverseEngineering()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $engineerings = ReverseEngineering::orderBy('created_at', 'desc')->get();
    $canAdd = ReverseEngineering::count() < 1; // Check if can add more
    return view('backend.reverseengineering', compact('engineerings', 'canAdd'));
}

public function reverseEngineeringStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    // Check if already exists
    if (ReverseEngineering::count() >= 1) {
        return redirect()->route('reverseengineering')->with('error', 'Only one reverse engineering content is allowed!');
    }
    
    $request->validate([
        'content' => 'required|string',
    ]);
    
    try {
        ReverseEngineering::create([
            'content' => $request->content,
        ]);
        
        return redirect()->route('reverseengineering')->with('success', 'Reverse Engineering content added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('reverseengineering')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function reverseEngineeringEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $engineering = ReverseEngineering::findOrFail($id);
    $engineerings = ReverseEngineering::orderBy('created_at', 'desc')->get();
    $canAdd = true; // Allow form when editing
    
    return view('backend.reverseengineering', [
        'engineerings' => $engineerings,
        'editEngineering' => $engineering,
        'canAdd' => $canAdd
    ]);
}

public function reverseEngineeringUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $request->validate([
        'content' => 'required|string',
    ]);
    
    try {
        $engineering = ReverseEngineering::findOrFail($id);
        $engineering->content = $request->content;
        $engineering->save();
        
        return redirect()->route('reverseengineering')->with('success', 'Reverse Engineering content updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('reverseengineering')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function reverseEngineeringDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    try {
        $engineering = ReverseEngineering::findOrFail($id);
        $engineering->delete();
        
        return redirect()->route('reverseengineering')->with('success', 'Reverse Engineering content deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('reverseengineering')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}



// ============================================
// BLOG MANAGEMENT
// ============================================

public function blog()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $blogs = Blog::with(['categories', 'tags'])->orderBy('created_at', 'desc')->get();
    $categories = BlogCategory::orderBy('name', 'asc')->get();
    $tags = BlogTag::orderBy('name', 'asc')->get();
    
    return view('backend.blog', compact('blogs', 'categories', 'tags'));
}


public function blogCreate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $categories = BlogCategory::orderBy('name', 'asc')->get();
    $tags = BlogTag::orderBy('name', 'asc')->get();
    $blogs = Blog::with(['categories', 'tags'])->orderBy('created_at', 'desc')->get();
    
    return view('backend.blog-create', compact('categories', 'tags', 'blogs')); // ← blog-create
}


public function blogStore(Request $request)
{
    // DEBUG - Remove after testing
    \Log::info('Blog Store Method Called');
    \Log::info('Request Data:', $request->all());
    
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // Validation
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug', // ✅ ADD THIS LINE
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_alt_tag' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'og_image_alt_tag' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
        ]);
        
        \Log::info('Validation passed');
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation failed:', $e->errors());
        return redirect()->back()
                        ->withErrors($e->errors())
                        ->withInput();
    }

    try {
        $featuredImageName = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $featuredImageName = time() . '_featured_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $uploadPath = public_path('uploads/blogs');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $image->move($uploadPath, $featuredImageName);
            \Log::info('Featured image uploaded to: ' . $uploadPath . '/' . $featuredImageName);
        }

        $ogImageName = null;
        if ($request->hasFile('og_image')) {
            $ogImage = $request->file('og_image');
            $ogImageName = time() . '_og_' . uniqid() . '.' . $ogImage->getClientOriginalExtension();
            
            $ogUploadPath = public_path('uploads/blogs/og');
            if (!file_exists($ogUploadPath)) {
                mkdir($ogUploadPath, 0755, true);
            }
            
            $ogImage->move($ogUploadPath, $ogImageName);
            \Log::info('OG image uploaded to: ' . $ogUploadPath . '/' . $ogImageName);
        }

        $blog = Blog::create([
            'title' => $request->title,
            'slug' => $request->slug, // ✅ ADD THIS LINE
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'featured_image' => $featuredImageName,
            'image_alt_tag' => $request->image_alt_tag,
            'meta_title' => $request->meta_title ?: $request->title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'og_title' => $request->og_title ?: $request->title,
            'og_description' => $request->og_description,
            'og_image' => $ogImageName,
            'og_image_alt_tag' => $request->og_image_alt_tag,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : now(),
        ]);

        \Log::info('Blog created with ID: ' . $blog->id);

        // Attach categories and tags
        if ($request->has('categories')) {
            $blog->categories()->attach($request->categories);
            \Log::info('Categories attached');
        }
        
        if ($request->has('tags')) {
            $blog->tags()->attach($request->tags);
            \Log::info('Tags attached');
        }

        \Log::info('Blog created successfully!');
        
        return redirect()->route('blog')->with('success', 'Blog post created successfully!');
        
    } catch (\Exception $e) {
        \Log::error('Blog creation failed: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return redirect()->route('blog')->with('error', 'Failed to create blog: ' . $e->getMessage());
    }
}











public function blogEdit($id)
{
    $blog = Blog::with(['categories', 'tags'])->findOrFail($id);
    $categories = BlogCategory::orderBy('name', 'asc')->get();
    $tags = BlogTag::orderBy('name', 'asc')->get();
    
    return view('backend.blog-create', [
        'editBlog' => $blog,  // ← editBlog naam zaruri hai
        'categories' => $categories,
        'tags' => $tags
    ]);
}

public function blogUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:blogs,slug,' . $id, // ✅ ADD THIS LINE
        'excerpt' => 'nullable|string',
        'content' => 'required|string',
        'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'image_alt_tag' => 'nullable|string|max:255',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_keywords' => 'nullable|string',
        'og_title' => 'nullable|string|max:255',
        'og_description' => 'nullable|string',
        'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'og_image_alt_tag' => 'nullable|string|max:255',
        'status' => 'required|in:draft,published',
        'categories' => 'nullable|array',
        'categories.*' => 'exists:blog_categories,id',
        'tags' => 'nullable|array',
        'tags.*' => 'exists:blog_tags,id',
    ]);

    try {
        $blog = Blog::findOrFail($id);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $oldImagePath = public_path('uploads/blogs/' . $blog->featured_image);
            if ($blog->featured_image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
                \Log::info('Deleted old featured image: ' . $oldImagePath);
            }
            
            $image = $request->file('featured_image');
            $featuredImageName = time() . '_featured_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $uploadPath = public_path('uploads/blogs');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $image->move($uploadPath, $featuredImageName);
            $blog->featured_image = $featuredImageName;
            \Log::info('New featured image uploaded: ' . $uploadPath . '/' . $featuredImageName);
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $oldOgImagePath = public_path('uploads/blogs/og/' . $blog->og_image);
            if ($blog->og_image && file_exists($oldOgImagePath)) {
                unlink($oldOgImagePath);
                \Log::info('Deleted old OG image: ' . $oldOgImagePath);
            }
            
            $ogImage = $request->file('og_image');
            $ogImageName = time() . '_og_' . uniqid() . '.' . $ogImage->getClientOriginalExtension();
            
            $ogUploadPath = public_path('uploads/blogs/og');
            if (!file_exists($ogUploadPath)) {
                mkdir($ogUploadPath, 0755, true);
            }
            
            $ogImage->move($ogUploadPath, $ogImageName);
            $blog->og_image = $ogImageName;
            \Log::info('New OG image uploaded: ' . $ogUploadPath . '/' . $ogImageName);
        }

        // ✅ REMOVE THIS SECTION (Model already handles it):
        // // Generate slug
        // $blog->slug = Str::slug($request->title);
        // $count = Blog::where('slug', 'LIKE', "{$blog->slug}%")->where('id', '!=', $id)->count();
        // if ($count > 0) {
        //     $blog->slug = "{$blog->slug}-" . ($count + 1);
        // }

        // Update other fields
        $blog->title = $request->title;
        $blog->slug = $request->slug; // ✅ ADD THIS LINE
        $blog->excerpt = $request->excerpt;
        $blog->content = $request->content;
        $blog->image_alt_tag = $request->image_alt_tag;
        $blog->meta_title = $request->meta_title ?: $request->title;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->og_title = $request->og_title ?: $request->title;
        $blog->og_description = $request->og_description;
        $blog->og_image_alt_tag = $request->og_image_alt_tag;
        $blog->status = $request->status;
        
        if ($request->status === 'published' && !$blog->published_at) {
            $blog->published_at = now();
        }
        
        $blog->save();

        // Sync categories and tags
        if ($request->has('categories')) {
            $blog->categories()->sync($request->categories);
        } else {
            $blog->categories()->detach();
        }
        
        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        } else {
            $blog->tags()->detach();
        }

        return redirect()->route('blog')->with('success', 'Blog post updated successfully!');
    } catch (\Exception $e) {
        \Log::error('Blog update failed: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return redirect()->route('blog')->with('error', 'Failed to update blog: ' . $e->getMessage());
    }
}


public function blogDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $blog = Blog::findOrFail($id);
        
        if ($blog->featured_image && file_exists(public_path('../uploads/blogs/' . $blog->featured_image))) {
            unlink(public_path('../uploads/blogs/' . $blog->featured_image));
        }
        
        if ($blog->og_image && file_exists(public_path('../uploads/blogs/og/' . $blog->og_image))) {
            unlink(public_path('../uploads/blogs/og/' . $blog->og_image));
        }
        
        $blog->delete();

        return redirect()->route('blog')->with('success', 'Blog post deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('blog')->with('error', 'Failed to delete blog: ' . $e->getMessage());
    }
}

// ============================================
// CATEGORY MANAGEMENT
// ============================================

public function blogCategory()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $categories = BlogCategory::withCount('blogs')->orderBy('created_at', 'desc')->get();
    return view('backend.blog-category', compact('categories'));
}

public function blogCategoryStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'name' => 'required|string|max:255|unique:blog_categories,name',
    ]);

    try {
        BlogCategory::create(['name' => $request->name]);
        return redirect()->route('blog.category')->with('success', 'Category created successfully!');
    } catch (\Exception $e) {
        return redirect()->route('blog.category')->with('error', 'Failed to create category: ' . $e->getMessage());
    }
}

public function blogCategoryDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $category = BlogCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('blog.category')->with('success', 'Category deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('blog.category')->with('error', 'Failed to delete category: ' . $e->getMessage());
    }
}

// ============================================
// TAG MANAGEMENT
// ============================================

public function blogTag()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $tags = BlogTag::withCount('blogs')->orderBy('created_at', 'desc')->get();
    return view('backend.blog-tag', compact('tags'));
}

public function blogTagStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'name' => 'required|string|max:255|unique:blog_tags,name',
    ]);

    try {
        BlogTag::create(['name' => $request->name]);
        return redirect()->route('blog.tag')->with('success', 'Tag created successfully!');
    } catch (\Exception $e) {
        return redirect()->route('blog.tag')->with('error', 'Failed to create tag: ' . $e->getMessage());
    }
}

public function blogTagDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $tag = BlogTag::findOrFail($id);
        $tag->delete();
        return redirect()->route('blog.tag')->with('success', 'Tag deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('blog.tag')->with('error', 'Failed to delete tag: ' . $e->getMessage());
    }
}


// BackendController.php mein add karein
public function contacts()
{
    $contacts = Contact::orderBy('created_at', 'desc')->paginate(20);
    return view('backend.admin-contact', compact('contacts'));
}

public function contactDelete($id)
{
    $contact = Contact::findOrFail($id);
    $contact->delete();
    return redirect()->back()->with('success', 'Contact deleted successfully!');
}




// product catageory for



public function productCategory()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $categories = ProductCategory::orderBy('created_at', 'desc')->get();

    return view('backend.product-category', compact('categories'));
}

public function productCategoryStore(Request $request)
{
    $request->validate([
        // Basic
        'name'             => 'required|string|max:255',
        'slug'             => 'nullable|string|max:255|unique:product_categories,slug',
        'description'      => 'nullable|string',
        'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'image_alt'        => 'nullable|string|max:255',
        'sort_order'       => 'nullable|integer|min:0',
        // SEO
        'meta_title'       => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_keywords'    => 'nullable|string|max:500',
        // OG
        'og_title'         => 'nullable|string|max:255',
        'og_description'   => 'nullable|string',
        'og_image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'og_image_alt'     => 'nullable|string|max:255',
    ]);

    // ── Category image upload ──
    $imageName = null;
    if ($request->hasFile('image')) {
        $img       = $request->file('image');
        $imageName = time() . '_cat_' . uniqid() . '.' . $img->getClientOriginalExtension();
        $imgPath   = public_path('uploads/product-categories');
        if (!file_exists($imgPath)) mkdir($imgPath, 0755, true);
        $img->move($imgPath, $imageName);
    }

    // ── OG image upload ──
    $ogImageName = null;
    if ($request->hasFile('og_image')) {
        $ogImg       = $request->file('og_image');
        $ogImageName = time() . '_cat_og_' . uniqid() . '.' . $ogImg->getClientOriginalExtension();
        $ogPath      = public_path('uploads/product-categories/og');
        if (!file_exists($ogPath)) mkdir($ogPath, 0755, true);
        $ogImg->move($ogPath, $ogImageName);
    }

    // ── Slug handle ──
    $slug = $request->slug
        ? \Illuminate\Support\Str::slug($request->slug)
        : ProductCategory::generateUniqueSlug($request->name);

    // ── Create ──
    ProductCategory::create([
        'name'             => $request->name,
        'slug'             => $slug,
        'description'      => $request->description,
        'image'            => $imageName,
        'image_alt'        => $request->image_alt,
        'is_active'        => $request->has('is_active') ? 1 : 0,
        'sort_order'       => $request->sort_order ?? 0,
        // SEO
        'meta_title'       => $request->meta_title,
        'meta_description' => $request->meta_description,
        'meta_keywords'    => $request->meta_keywords,
        // OG
        'og_title'         => $request->og_title,
        'og_description'   => $request->og_description,
        'og_image'         => $ogImageName,
        'og_image_alt'     => $request->og_image_alt,
    ]);

    return redirect()->route('product.category')
                     ->with('success', 'Category successfully updated !');
}


public function productCategoryEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $editCategory = ProductCategory::findOrFail($id);
    $categories   = ProductCategory::orderBy('created_at', 'desc')->get();

    return view('backend.product-category', compact('categories', 'editCategory'));
}

// ── 2. UPDATE ─────────────────────────────────────────────────────────
public function productCategoryUpdate(Request $request, $id)
{
    $category = ProductCategory::findOrFail($id);

    $request->validate([
        // Basic
        'name'             => 'required|string|max:255',
        'slug'             => 'nullable|string|max:255|unique:product_categories,slug,' . $id,
        'description'      => 'nullable|string',
        'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'image_alt'        => 'nullable|string|max:255',
        'sort_order'       => 'nullable|integer|min:0',
        // SEO
        'meta_title'       => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_keywords'    => 'nullable|string|max:500',
        // OG
        'og_title'         => 'nullable|string|max:255',
        'og_description'   => 'nullable|string',
        'og_image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'og_image_alt'     => 'nullable|string|max:255',
    ]);

    // ── Category image update ──
    if ($request->hasFile('image')) {
        // Purani image delete karo
        if ($category->image) {
            $old = public_path('uploads/product-categories/' . $category->image);
            if (file_exists($old)) unlink($old);
        }
        $img       = $request->file('image');
        $imageName = time() . '_cat_' . uniqid() . '.' . $img->getClientOriginalExtension();
        $imgPath   = public_path('uploads/product-categories');
        if (!file_exists($imgPath)) mkdir($imgPath, 0755, true);
        $img->move($imgPath, $imageName);
        $category->image = $imageName;
    }

    // ── OG image update ──
    if ($request->hasFile('og_image')) {
        // Purana OG image delete karo
        if ($category->og_image) {
            $oldOg = public_path('uploads/product-categories/og/' . $category->og_image);
            if (file_exists($oldOg)) unlink($oldOg);
        }
        $ogImg       = $request->file('og_image');
        $ogImageName = time() . '_cat_og_' . uniqid() . '.' . $ogImg->getClientOriginalExtension();
        $ogPath      = public_path('uploads/product-categories/og');
        if (!file_exists($ogPath)) mkdir($ogPath, 0755, true);
        $ogImg->move($ogPath, $ogImageName);
        $category->og_image = $ogImageName;
    }

    // ── Slug handle ──
    if ($request->slug) {
        $newSlug = \Illuminate\Support\Str::slug($request->slug);
        // Sirf tab change karo jab slug actually badla ho
        if ($newSlug !== $category->slug) {
            $category->slug = $newSlug;
        }
    }

    // ── Basic fields ──
    $category->name        = $request->name;
    $category->description = $request->description;
    $category->image_alt   = $request->image_alt;
    $category->is_active   = $request->has('is_active') ? 1 : 0;
    $category->sort_order  = $request->sort_order ?? 0;

    // ── SEO fields ──
    $category->meta_title       = $request->meta_title;
    $category->meta_description = $request->meta_description;
    $category->meta_keywords    = $request->meta_keywords;

    // ── OG fields ──
    $category->og_title       = $request->og_title;
    $category->og_description = $request->og_description;
    $category->og_image_alt   = $request->og_image_alt;

    $category->save();

    return redirect()->route('product.category')
                     ->with('success', 'Category successfully updated !');
}

public function productCategoryDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $category = ProductCategory::findOrFail($id);

        // Agar products hain to delete mat karo
        if ($category->products()->count() > 0) {
            return redirect()->route('product.category')
                ->with('error', 'Cannot delete! This category has ' . $category->products()->count() . ' product(s). Please delete them first.');
        }

        // Image delete karo
        if ($category->image && file_exists(public_path('uploads/product-categories/' . $category->image))) {
            unlink(public_path('uploads/product-categories/' . $category->image));
        }

        $category->delete();

        return redirect()->route('product.category')->with('success', 'Product category deleted successfully!');

    } catch (\Exception $e) {
        return redirect()->route('product.category')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}


// product tag

public function productTag()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $tags = ProductTag::orderBy('created_at', 'desc')->get();
    return view('backend.product-tag', compact('tags'));
}

public function productTagStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'name' => 'required|string|max:255|unique:product_tags,name',
    ], [
        'name.required' => 'Tag name is required',
        'name.unique'   => 'This tag already exists',
    ]);

    try {
        $slug = ProductTag::generateUniqueSlug($request->name);

        ProductTag::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('product.tag')->with('success', 'Product tag added successfully!');

    } catch (\Exception $e) {
        return redirect()->route('product.tag')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function productTagEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $editTag = ProductTag::findOrFail($id);
    $tags    = ProductTag::orderBy('created_at', 'desc')->get();

    return view('backend.product-tag', compact('tags', 'editTag'));
}

public function productTagUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'name' => 'required|string|max:255|unique:product_tags,name,' . $id,
    ], [
        'name.required' => 'Tag name is required',
        'name.unique'   => 'This tag already exists',
    ]);

    try {
        $tag       = ProductTag::findOrFail($id);
        $tag->name = $request->name;
        $tag->save();

        return redirect()->route('product.tag')->with('success', 'Product tag updated successfully!');

    } catch (\Exception $e) {
        return redirect()->route('product.tag')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function productTagDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $tag = ProductTag::findOrFail($id);
        $tag->delete();

        return redirect()->route('product.tag')->with('success', 'Product tag deleted successfully!');

    } catch (\Exception $e) {
        return redirect()->route('product.tag')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}



// ============================================
// PRODUCT MANAGEMENT
// ============================================

public function product()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $products = Product::with(['categories', 'tags', 'images', 'variants'])
                       ->orderBy('created_at', 'desc')
                       ->paginate(15); // ← paginate add kiya
    
    return view('backend.product', compact('products'));
}
public function productEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $editProduct = Product::with(['categories', 'tags', 'images', 'variants'])->findOrFail($id);
    $categories  = ProductCategory::orderBy('name', 'asc')->get();
    $tags        = ProductTag::orderBy('name', 'asc')->get();
    
    return view('backend.product-edit', compact('editProduct', 'categories', 'tags'));
}
public function productCreate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $categories = ProductCategory::orderBy('name', 'asc')->get();
    $tags       = ProductTag::orderBy('name', 'asc')->get();
    
    return view('backend.product-edit', compact('categories', 'tags'));
}
public function productStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'title'              => 'required|string|max:255',
        'slug'               => 'required|string|max:255|unique:products,slug',
        'overview'           => 'nullable|string',
        'description'        => 'required|string',
        'featured_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'featured_image_alt' => 'nullable|string|max:255',
        'price'              => 'nullable|numeric|min:0',
        'sale_price'         => 'nullable|numeric|min:0',
        'sku'                => 'nullable|string|max:100',
        'stock_quantity'     => 'nullable|integer|min:0',
        'status'             => 'required|in:draft,published',
        'gallery_images.*'   => 'nullable|max:102400',
        'categories'         => 'nullable|array',
        'categories.*'       => 'exists:product_categories,id',
        'tags'               => 'nullable|array',
        'tags.*'             => 'exists:product_tags,id',
        'og_image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'tab_titles'         => 'nullable|array',
        'tab_titles.*'       => 'nullable|string|max:255',
        'tab_contents'       => 'nullable|array',
        'tab_contents.*'     => 'nullable|string',
    ]);

    try {
        // ── Featured Image ──
        $featuredImageName = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $featuredImageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = public_path('uploads/products');
            if (!file_exists($path)) mkdir($path, 0755, true);
            $image->move($path, $featuredImageName);
        }

        // ── OG Image ──
        $ogImageName = null;
        if ($request->hasFile('og_image')) {
            $og = $request->file('og_image');
            $ogImageName = time() . '_og_' . uniqid() . '.' . $og->getClientOriginalExtension();
            $ogPath = public_path('uploads/products/og');
            if (!file_exists($ogPath)) mkdir($ogPath, 0755, true);
            $og->move($ogPath, $ogImageName);
        }

        // ── Extra Tabs ──
        $extraTabs = [];
        $tabTitles = $request->input('tab_titles', []);
        $tabContents = $request->input('tab_contents', []);

        if (!empty($tabTitles) && is_array($tabTitles)) {
            foreach ($tabTitles as $i => $title) {
                $title = trim($title ?? '');
                if ($title !== '') {
                    $extraTabs[] = [
                        'title'   => $title,
                        'content' => $tabContents[$i] ?? '',
                    ];
                }
            }
        }

        // ── Create Product ──
        $product = Product::create([
            'title'              => $request->title,
            'slug'               => $request->slug,
            'overview'           => $request->overview,
            'description'        => $request->description,
            'featured_image'     => $featuredImageName,
            'featured_image_alt' => $request->featured_image_alt,
            'price'              => $request->price,
            'sale_price'         => $request->sale_price,
            'sku'                => $request->sku,
            'stock_quantity'     => $request->stock_quantity ?? 0,
            'status'             => $request->status,
            'is_featured'        => $request->has('is_featured') ? 1 : 0,
            'meta_title'         => $request->meta_title ?: $request->title,
            'meta_description'   => $request->meta_description,
            'meta_keywords'      => $request->meta_keywords,
            'og_title'           => $request->og_title ?: $request->title,
            'og_description'     => $request->og_description,
            'og_image'           => $ogImageName,
            'og_image_alt'       => $request->og_image_alt,
            'extra_tabs'         => !empty($extraTabs) ? json_encode($extraTabs) : null,
            'cta_button'         => $request->cta_button ?? 'add_to_cart',
            'published_at'       => $request->status === 'published' ? now() : null,
        ]);

        // ── Categories & Tags ──
        if ($request->has('categories')) $product->categories()->attach($request->categories);
        if ($request->has('tags')) $product->tags()->attach($request->tags);

        // ── Gallery Images ──
        if ($request->hasFile('gallery_images')) {
            $galleryPath = public_path('uploads/products/gallery');
            if (!file_exists($galleryPath)) mkdir($galleryPath, 0755, true);

            $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];

            foreach ($request->file('gallery_images') as $i => $file) {
                $ext = strtolower($file->getClientOriginalExtension());
                $type = in_array($ext, $videoExtensions) ? 'video' : 'image';
                $name = time() . '_gallery_' . $i . '_' . uniqid() . '.' . $ext;
                $file->move($galleryPath, $name);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $name,
                    'type'       => $type,
                    'alt_tag'    => '',
                    'sort_order' => $i,
                ]);
            }
        }

        // ── VARIANTS (CREATE) ──
        if ($request->has('variant_names') && is_array($request->variant_names)) {
            $variantImagePath = public_path('uploads/products/variants');
            if (!file_exists($variantImagePath)) mkdir($variantImagePath, 0755, true);
            $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];

            foreach ($request->variant_names as $idx => $name) {
                if (empty(trim($name))) continue;

                $attrRaw = $request->variant_attributes[$idx] ?? '{}';
                $attrs = json_decode($attrRaw, true);
                if (!is_array($attrs)) $attrs = [];

                // ✅ Variant Image Upload - ONLY if file exists
                $variantImageName = null;
                $variantImages = $request->file('variant_images');
                
                if (!empty($variantImages) && isset($variantImages[$idx]) && $variantImages[$idx] instanceof \Illuminate\Http\UploadedFile) {
                    $vImg = $variantImages[$idx];
                    $variantImageName = time() . '_variant_' . $idx . '_' . uniqid() . '.' . $vImg->getClientOriginalExtension();
                    $vImg->move($variantImagePath, $variantImageName);
                }

                ProductVariant::create([
                    'product_id'     => $product->id,
                    'name'           => trim($name),
                    'sku'            => $request->variant_skus[$idx] ?? null,
                    'price'          => $request->variant_prices[$idx] ?? null,
                    'compare_price'  => $request->variant_compare_prices[$idx] ?? null,
                    'stock_quantity' => $request->variant_stocks[$idx] ?? 0,
                    'attributes'     => $attrs,
                    'image'          => $variantImageName,
                ]);
            }
        }

        return redirect()->route('product')->with('success', 'Product created successfully!');

    } catch (\Exception $e) {
        \Log::error('Product creation failed: ' . $e->getMessage());
        return redirect()->route('product')->with('error', 'Failed: ' . $e->getMessage());
    }
}
 
 
public function productUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'title'              => 'required|string|max:255',
        'slug'               => 'required|string|max:255|unique:products,slug,' . $id,
        'overview'           => 'nullable|string',
        'description'        => 'required|string',
        'featured_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'featured_image_alt' => 'nullable|string|max:255',
        'price'              => 'nullable|numeric|min:0',
        'sale_price'         => 'nullable|numeric|min:0',
        'sku'                => 'nullable|string|max:100',
        'stock_quantity'     => 'nullable|integer|min:0',
        'status'             => 'required|in:draft,published',
        'gallery_images.*'   => 'nullable|max:102400',
        'categories'         => 'nullable|array',
        'categories.*'       => 'exists:product_categories,id',
        'tags'               => 'nullable|array',
        'tags.*'             => 'exists:product_tags,id',
        'og_image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'tab_titles'         => 'nullable|array',
        'tab_titles.*'       => 'nullable|string|max:255',
        'tab_contents'       => 'nullable|array',
        'tab_contents.*'     => 'nullable|string',
    ]);

    try {
        $product = Product::findOrFail($id);

        // ── Featured Image ──
        if ($request->hasFile('featured_image')) {
            if ($product->featured_image && file_exists(public_path('uploads/products/' . $product->featured_image))) {
                unlink(public_path('uploads/products/' . $product->featured_image));
            }
            $img = $request->file('featured_image');
            $name = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/products'), $name);
            $product->featured_image = $name;
        }

        if ($request->remove_featured_image == '1') {
            if ($product->featured_image && file_exists(public_path('uploads/products/' . $product->featured_image))) {
                unlink(public_path('uploads/products/' . $product->featured_image));
            }
            $product->featured_image = null;
        }

        // ── OG Image ──
        if ($request->hasFile('og_image')) {
            if ($product->og_image && file_exists(public_path('uploads/products/og/' . $product->og_image))) {
                unlink(public_path('uploads/products/og/' . $product->og_image));
            }
            $og = $request->file('og_image');
            $name = time() . '_og_' . uniqid() . '.' . $og->getClientOriginalExtension();
            $ogPath = public_path('uploads/products/og');
            if (!file_exists($ogPath)) mkdir($ogPath, 0755, true);
            $og->move($ogPath, $name);
            $product->og_image = $name;
        }

        if ($request->remove_og_image == '1') {
            if ($product->og_image && file_exists(public_path('uploads/products/og/' . $product->og_image))) {
                unlink(public_path('uploads/products/og/' . $product->og_image));
            }
            $product->og_image = null;
        }

        // ── Extra Tabs ──
        $extraTabs = [];
        $tabTitles = $request->input('tab_titles', []);
        $tabContents = $request->input('tab_contents', []);

        if (!empty($tabTitles) && is_array($tabTitles)) {
            foreach ($tabTitles as $i => $title) {
                $title = trim($title ?? '');
                if ($title !== '') {
                    $extraTabs[] = [
                        'title'   => $title,
                        'content' => $tabContents[$i] ?? '',
                    ];
                }
            }
        }

        // ── Update Product Fields ──
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->overview = $request->overview;
        $product->description = $request->description;
        $product->featured_image_alt = $request->featured_image_alt;
        $product->price = $request->price;
        $product->sale_price = $request->sale_price;
        $product->sku = $request->sku;
        $product->stock_quantity = $request->stock_quantity ?? 0;
        $product->status = $request->status;
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->og_title = $request->og_title;
        $product->og_description = $request->og_description;
        $product->og_image_alt = $request->og_image_alt;
        $product->extra_tabs = !empty($extraTabs) ? json_encode($extraTabs) : null;
        $product->cta_button = $request->cta_button ?? 'add_to_cart';

        if ($request->status === 'published' && !$product->published_at) {
            $product->published_at = now();
        }

        $product->save();

        // ── Categories & Tags ──
        $product->categories()->sync($request->categories ?? []);
        $product->tags()->sync($request->tags ?? []);

        // ── New Gallery Images ──
        if ($request->hasFile('gallery_images')) {
            $galleryPath = public_path('uploads/products/gallery');
            if (!file_exists($galleryPath)) mkdir($galleryPath, 0755, true);
            $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];

            foreach ($request->file('gallery_images') as $i => $file) {
                $ext = strtolower($file->getClientOriginalExtension());
                $type = in_array($ext, $videoExtensions) ? 'video' : 'image';
                $name = time() . '_gallery_' . $i . '_' . uniqid() . '.' . $ext;
                $file->move($galleryPath, $name);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $name,
                    'type'       => $type,
                    'alt_tag'    => '',
                    'sort_order' => $i,
                ]);
            }
        }

        // ── VARIANTS (UPDATE - NO DELETION) ──
        $existingVariantNames = [];

        if ($request->has('variant_names') && is_array($request->variant_names)) {
            $variantImagePath = public_path('uploads/products/variants');
            if (!file_exists($variantImagePath)) mkdir($variantImagePath, 0755, true);

            foreach ($request->variant_names as $idx => $name) {
                if (empty(trim($name))) continue;

                $attrRaw = $request->variant_attributes[$idx] ?? '{}';
                $attrs = json_decode($attrRaw, true);
                if (!is_array($attrs)) $attrs = [];

                // Check if variant already exists
                $existingVariant = ProductVariant::where('product_id', $product->id)
                                                  ->where('name', trim($name))
                                                  ->first();

                $variantImageName = null;
                $variantImages = $request->file('variant_images');

                // ✅ ONLY process if an actual file is uploaded for THIS variant
                if (!empty($variantImages) && isset($variantImages[$idx]) && $variantImages[$idx] instanceof \Illuminate\Http\UploadedFile) {
                    $vImg = $variantImages[$idx];

                    // Delete old image if exists
                    if ($existingVariant && $existingVariant->image && file_exists(public_path('uploads/products/variants/' . $existingVariant->image))) {
                        unlink(public_path('uploads/products/variants/' . $existingVariant->image));
                    }

                    $variantImageName = time() . '_variant_' . $idx . '_' . uniqid() . '.' . $vImg->getClientOriginalExtension();
                    $vImg->move($variantImagePath, $variantImageName);
                } else {
                    // ✅ KEEP existing image if no new file uploaded
                    if ($existingVariant && $existingVariant->image) {
                        $variantImageName = $existingVariant->image;
                    }
                }

                if ($existingVariant) {
                    // UPDATE existing variant
                    $existingVariant->update([
                        'sku'            => $request->variant_skus[$idx] ?? null,
                        'price'          => $request->variant_prices[$idx] ?? null,
                        'compare_price'  => $request->variant_compare_prices[$idx] ?? null,
                        'stock_quantity' => $request->variant_stocks[$idx] ?? 0,
                        'attributes'     => $attrs,
                        'image'          => $variantImageName,
                    ]);
                    $existingVariantNames[] = trim($name);
                } else {
                    // INSERT new variant
                    ProductVariant::create([
                        'product_id'     => $product->id,
                        'name'           => trim($name),
                        'sku'            => $request->variant_skus[$idx] ?? null,
                        'price'          => $request->variant_prices[$idx] ?? null,
                        'compare_price'  => $request->variant_compare_prices[$idx] ?? null,
                        'stock_quantity' => $request->variant_stocks[$idx] ?? 0,
                        'attributes'     => $attrs,
                        'image'          => $variantImageName,
                    ]);
                    $existingVariantNames[] = trim($name);
                }
            }
        }

        // ✅ Delete ONLY those variants that were removed from the form
        $product->variants()->whereNotIn('name', $existingVariantNames)->each(function($variant) {
            if ($variant->image && file_exists(public_path('uploads/products/variants/' . $variant->image))) {
                unlink(public_path('uploads/products/variants/' . $variant->image));
            }
            $variant->delete();
        });

        return redirect()->route('product')->with('success', 'Product updated successfully!');

    } catch (\Exception $e) {
        \Log::error('Product update failed: ' . $e->getMessage());
        return redirect()->route('product')->with('error', 'Failed: ' . $e->getMessage());
    }
}
// Delete Gallery Image
public function productDeleteGalleryImage($id)
{
    if (!Session::has('user_id')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    try {
        $image = ProductImage::findOrFail($id);
        
        if (file_exists(public_path('uploads/products/gallery/' . $image->image))) {
            unlink(public_path('uploads/products/gallery/' . $image->image));
        }
        
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

// Delete Variant
public function productDeleteVariant($id)
{
    if (!Session::has('user_id')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    try {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return response()->json(['success' => true, 'message' => 'Variant deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



public function productDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $product = Product::findOrFail($id);

        // Delete featured image
        if ($product->featured_image && file_exists(public_path('uploads/products/' . $product->featured_image))) {
            unlink(public_path('uploads/products/' . $product->featured_image));
        }

        // Delete OG image
        if ($product->og_image && file_exists(public_path('uploads/products/og/' . $product->og_image))) {
            unlink(public_path('uploads/products/og/' . $product->og_image));
        }

        // Delete gallery images
        foreach ($product->images as $image) {
            if (file_exists(public_path('uploads/products/gallery/' . $image->image))) {
                unlink(public_path('uploads/products/gallery/' . $image->image));
            }
            $image->delete();
        }

        // Delete variants
        $product->variants()->delete();

        // Detach categories & tags
        $product->categories()->detach();
        $product->tags()->detach();

        // Delete product
        $product->delete();

        return redirect()->route('product')->with('success', 'Product deleted successfully!');

    } catch (\Exception $e) {
        return redirect()->route('product')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}

// HOME CATEGORY MANAGEMENT
public function homeCategory()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $categories = HomeCategory::orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->get();
    return view('backend.home-category', compact('categories'));
}

public function homeCategoryStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'title'      => 'required|string|max:255',
        'url'        => 'nullable|string|max:500',
        'alt_tag'    => 'nullable|string|max:255',
        'sort_order' => 'nullable|integer|min:0',
        'image'      => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/home-categories');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $image->move($uploadPath, $imageName);
        }

        HomeCategory::create([
            'title'      => $request->title,
            'url'        => $request->url,
            'alt_tag'    => $request->alt_tag,
            'sort_order' => $request->sort_order ?? 0,
            'image'      => $imageName,
        ]);

        return redirect()->route('home.category')->with('success', 'Category added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('home.category')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function homeCategoryEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $editCategory = HomeCategory::findOrFail($id);
    $categories   = HomeCategory::orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->get();

    return view('backend.home-category', compact('categories', 'editCategory'));
}

public function homeCategoryUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'title'      => 'required|string|max:255',
        'url'        => 'nullable|string|max:500',
        'alt_tag'    => 'nullable|string|max:255',
        'sort_order' => 'nullable|integer|min:0',
        'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        $category = HomeCategory::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && file_exists(public_path('uploads/home-categories/' . $category->image))) {
                unlink(public_path('uploads/home-categories/' . $category->image));
            }
            $image     = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/home-categories');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $image->move($uploadPath, $imageName);
            $category->image = $imageName;
        }

        $category->title      = $request->title;
        $category->url        = $request->url;
        $category->alt_tag    = $request->alt_tag;
        $category->sort_order = $request->sort_order ?? 0;
        $category->save();

        return redirect()->route('home.category')->with('success', 'Category updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('home.category')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function homeCategoryDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $category = HomeCategory::findOrFail($id);

        if ($category->image && file_exists(public_path('uploads/home-categories/' . $category->image))) {
            unlink(public_path('uploads/home-categories/' . $category->image));
        }

        $category->delete();

        return redirect()->route('home.category')->with('success', 'Category deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('home.category')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}
// HOME PRODUCT SECTIONS MANAGEMENT
public function homeProductSection()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $sections   = HomeProductSection::with('category')->orderBy('sort_order')->get();
    $categories = \App\Models\ProductCategory::where('is_active', 1)->orderBy('name')->get();

    return view('backend.home-product-section', compact('sections', 'categories'));
}

public function homeProductSectionStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading'       => 'required|string|max:255',
        'sub_heading'   => 'nullable|string|max:255',
        'view_all_text' => 'nullable|string|max:100',
        'view_all_url'  => 'nullable|string|max:500',
        'category_id'   => 'nullable|exists:product_categories,id',
        'product_limit' => 'required|integer|min:1|max:20',
        'sort_order'    => 'nullable|integer|min:0',
    ]);

    try {
        HomeProductSection::create([
            'heading'       => $request->heading,
            'sub_heading'   => $request->sub_heading,
            'view_all_text' => $request->view_all_text ?: 'View All',
            'view_all_url'  => $request->view_all_url,
            'category_id'   => $request->category_id ?: null,
            'product_limit' => $request->product_limit ?? 5,
            'sort_order'    => $request->sort_order ?? 0,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('home.product.section')
                         ->with('success', 'Section created successfully!');
    } catch (\Exception $e) {
        return redirect()->route('home.product.section')
                         ->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function homeProductSectionEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $editSection = HomeProductSection::findOrFail($id);
    $sections    = HomeProductSection::with('category')->orderBy('sort_order')->get();
    $categories  = \App\Models\ProductCategory::where('is_active', 1)->orderBy('name')->get();

    return view('backend.home-product-section', compact('sections', 'categories', 'editSection'));
}

public function homeProductSectionUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading'       => 'required|string|max:255',
        'sub_heading'   => 'nullable|string|max:255',
        'view_all_text' => 'nullable|string|max:100',
        'view_all_url'  => 'nullable|string|max:500',
        'category_id'   => 'nullable|exists:product_categories,id',
        'product_limit' => 'required|integer|min:1|max:20',
        'sort_order'    => 'nullable|integer|min:0',
    ]);

    try {
        $section = HomeProductSection::findOrFail($id);
        $section->update([
            'heading'       => $request->heading,
            'sub_heading'   => $request->sub_heading,
            'view_all_text' => $request->view_all_text ?: 'View All',
            'view_all_url'  => $request->view_all_url,
            'category_id'   => $request->category_id ?: null,
            'product_limit' => $request->product_limit ?? 5,
            'sort_order'    => $request->sort_order ?? 0,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('home.product.section')
                         ->with('success', 'Section updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('home.product.section')
                         ->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function homeProductSectionDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        HomeProductSection::findOrFail($id)->delete();
        return redirect()->route('home.product.section')
                         ->with('success', 'Section deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('home.product.section')
                         ->with('error', 'Failed: ' . $e->getMessage());
    }
}

// ── BRAND SECTION SETTINGS ───────────────────────────────────
public function brandSection()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    $section   = \App\Models\HomeBrandSection::first();
    $brands    = \App\Models\HomeBrand::orderBy('sort_order')->orderBy('created_at')->get();
    return view('backend.brand-section', compact('section', 'brands'));
}

public function brandSectionSave(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    $request->validate([
        'heading'       => 'required|string|max:255',
        'view_all_text' => 'nullable|string|max:100',
        'view_all_url'  => 'nullable|string|max:500',
    ]);
    \App\Models\HomeBrandSection::updateOrCreate(
        ['id' => 1],
        [
            'heading'       => $request->heading,
            'view_all_text' => $request->view_all_text ?? 'View All',
            'view_all_url'  => $request->view_all_url,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]
    );
    return redirect()->route('brand.section')->with('success', 'Brand section settings saved!');
}

// ── BRAND CRUD ────────────────────────────────────────────────
public function brandStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    $request->validate([
        'image'      => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'alt_tag'    => 'nullable|string|max:255',
        'url'        => 'nullable|string|max:500',
        'sort_order' => 'nullable|integer|min:0',
    ]);
    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $img        = $request->file('image');
            $imageName  = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $uploadPath = public_path('uploads/brands');
            if (!file_exists($uploadPath)) mkdir($uploadPath, 0755, true);
            $img->move($uploadPath, $imageName);
        }
        \App\Models\HomeBrand::create([
            'image'      => $imageName,
            'alt_tag'    => $request->alt_tag,
            'url'        => $request->url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->has('is_active') ? 1 : 0,
        ]);
        return redirect()->route('brand.section')->with('success', 'Brand added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('brand.section')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function brandEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    $editBrand = \App\Models\HomeBrand::findOrFail($id);
    $section   = \App\Models\HomeBrandSection::first();
    $brands    = \App\Models\HomeBrand::orderBy('sort_order')->get();
    return view('backend.brand-section', compact('section', 'brands', 'editBrand'));
}

public function brandUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    $request->validate([
        'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'alt_tag'    => 'nullable|string|max:255',
        'url'        => 'nullable|string|max:500',
        'sort_order' => 'nullable|integer|min:0',
    ]);
    try {
        $brand = \App\Models\HomeBrand::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($brand->image && file_exists(public_path('uploads/brands/' . $brand->image))) {
                unlink(public_path('uploads/brands/' . $brand->image));
            }
            $img       = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $path      = public_path('uploads/brands');
            if (!file_exists($path)) mkdir($path, 0755, true);
            $img->move($path, $imageName);
            $brand->image = $imageName;
        }
        $brand->alt_tag    = $request->alt_tag;
        $brand->url        = $request->url;
        $brand->sort_order = $request->sort_order ?? 0;
        $brand->is_active  = $request->has('is_active') ? 1 : 0;
        $brand->save();
        return redirect()->route('brand.section')->with('success', 'Brand updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('brand.section')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function brandDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    try {
        $brand = \App\Models\HomeBrand::findOrFail($id);
        if ($brand->image && file_exists(public_path('uploads/brands/' . $brand->image))) {
            unlink(public_path('uploads/brands/' . $brand->image));
        }
        $brand->delete();
        return redirect()->route('brand.section')->with('success', 'Brand deleted!');
    } catch (\Exception $e) {
        return redirect()->route('brand.section')->with('error', 'Failed: ' . $e->getMessage());
    }
}




// LIST PAGE
public function homeLogo()
{
    if (!Session::has('user_id')) return redirect()->route('login');
    $logos = \App\Models\HomeLogo::orderBy('sort_order')->orderBy('created_at')->get();
    return view('backend.homelogo', compact('logos'));
}

// STORE
public function homeLogoStore(Request $request)
{
    if (!Session::has('user_id')) return redirect()->route('login');
    $request->validate([
        'image'      => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'alt_tag'    => 'nullable|string|max:255',
        'url'        => 'nullable|string|max:500',
        'sort_order' => 'nullable|integer|min:0',
    ]);
    try {
        $img       = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
        $uploadPath = public_path('uploads/homelogos');
        if (!file_exists($uploadPath)) mkdir($uploadPath, 0755, true);
        $img->move($uploadPath, $imageName);

        \App\Models\HomeLogo::create([
            'image'      => $imageName,
            'alt_tag'    => $request->alt_tag,
            'url'        => $request->url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->has('is_active') ? 1 : 0,
        ]);
        return redirect()->route('homelogo.index')->with('success', 'Logo added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('homelogo.index')->with('error', 'Failed: ' . $e->getMessage());
    }
}

// EDIT
public function homeLogoEdit($id)
{
    if (!Session::has('user_id')) return redirect()->route('login');
    $editLogo = \App\Models\HomeLogo::findOrFail($id);
    $logos    = \App\Models\HomeLogo::orderBy('sort_order')->get();
    return view('backend.homelogo', compact('logos', 'editLogo'));
}

// UPDATE
public function homeLogoUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) return redirect()->route('login');
    $request->validate([
        'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'alt_tag'    => 'nullable|string|max:255',
        'url'        => 'nullable|string|max:500',
        'sort_order' => 'nullable|integer|min:0',
    ]);
    try {
        $logo = \App\Models\HomeLogo::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($logo->image && file_exists(public_path('uploads/homelogos/' . $logo->image))) {
                unlink(public_path('uploads/homelogos/' . $logo->image));
            }
            $img       = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $path      = public_path('uploads/homelogos');
            if (!file_exists($path)) mkdir($path, 0755, true);
            $img->move($path, $imageName);
            $logo->image = $imageName;
        }
        $logo->alt_tag    = $request->alt_tag;
        $logo->url        = $request->url;
        $logo->sort_order = $request->sort_order ?? 0;
        $logo->is_active  = $request->has('is_active') ? 1 : 0;
        $logo->save();
        return redirect()->route('homelogo.index')->with('success', 'Logo updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('homelogo.index')->with('error', 'Failed: ' . $e->getMessage());
    }
}

// DELETE
public function homeLogoDelete($id)
{
    if (!Session::has('user_id')) return redirect()->route('login');
    try {
        $logo = \App\Models\HomeLogo::findOrFail($id);
        if ($logo->image && file_exists(public_path('uploads/homelogos/' . $logo->image))) {
            unlink(public_path('uploads/homelogos/' . $logo->image));
        }
        $logo->delete();
        return redirect()->route('homelogo.index')->with('success', 'Logo deleted!');
    } catch (\Exception $e) {
        return redirect()->route('homelogo.index')->with('error', 'Failed: ' . $e->getMessage());
    }
}











public function footerNew()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    $footer = FooterNew::first();
    $canAdd = FooterNew::count() < 1;
    return view('backend.footer-new', compact('footer', 'canAdd'));
}

public function footerNewStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    if (FooterNew::count() >= 1) {
        return redirect()->route('footer.new')->with('error', 'Only one footer allowed!');
    }
    $request->validate([
        'col1_logo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'col1_logo_alt'         => 'nullable|string|max:255',
        'col1_content'          => 'nullable|string',
        'col1_social_facebook'  => 'nullable|string|max:500',
        'col1_social_instagram' => 'nullable|string|max:500',
        'col1_social_twitter'   => 'nullable|string|max:500',
        'col1_social_youtube'   => 'nullable|string|max:500',
        'col1_social_linkedin'  => 'nullable|string|max:500',
        'col1_social_whatsapp'  => 'nullable|string|max:50',
        'col2_heading'          => 'nullable|string|max:255',
        'col3_heading'          => 'nullable|string|max:255',
        'col3_content'          => 'nullable|string',
        'col4_heading'          => 'nullable|string|max:255',
        'col4_content'          => 'nullable|string',
    ]);
    try {
        $logoName = null;
        if ($request->hasFile('col1_logo')) {
            $logo     = $request->file('col1_logo');
            $logoName = time() . '_footer_logo.' . $logo->getClientOriginalExtension();
            $path     = public_path('uploads/footer');
            if (!file_exists($path)) mkdir($path, 0755, true);
            $logo->move($path, $logoName);
        }
        $links = [];
        if ($request->has('link_title') && is_array($request->link_title)) {
            foreach ($request->link_title as $i => $title) {
                if (!empty(trim($title))) {
                    $links[] = ['title' => trim($title), 'url' => trim($request->link_url[$i] ?? '#')];
                }
            }
        }
        FooterNew::create([
            'col1_logo'             => $logoName,
            'col1_logo_alt'         => $request->col1_logo_alt,
            'col1_content'          => $request->col1_content,
            'col1_social_facebook'  => $request->col1_social_facebook,
            'col1_social_instagram' => $request->col1_social_instagram,
            'col1_social_twitter'   => $request->col1_social_twitter,
            'col1_social_youtube'   => $request->col1_social_youtube,
            'col1_social_linkedin'  => $request->col1_social_linkedin,
            'col1_social_whatsapp'  => $request->col1_social_whatsapp,
            'col2_heading'          => $request->col2_heading,
            'col2_links'            => $links,
            'col3_heading'          => $request->col3_heading,
            'col3_content'          => $request->col3_content,
            'col4_heading'          => $request->col4_heading,
            'col4_content'          => $request->col4_content,
        ]);
        return redirect()->route('footer.new')->with('success', 'Footer saved successfully!');
    } catch (\Exception $e) {
        return redirect()->route('footer.new')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function footerNewUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    $request->validate([
        'col1_logo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        'col1_social_facebook'  => 'nullable|string|max:500',
        'col1_social_instagram' => 'nullable|string|max:500',
        'col1_social_twitter'   => 'nullable|string|max:500',
        'col1_social_youtube'   => 'nullable|string|max:500',
        'col1_social_linkedin'  => 'nullable|string|max:500',
        'col1_social_whatsapp'  => 'nullable|string|max:50',
    ]);
    try {
        $footer = FooterNew::findOrFail($id);
        if ($request->hasFile('col1_logo')) {
            if ($footer->col1_logo && file_exists(public_path('uploads/footer/' . $footer->col1_logo))) {
                unlink(public_path('uploads/footer/' . $footer->col1_logo));
            }
            $logo = $request->file('col1_logo');
            $logoName = time() . '_footer_logo.' . $logo->getClientOriginalExtension();
            $path = public_path('uploads/footer');
            if (!file_exists($path)) mkdir($path, 0755, true);
            $logo->move($path, $logoName);
            $footer->col1_logo = $logoName;
        }
        if ($request->remove_logo == '1') {
            if ($footer->col1_logo && file_exists(public_path('uploads/footer/' . $footer->col1_logo))) {
                unlink(public_path('uploads/footer/' . $footer->col1_logo));
            }
            $footer->col1_logo = null;
        }
        $links = [];
        if ($request->has('link_title') && is_array($request->link_title)) {
            foreach ($request->link_title as $i => $title) {
                if (!empty(trim($title))) {
                    $links[] = ['title' => trim($title), 'url' => trim($request->link_url[$i] ?? '#')];
                }
            }
        }
        $footer->col1_logo_alt         = $request->col1_logo_alt;
        $footer->col1_content          = $request->col1_content;
        $footer->col1_social_facebook  = $request->col1_social_facebook;
        $footer->col1_social_instagram = $request->col1_social_instagram;
        $footer->col1_social_twitter   = $request->col1_social_twitter;
        $footer->col1_social_youtube   = $request->col1_social_youtube;
        $footer->col1_social_linkedin  = $request->col1_social_linkedin;
        $footer->col1_social_whatsapp  = $request->col1_social_whatsapp;
        $footer->col2_heading          = $request->col2_heading;
        $footer->col2_links            = $links;
        $footer->col3_heading          = $request->col3_heading;
        $footer->col3_content          = $request->col3_content;
        $footer->col4_heading          = $request->col4_heading;
        $footer->col4_content          = $request->col4_content;
        $footer->save();
        return redirect()->route('footer.new')->with('success', 'Footer updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('footer.new')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function footerNewDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    try {
        $footer = FooterNew::findOrFail($id);
        if ($footer->col1_logo && file_exists(public_path('uploads/footer/' . $footer->col1_logo))) {
            unlink(public_path('uploads/footer/' . $footer->col1_logo));
        }
        $footer->delete();
        return redirect()->route('footer.new')->with('success', 'Footer deleted!');
    } catch (\Exception $e) {
        return redirect()->route('footer.new')->with('error', 'Failed: ' . $e->getMessage());
    }
}






// ============================================
// PRIVACY POLICY MANAGEMENT
// ============================================

public function privacyPolicy()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $page = PrivacyPolicy::first();
    $canAdd = PrivacyPolicy::count() < 1;
    
    return view('backend.privacy-policy', compact('page', 'canAdd'));
}

public function privacyPolicyStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    // ✅ DEBUG: Log incoming data
    \Log::info('Privacy Policy Store Request:', $request->all());

    if (PrivacyPolicy::count() >= 1) {
        return redirect()->route('privacy.policy')->with('error', 'Privacy Policy already exists!');
    }

    $request->validate([
        'heading' => 'required|string|max:255',
        'description' => 'required|string|min:10', // ✅ Added min:10
    ]);

    // ✅ DEBUG: Log validated data
    \Log::info('Validated Data:', $request->only(['heading', 'description']));

    try {
        $created = PrivacyPolicy::create([
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        // ✅ DEBUG: Log created record
        \Log::info('Privacy Policy Created:', ['id' => $created->id]);

        return redirect()->route('privacy.policy')->with('success', 'Privacy Policy created successfully!');
    } catch (\Exception $e) {
        // ✅ DEBUG: Log error
        \Log::error('Privacy Policy Store Error: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return redirect()->route('privacy.policy')->with('error', 'Failed to create: ' . $e->getMessage());
    }
}

public function privacyPolicyUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    try {
        $page = PrivacyPolicy::findOrFail($id);
        
        $page->heading = $request->heading;
        $page->description = $request->description;
        $page->save();

        return redirect()->route('privacy.policy')->with('success', 'Privacy Policy updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('privacy.policy')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function privacyPolicyDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $page = PrivacyPolicy::findOrFail($id);
        $page->delete();

        return redirect()->route('privacy.policy')->with('success', 'Privacy Policy deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('privacy.policy')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}

// ============================================
// TERMS OF SERVICE MANAGEMENT
// ============================================

public function termsOfService()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $page = TermsOfService::first();
    $canAdd = TermsOfService::count() < 1;
    
    return view('backend.terms-of-service', compact('page', 'canAdd'));
}

public function termsOfServiceStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    if (TermsOfService::count() >= 1) {
        return redirect()->route('terms.of.service')->with('error', 'Terms of Service already exists!');
    }

    $request->validate([
        'heading' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    try {
        TermsOfService::create([
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()->route('terms.of.service')->with('success', 'Terms of Service created successfully!');
    } catch (\Exception $e) {
        return redirect()->route('terms.of.service')->with('error', 'Failed to create: ' . $e->getMessage());
    }
}

public function termsOfServiceUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    try {
        $page = TermsOfService::findOrFail($id);
        
        $page->heading = $request->heading;
        $page->description = $request->description;
        $page->save();

        return redirect()->route('terms.of.service')->with('success', 'Terms of Service updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('terms.of.service')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function termsOfServiceDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $page = TermsOfService::findOrFail($id);
        $page->delete();

        return redirect()->route('terms.of.service')->with('success', 'Terms of Service deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('terms.of.service')->with('error', 'Failed to delete: ' . $e->getMessage());
    } 
}


public function promotionalBanner()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $banner = \App\Models\PromotionalBanner::first();
    $canAdd = \App\Models\PromotionalBanner::count() < 1;
    
    return view('backend.promotional-banner', compact('banner', 'canAdd'));
}
 
public function promotionalBannerStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
 
    // Check if already exists
    if (\App\Models\PromotionalBanner::count() >= 1) {
        return redirect()->route('promotional.banner')->with('error', 'Only one promotional banner is allowed!');
    }
 
    $request->validate([
        'background_image'          => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'background_image_alt'      => 'nullable|string|max:255',
        'background_image_mobile'   => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // ✅ NEW
        'background_image_mobile_alt' => 'nullable|string|max:255', // ✅ NEW
        'sub_heading'               => 'nullable|string|max:255',
        'heading'                   => 'required|string|max:255',
        'sale_heading'              => 'nullable|string|max:255',
        'sale_end_date'             => 'required|date',
        'button_text'               => 'required|string|max:100',
        'button_url'                => 'required|url|max:500',
    ]);
 
    try {
        $imageName = null;
        if ($request->hasFile('background_image')) {
            $image = $request->file('background_image');
            $imageName = time() . '_promo_desktop_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/promotional-banners');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $image->move($uploadPath, $imageName);
        }
 
        // ✅ NEW - Mobile image upload
        $mobileImageName = null;
        if ($request->hasFile('background_image_mobile')) {
            $mobileImage = $request->file('background_image_mobile');
            $mobileImageName = time() . '_promo_mobile_' . uniqid() . '.' . $mobileImage->getClientOriginalExtension();
            $uploadPath = public_path('uploads/promotional-banners');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $mobileImage->move($uploadPath, $mobileImageName);
        }
 
        \App\Models\PromotionalBanner::create([
            'background_image'          => $imageName,
            'background_image_alt'      => $request->background_image_alt,
            'background_image_mobile'   => $mobileImageName, // ✅ NEW
            'background_image_mobile_alt' => $request->background_image_mobile_alt, // ✅ NEW
            'sub_heading'               => $request->sub_heading,
            'heading'                   => $request->heading,
            'sale_heading'              => $request->sale_heading,
            'sale_end_date'             => $request->sale_end_date,
            'button_text'               => $request->button_text,
            'button_url'                => $request->button_url,
            'is_active'                 => $request->has('is_active') ? 1 : 0,
        ]);
 
        return redirect()->route('promotional.banner')->with('success', 'Promotional Banner created successfully!');
    } catch (\Exception $e) {
        return redirect()->route('promotional.banner')->with('error', 'Failed to create: ' . $e->getMessage());
    }
}
 
public function promotionalBannerEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $editBanner = \App\Models\PromotionalBanner::findOrFail($id);
    $banner = $editBanner;
    $canAdd = true;
    
    return view('backend.promotional-banner', compact('banner', 'canAdd', 'editBanner'));
}
 
public function promotionalBannerUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
 
    $request->validate([
        'background_image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'background_image_alt'      => 'nullable|string|max:255',
        'background_image_mobile'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // ✅ NEW
        'background_image_mobile_alt' => 'nullable|string|max:255', // ✅ NEW
        'sub_heading'               => 'nullable|string|max:255',
        'heading'                   => 'required|string|max:255',
        'sale_heading'              => 'nullable|string|max:255',
        'sale_end_date'             => 'required|date',
        'button_text'               => 'required|string|max:100',
        'button_url'                => 'required|url|max:500',
    ]);
 
    try {
        $banner = \App\Models\PromotionalBanner::findOrFail($id);
 
        // Handle desktop image upload
        if ($request->hasFile('background_image')) {
            if ($banner->background_image && file_exists(public_path('uploads/promotional-banners/' . $banner->background_image))) {
                unlink(public_path('uploads/promotional-banners/' . $banner->background_image));
            }
            
            $image = $request->file('background_image');
            $imageName = time() . '_promo_desktop_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/promotional-banners');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $image->move($uploadPath, $imageName);
            $banner->background_image = $imageName;
        }
 
        // ✅ NEW - Handle mobile image upload
        if ($request->hasFile('background_image_mobile')) {
            if ($banner->background_image_mobile && file_exists(public_path('uploads/promotional-banners/' . $banner->background_image_mobile))) {
                unlink(public_path('uploads/promotional-banners/' . $banner->background_image_mobile));
            }
            
            $mobileImage = $request->file('background_image_mobile');
            $mobileImageName = time() . '_promo_mobile_' . uniqid() . '.' . $mobileImage->getClientOriginalExtension();
            $uploadPath = public_path('uploads/promotional-banners');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $mobileImage->move($uploadPath, $mobileImageName);
            $banner->background_image_mobile = $mobileImageName;
        }
 
        $banner->background_image_alt = $request->background_image_alt;
        $banner->background_image_mobile_alt = $request->background_image_mobile_alt; // ✅ NEW
        $banner->sub_heading = $request->sub_heading;
        $banner->heading = $request->heading;
        $banner->sale_heading = $request->sale_heading;
        $banner->sale_end_date = $request->sale_end_date;
        $banner->button_text = $request->button_text;
        $banner->button_url = $request->button_url;
        $banner->is_active = $request->has('is_active') ? 1 : 0;
        $banner->save();
 
        return redirect()->route('promotional.banner')->with('success', 'Promotional Banner updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('promotional.banner')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}
 
public function promotionalBannerDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
 
    try {
        $banner = \App\Models\PromotionalBanner::findOrFail($id);
        
        // Delete desktop image file
        if ($banner->background_image && file_exists(public_path('uploads/promotional-banners/' . $banner->background_image))) {
            unlink(public_path('uploads/promotional-banners/' . $banner->background_image));
        }
        
        // ✅ NEW - Delete mobile image file
        if ($banner->background_image_mobile && file_exists(public_path('uploads/promotional-banners/' . $banner->background_image_mobile))) {
            unlink(public_path('uploads/promotional-banners/' . $banner->background_image_mobile));
        }
        
        $banner->delete();
 
        return redirect()->route('promotional.banner')->with('success', 'Promotional Banner deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('promotional.banner')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}





public function homeVideoSection()
{
    if (!Session::has('user_id')) return redirect()->route('login');
    $sections = HomeVideoSection::orderBy('sort_order')->get();
    return view('backend.home-video-section', compact('sections'));
}



public function homeVideoSectionStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
 
    $request->validate([
        'heading'        => 'required|string|max:255',
        'sub_heading'    => 'nullable|string|max:255',
        'view_all_text'  => 'nullable|string|max:100',
        'view_all_url'   => 'nullable|string|max:500',
        'sort_order'     => 'nullable|integer|min:0',
        'videos.*'       => 'nullable|mimes:mp4,webm,ogg,mov,avi|max:102400',
        'thumbnails.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'video_titles.*' => 'nullable|string|max:255',
    ]);
 
    try {
        $videosData = [];
        
        if ($request->hasFile('videos')) {
            $videoPath = public_path('uploads/video-sections');
            $thumbPath = public_path('uploads/video-sections/thumbnails');
            
            // Create directories if they don't exist
            if (!file_exists($videoPath)) {
                mkdir($videoPath, 0755, true);
            }
            if (!file_exists($thumbPath)) {
                mkdir($thumbPath, 0755, true);
            }
 
            foreach ($request->file('videos') as $i => $videoFile) {
    $ext = strtolower($videoFile->getClientOriginalExtension());
    
    // ✅ YE ADD KARO: Browser के लिए mp4 extension force करो
    if (in_array($ext, ['mov', 'avi'])) {
        $ext = 'mp4';
    }
    
    $vName = time() . '_video_' . $i . '_' . uniqid() . '.' . $ext;
    $videoFile->move($videoPath, $vName);
                
                \Log::info('✅ Video uploaded: ' . $vName);
 
                // Handle thumbnail if provided
                $tName = null;
                if ($request->hasFile('thumbnails') && isset($request->file('thumbnails')[$i])) {
                    $thumb = $request->file('thumbnails')[$i];
                    $tName = time() . '_thumb_' . $i . '_' . uniqid() . '.' . $thumb->getClientOriginalExtension();
                    $thumb->move($thumbPath, $tName);
                    
                    \Log::info('✅ Thumbnail uploaded: ' . $tName);
                }
 
                $videosData[] = [
                    'video'     => $vName,
                    'thumbnail' => $tName,
                    'title'     => $request->video_titles[$i] ?? '',
                ];
            }
        }
 
        HomeVideoSection::create([
            'heading'       => $request->heading,
            'sub_heading'   => $request->sub_heading,
            'view_all_text' => $request->view_all_text ?: 'View All',
            'view_all_url'  => $request->view_all_url,
            'videos'        => $videosData,
            'sort_order'    => $request->sort_order ?? 0,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]);
 
        \Log::info('✅ Video section created successfully!');
        return redirect()->route('home.video.section')->with('success', 'Video section created!');
        
    } catch (\Exception $e) {
        \Log::error('❌ Video section creation error: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return redirect()->route('home.video.section')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function homeVideoSectionEdit($id)
{
    if (!Session::has('user_id')) return redirect()->route('login');
    $editSection = HomeVideoSection::findOrFail($id);
    $sections    = HomeVideoSection::orderBy('sort_order')->get();
    return view('backend.home-video-section', compact('sections', 'editSection'));
}

public function homeVideoSectionUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) return redirect()->route('login');
 
    $request->validate([
        'heading'        => 'required|string|max:255',
        'sub_heading'    => 'nullable|string|max:255',
        'view_all_text'  => 'nullable|string|max:100',
        'view_all_url'   => 'nullable|string|max:500',
        'sort_order'     => 'nullable|integer|min:0',
        'videos.*'       => 'nullable|mimes:mp4,webm,ogg,mov,avi|max:102400',
        'thumbnails.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'video_titles.*' => 'nullable|string|max:255',
    ]);
 
    try {
        $section        = HomeVideoSection::findOrFail($id);
        $existingVideos = $section->videos ?? [];
 
        // Keep checked videos, delete unchecked ones
        $keepIndexes    = $request->keep_videos ?? [];
        $filteredVideos = [];
        
        foreach ($existingVideos as $i => $vid) {
            if (in_array((string)$i, array_map('strval', $keepIndexes))) {
                // Update title if changed
                $vid['title'] = $request->existing_titles[$i] ?? $vid['title'];
                $filteredVideos[] = $vid;
            } else {
                // Delete video file
                $vp = public_path('uploads/video-sections/' . $vid['video']);
                if (file_exists($vp)) {
                    unlink($vp);
                    \Log::info('🗑️ Deleted video: ' . $vid['video']);
                }
                
                // Delete thumbnail file if exists
                if (!empty($vid['thumbnail'])) {
                    $tp = public_path('uploads/video-sections/thumbnails/' . $vid['thumbnail']);
                    if (file_exists($tp)) {
                        unlink($tp);
                        \Log::info('🗑️ Deleted thumbnail: ' . $vid['thumbnail']);
                    }
                }
            }
        }
 
        // Add new videos if provided
        if ($request->hasFile('videos')) {
            $videoPath = public_path('uploads/video-sections');
            $thumbPath = public_path('uploads/video-sections/thumbnails');
            
            if (!file_exists($videoPath)) mkdir($videoPath, 0755, true);
            if (!file_exists($thumbPath)) mkdir($thumbPath, 0755, true);
 
            foreach ($request->file('videos') as $i => $videoFile) {
                // ✅ FIX: Convert MOV to mp4
                $ext = strtolower($videoFile->getClientOriginalExtension());
                if (in_array($ext, ['mov', 'avi'])) {
                    $ext = 'mp4';
                }
                
                $vName = time() . '_video_' . $i . '_' . uniqid() . '.' . $ext;
                $videoFile->move($videoPath, $vName);
                
                \Log::info('✅ New video uploaded: ' . $vName);
 
                $tName = null;
                if ($request->hasFile('thumbnails') && isset($request->file('thumbnails')[$i])) {
                    $thumb = $request->file('thumbnails')[$i];
                    $tName = time() . '_thumb_' . $i . '_' . uniqid() . '.' . $thumb->getClientOriginalExtension();
                    $thumb->move($thumbPath, $tName);
                    
                    \Log::info('✅ New thumbnail uploaded: ' . $tName);
                }
 
                $filteredVideos[] = [
                    'video'     => $vName,
                    'thumbnail' => $tName,
                    'title'     => $request->video_titles[$i] ?? '',
                ];
            }
        }
 
        // Update section
        $section->update([
            'heading'       => $request->heading,
            'sub_heading'   => $request->sub_heading,
            'view_all_text' => $request->view_all_text ?: 'View All',
            'view_all_url'  => $request->view_all_url,
            'videos'        => $filteredVideos,
            'sort_order'    => $request->sort_order ?? 0,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]);
 
        \Log::info('✅ Video section updated successfully!');
        return redirect()->route('home.video.section')->with('success', 'Video section updated!');
        
    } catch (\Exception $e) {
        \Log::error('❌ Video section update error: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return redirect()->route('home.video.section')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function homeVideoSectionDelete($id)
{
    if (!Session::has('user_id')) return redirect()->route('login');
    
    try {
        $section = HomeVideoSection::findOrFail($id);
        
        // Delete all video and thumbnail files
        foreach ($section->videos ?? [] as $vid) {
            $vp = public_path('uploads/video-sections/' . $vid['video']);
            if (file_exists($vp)) {
                unlink($vp);
                \Log::info('🗑️ Deleted video file: ' . $vid['video']);
            }
            
            if (!empty($vid['thumbnail'])) {
                $tp = public_path('uploads/video-sections/thumbnails/' . $vid['thumbnail']);
                if (file_exists($tp)) {
                    unlink($tp);
                    \Log::info('🗑️ Deleted thumbnail file: ' . $vid['thumbnail']);
                }
            }
        }
        
        $section->delete();
        
        \Log::info('✅ Video section deleted successfully!');
        return redirect()->route('home.video.section')->with('success', 'Section deleted!');
        
    } catch (\Exception $e) {
        \Log::error('❌ Video section delete error: ' . $e->getMessage());
        return redirect()->route('home.video.section')->with('error', 'Failed: ' . $e->getMessage());
    }
}


// ── ADMIN: List + form ──────────────────────────────────────
public function announcementBar()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    $bar    = AnnouncementBar::first();
    $canAdd = AnnouncementBar::count() < 1;
    return view('backend.announcement-bar', compact('bar', 'canAdd'));
}
 
// ── ADMIN: Store ────────────────────────────────────────────
public function announcementBarStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    if (AnnouncementBar::count() >= 1) {
        return redirect()->route('announcement.bar')->with('error', 'Only one bar allowed!');
    }
    $request->validate([
        'announcements'   => 'required|array|min:1',
        'announcements.*' => 'required|string|max:255',
        'phone_label'     => 'nullable|string|max:100',
        'phone_number'    => 'required|string|max:50',
        'phone_url'       => 'nullable|string|max:255',
        'bg_color'        => 'nullable|string|max:20',
        'text_color'      => 'nullable|string|max:20',
        'slide_interval'  => 'nullable|integer|min:1000|max:10000',
    ]);
    AnnouncementBar::create([
        'announcements'  => array_values(array_filter($request->announcements)),
        'phone_label'    => $request->phone_label    ?? 'Call Us',
        'phone_number'   => $request->phone_number,
        'phone_url'      => $request->phone_url,
        'bg_color'       => $request->bg_color       ?? '#1a1a1a',
        'text_color'     => $request->text_color     ?? '#ffffff',
        'slide_interval' => $request->slide_interval ?? 3000,
        'is_active'      => $request->has('is_active') ? 1 : 0,
    ]);
    return redirect()->route('announcement.bar')->with('success', 'Announcement bar created!');
}
 
// ── ADMIN: Update ───────────────────────────────────────────
public function announcementBarUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    $request->validate([
        'announcements'   => 'required|array|min:1',
        'announcements.*' => 'required|string|max:255',
        'phone_label'     => 'nullable|string|max:100',
        'phone_number'    => 'required|string|max:50',
        'phone_url'       => 'nullable|string|max:255',
        'bg_color'        => 'nullable|string|max:20',
        'text_color'      => 'nullable|string|max:20',
        'slide_interval'  => 'nullable|integer|min:1000|max:10000',
    ]);
    $bar = AnnouncementBar::findOrFail($id);
    $bar->update([
        'announcements'  => array_values(array_filter($request->announcements)),
        'phone_label'    => $request->phone_label    ?? 'Call Us',
        'phone_number'   => $request->phone_number,
        'phone_url'      => $request->phone_url,
        'bg_color'       => $request->bg_color       ?? '#1a1a1a',
        'text_color'     => $request->text_color     ?? '#ffffff',
        'slide_interval' => $request->slide_interval ?? 3000,
        'is_active'      => $request->has('is_active') ? 1 : 0,
    ]);
    return redirect()->route('announcement.bar')->with('success', 'Announcement bar updated!');
}
 
// ── ADMIN: Delete ───────────────────────────────────────────
public function announcementBarDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    AnnouncementBar::findOrFail($id)->delete();
    return redirect()->route('announcement.bar')->with('success', 'Deleted!');
}



// ============================================
// DISCOUNT MANAGEMENT
// ============================================

public function discount()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $discounts = Discount::with(['rule', 'usages'])
                ->orderBy('created_at', 'desc')
                ->get();
    
    return view('backend.discount', compact('discounts'));
}

public function discountCreate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $products    = Product::where('status', 'published')->get();
    $collections = ProductCategory::where('is_active', 1)->get();
    
    return view('backend.discount-create', compact('products', 'collections'));
}

public function discountStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'title'      => 'required|string|max:255',
        'type'       => 'required|in:amount_off_products,buy_x_get_y,amount_off_order,free_shipping',
        'method'     => 'required|in:discount_code,automatic',
        'code'       => 'nullable|string|max:100|unique:discounts,code',
        'value_type' => 'nullable|in:percentage,fixed',
        'value'      => 'nullable|numeric|min:0',
        'starts_at'  => 'nullable|date',
        'ends_at'    => 'nullable|date|after:starts_at',
    ]);

    try {
        // Main discount create karo
        $discount = Discount::create([
            'title'      => $request->title,
            'code'       => $request->method === 'discount_code' ? strtoupper($request->code) : null,
            'type'       => $request->type,
            'method'     => $request->method,
            'value_type' => $request->value_type,
            'value'      => $request->value ?? 0,
            'is_active'  => 1,
            'starts_at'  => $request->starts_at,
            'ends_at'    => $request->ends_at,
        ]);

        // Rules save karo
        DiscountRule::create([
            'discount_id'                => $discount->id,
            'eligibility'                => $request->eligibility ?? 'all_customers',
            'min_requirement'            => $request->min_requirement ?? 'none',
            'min_amount'                 => $request->min_amount,
            'min_quantity'               => $request->min_quantity,
            'max_uses_total'             => $request->max_uses_total,
            'max_uses_per_customer'      => $request->max_uses_per_customer,
            'applies_to'                 => $request->applies_to ?? 'all_products',
            'combine_product_discounts'  => $request->has('combine_product_discounts') ? 1 : 0,
            'combine_order_discounts'    => $request->has('combine_order_discounts') ? 1 : 0,
            'combine_shipping_discounts' => $request->has('combine_shipping_discounts') ? 1 : 0,
            'all_countries'              => $request->has('all_countries') ? 1 : 0,
            'exclude_shipping_over'      => $request->exclude_shipping_over,
        ]);

        // Buy X Get Y rules save karo
        if ($request->type === 'buy_x_get_y') {
            DiscountBxgy::create([
                'discount_id'       => $discount->id,
                'buy_type'          => $request->buy_type ?? 'min_quantity',
                'buy_quantity'      => $request->buy_quantity,
                'buy_amount'        => $request->buy_amount,
                'buy_from'          => $request->buy_from ?? 'any_items',
                'get_quantity'      => $request->get_quantity ?? 1,
                'get_from'          => $request->get_from ?? 'any_items',
                'get_value_type'    => $request->get_value_type ?? 'free',
                'get_value'         => $request->get_value ?? 0,
                'max_uses_per_order'=> $request->max_uses_per_order,
            ]);
        }

        // Products/Collections link karo
        if ($request->has('product_ids') && is_array($request->product_ids)) {
            foreach ($request->product_ids as $productId) {
                DiscountProduct::create([
                    'discount_id'  => $discount->id,
                    'type'         => 'applies_to',
                    'product_type' => 'product',
                    'product_id'   => $productId,
                ]);
            }
        }

        if ($request->has('collection_ids') && is_array($request->collection_ids)) {
            foreach ($request->collection_ids as $collectionId) {
                DiscountProduct::create([
                    'discount_id'  => $discount->id,
                    'type'         => 'applies_to',
                    'product_type' => 'collection',
                    'product_id'   => $collectionId,
                ]);
            }
        }

        // Buy X Get Y - buy products
        if ($request->has('buy_product_ids') && is_array($request->buy_product_ids)) {
            foreach ($request->buy_product_ids as $productId) {
                DiscountProduct::create([
                    'discount_id'  => $discount->id,
                    'type'         => 'buy',
                    'product_type' => 'product',
                    'product_id'   => $productId,
                ]);
            }
        }

        // Buy X Get Y - get products
        if ($request->has('get_product_ids') && is_array($request->get_product_ids)) {
            foreach ($request->get_product_ids as $productId) {
                DiscountProduct::create([
                    'discount_id'  => $discount->id,
                    'type'         => 'get',
                    'product_type' => 'product',
                    'product_id'   => $productId,
                ]);
            }
        }

        return redirect()->route('discount.index')->with('success', 'Discount created successfully!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed: ' . $e->getMessage())->withInput();
    }
}

public function discountEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $discount    = Discount::with(['rule', 'bxgy', 'products'])->findOrFail($id);
    $discounts   = Discount::with(['rule', 'usages'])->orderBy('created_at', 'desc')->get();
    $products    = Product::where('status', 'published')->get();
    $collections = ProductCategory::where('is_active', 1)->get();
    
    return view('backend.discount', compact('discounts', 'discount', 'products', 'collections'));
}

public function discountUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'title'      => 'required|string|max:255',
        'type'       => 'required|in:amount_off_products,buy_x_get_y,amount_off_order,free_shipping',
        'method'     => 'required|in:discount_code,automatic',
        'code'       => 'nullable|string|max:100|unique:discounts,code,' . $id,
        'value_type' => 'nullable|in:percentage,fixed',
        'value'      => 'nullable|numeric|min:0',
        'starts_at'  => 'nullable|date',
        'ends_at'    => 'nullable|date|after:starts_at',
    ]);

    try {
        $discount = Discount::findOrFail($id);

        $discount->update([
            'title'      => $request->title,
            'code'       => $request->method === 'discount_code' ? strtoupper($request->code) : null,
            'type'       => $request->type,
            'method'     => $request->method,
            'value_type' => $request->value_type,
            'value'      => $request->value ?? 0,
            'starts_at'  => $request->starts_at,
            'ends_at'    => $request->ends_at,
        ]);

        // Rule update karo
        DiscountRule::updateOrCreate(
            ['discount_id' => $discount->id],
            [
                'eligibility'                => $request->eligibility ?? 'all_customers',
                'min_requirement'            => $request->min_requirement ?? 'none',
                'min_amount'                 => $request->min_amount,
                'min_quantity'               => $request->min_quantity,
                'max_uses_total'             => $request->max_uses_total,
                'max_uses_per_customer'      => $request->max_uses_per_customer,
                'applies_to'                 => $request->applies_to ?? 'all_products',
                'combine_product_discounts'  => $request->has('combine_product_discounts') ? 1 : 0,
                'combine_order_discounts'    => $request->has('combine_order_discounts') ? 1 : 0,
                'combine_shipping_discounts' => $request->has('combine_shipping_discounts') ? 1 : 0,
                'all_countries'              => $request->has('all_countries') ? 1 : 0,
                'exclude_shipping_over'      => $request->exclude_shipping_over,
            ]
        );

        // BXGY update karo
        if ($request->type === 'buy_x_get_y') {
            DiscountBxgy::updateOrCreate(
                ['discount_id' => $discount->id],
                [
                    'buy_type'           => $request->buy_type ?? 'min_quantity',
                    'buy_quantity'       => $request->buy_quantity,
                    'buy_amount'         => $request->buy_amount,
                    'buy_from'           => $request->buy_from ?? 'any_items',
                    'get_quantity'       => $request->get_quantity ?? 1,
                    'get_from'           => $request->get_from ?? 'any_items',
                    'get_value_type'     => $request->get_value_type ?? 'free',
                    'get_value'          => $request->get_value ?? 0,
                    'max_uses_per_order' => $request->max_uses_per_order,
                ]
            );
        }

        // Products refresh karo
        $discount->products()->delete();

        if ($request->has('product_ids')) {
            foreach ($request->product_ids as $productId) {
                DiscountProduct::create([
                    'discount_id'  => $discount->id,
                    'type'         => 'applies_to',
                    'product_type' => 'product',
                    'product_id'   => $productId,
                ]);
            }
        }

        if ($request->has('collection_ids')) {
            foreach ($request->collection_ids as $collectionId) {
                DiscountProduct::create([
                    'discount_id'  => $discount->id,
                    'type'         => 'applies_to',
                    'product_type' => 'collection',
                    'product_id'   => $collectionId,
                ]);
            }
        }

        return redirect()->route('discount.index')->with('success', 'Discount updated successfully!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed: ' . $e->getMessage())->withInput();
    }
}

public function discountToggle($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $discount = Discount::findOrFail($id);
        $discount->is_active = !$discount->is_active;
        $discount->save();

        $status = $discount->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Discount {$status} successfully!");

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function discountDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $discount = Discount::findOrFail($id);
        $discount->products()->delete();
        $discount->usages()->delete();
        $discount->rule()->delete();
        $discount->bxgy()->delete();
        $discount->delete();

        return redirect()->route('discount.index')->with('success', 'Discount deleted successfully!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed: ' . $e->getMessage());
    }
}




// ============================================
// SHIPPING ZONES MANAGEMENT
// ============================================

public function shippingZone()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $zones = ShippingZone::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
    return view('backend.shipping-zone', compact('zones'));
}

public function shippingZoneStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'name'          => 'required|string|max:255',
        'countries_text' => 'nullable|string',
        'sort_order'    => 'nullable|integer|min:0',
    ]);

    try {
        $countries = [];
        if ($request->filled('countries_text')) {
            $countries = array_values(array_filter(array_map('trim', explode(',', $request->countries_text))));
        }

        ShippingZone::create([
            'name'       => $request->name,
            'countries'  => $countries,
            'is_active'  => $request->has('is_active') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('shipping.zone')->with('success', 'Shipping zone created successfully!');
    } catch (\Exception $e) {
        return redirect()->route('shipping.zone')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function shippingZoneEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $editZone = ShippingZone::findOrFail($id);
    $zones    = ShippingZone::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
    
    return view('backend.shipping-zone', compact('zones', 'editZone'));
}

public function shippingZoneUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'name'           => 'required|string|max:255',
        'countries_text' => 'nullable|string',
        'sort_order'     => 'nullable|integer|min:0',
    ]);

    try {
        $zone = ShippingZone::findOrFail($id);

        $countries = [];
        if ($request->filled('countries_text')) {
            $countries = array_values(array_filter(array_map('trim', explode(',', $request->countries_text))));
        }

        $zone->update([
            'name'       => $request->name,
            'countries'  => $countries,
            'is_active'  => $request->has('is_active') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('shipping.zone')->with('success', 'Shipping zone updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('shipping.zone')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function shippingZoneDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $zone = ShippingZone::findOrFail($id);
        
        // Check if zone has rates
        if ($zone->rates()->count() > 0) {
            return redirect()->route('shipping.zone')
                ->with('error', 'Cannot delete! This zone has shipping rates. Delete them first.');
        }
        
        $zone->delete();

        return redirect()->route('shipping.zone')->with('success', 'Shipping zone deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('shipping.zone')->with('error', 'Failed: ' . $e->getMessage());
    }
}

// ============================================
// SHIPPING METHODS MANAGEMENT
// ============================================

public function shippingMethod()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $methods = ShippingMethod::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
    return view('backend.shipping-method', compact('methods'));
}

public function shippingMethodStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'name'          => 'required|string|max:255',
        'description'   => 'nullable|string',
        'delivery_time' => 'nullable|string|max:100',
        'sort_order'    => 'nullable|integer|min:0',
    ]);

    try {
        ShippingMethod::create([
            'name'          => $request->name,
            'description'   => $request->description,
            'delivery_time' => $request->delivery_time,
            'is_active'     => $request->has('is_active') ? 1 : 0,
            'sort_order'    => $request->sort_order ?? 0,
        ]);

        return redirect()->route('shipping.method')->with('success', 'Shipping method created successfully!');
    } catch (\Exception $e) {
        return redirect()->route('shipping.method')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function shippingMethodEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $editMethod = ShippingMethod::findOrFail($id);
    $methods    = ShippingMethod::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
    
    return view('backend.shipping-method', compact('methods', 'editMethod'));
}

public function shippingMethodUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'name'          => 'required|string|max:255',
        'description'   => 'nullable|string',
        'delivery_time' => 'nullable|string|max:100',
        'sort_order'    => 'nullable|integer|min:0',
    ]);

    try {
        $method = ShippingMethod::findOrFail($id);
        
        $method->update([
            'name'          => $request->name,
            'description'   => $request->description,
            'delivery_time' => $request->delivery_time,
            'is_active'     => $request->has('is_active') ? 1 : 0,
            'sort_order'    => $request->sort_order ?? 0,
        ]);

        return redirect()->route('shipping.method')->with('success', 'Shipping method updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('shipping.method')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function shippingMethodDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $method = ShippingMethod::findOrFail($id);
        
        // Check if method has rates
        if ($method->rates()->count() > 0) {
            return redirect()->route('shipping.method')
                ->with('error', 'Cannot delete! This method has shipping rates. Delete them first.');
        }
        
        $method->delete();

        return redirect()->route('shipping.method')->with('success', 'Shipping method deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('shipping.method')->with('error', 'Failed: ' . $e->getMessage());
    }
}

// ============================================
// SHIPPING RATES MANAGEMENT
// ============================================

public function shippingRate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $rates   = ShippingRate::with(['zone', 'method'])->orderBy('created_at', 'desc')->get();
    $zones   = ShippingZone::where('is_active', 1)->orderBy('name')->get();
    $methods = ShippingMethod::where('is_active', 1)->orderBy('name')->get();
    
    return view('backend.shipping-rate', compact('rates', 'zones', 'methods'));
}

public function shippingRateStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'zone_id'        => 'required|exists:shipping_zones,id',
        'method_id'      => 'required|exists:shipping_methods,id',
        'rate_type'      => 'required|in:flat_rate,weight_based,cart_value,free',
        'base_rate'      => 'required|numeric|min:0',
        'min_cart_value' => 'nullable|numeric|min:0',
        'weight_from'    => 'nullable|numeric|min:0',
        'weight_to'      => 'nullable|numeric|min:0',
        'per_kg_rate'    => 'nullable|numeric|min:0',
        'cod_charge'     => 'nullable|numeric|min:0',
    ]);

    try {
        ShippingRate::create([
            'zone_id'        => $request->zone_id,
            'method_id'      => $request->method_id,
            'rate_type'      => $request->rate_type,
            'base_rate'      => $request->base_rate,
            'min_cart_value' => $request->min_cart_value,
            'weight_from'    => $request->weight_from,
            'weight_to'      => $request->weight_to,
            'per_kg_rate'    => $request->per_kg_rate,
            'cod_available'  => $request->has('cod_available') ? 1 : 0,
            'cod_charge'     => $request->cod_charge ?? 0,
            'is_active'      => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('shipping.rate')->with('success', 'Shipping rate created successfully!');
    } catch (\Exception $e) {
        return redirect()->route('shipping.rate')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function shippingRateEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $editRate = ShippingRate::with(['zone', 'method'])->findOrFail($id);
    $rates    = ShippingRate::with(['zone', 'method'])->orderBy('created_at', 'desc')->get();
    $zones    = ShippingZone::where('is_active', 1)->orderBy('name')->get();
    $methods  = ShippingMethod::where('is_active', 1)->orderBy('name')->get();
    
    return view('backend.shipping-rate', compact('rates', 'zones', 'methods', 'editRate'));
}

public function shippingRateUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'zone_id'        => 'required|exists:shipping_zones,id',
        'method_id'      => 'required|exists:shipping_methods,id',
        'rate_type'      => 'required|in:flat_rate,weight_based,cart_value,free',
        'base_rate'      => 'required|numeric|min:0',
        'min_cart_value' => 'nullable|numeric|min:0',
        'weight_from'    => 'nullable|numeric|min:0',
        'weight_to'      => 'nullable|numeric|min:0',
        'per_kg_rate'    => 'nullable|numeric|min:0',
        'cod_charge'     => 'nullable|numeric|min:0',
    ]);

    try {
        $rate = ShippingRate::findOrFail($id);
        
        $rate->update([
            'zone_id'        => $request->zone_id,
            'method_id'      => $request->method_id,
            'rate_type'      => $request->rate_type,
            'base_rate'      => $request->base_rate,
            'min_cart_value' => $request->min_cart_value,
            'weight_from'    => $request->weight_from,
            'weight_to'      => $request->weight_to,
            'per_kg_rate'    => $request->per_kg_rate,
            'cod_available'  => $request->has('cod_available') ? 1 : 0,
            'cod_charge'     => $request->cod_charge ?? 0,
            'is_active'      => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('shipping.rate')->with('success', 'Shipping rate updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('shipping.rate')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function shippingRateDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $rate = ShippingRate::findOrFail($id);
        $rate->delete();

        return redirect()->route('shipping.rate')->with('success', 'Shipping rate deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('shipping.rate')->with('error', 'Failed: ' . $e->getMessage());
    }
}


// ============================================
// CONTACT US MANAGEMENT
// ============================================

public function contactUs()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $contactUs = \App\Models\ContactUs::first();
    $canAdd = \App\Models\ContactUs::count() < 1;
    
    return view('backend.contact-us', compact('contactUs', 'canAdd'));
}

public function contactUsStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    if (\App\Models\ContactUs::count() >= 1) {
        return redirect()->route('contact.us')->with('error', 'Only one record allowed!');
    }

    $request->validate([
        'page_heading' => 'nullable|string|max:255',
        'pre_heading'  => 'nullable|string|max:255',
        'sub_heading'  => 'nullable|string',
        'phone'        => 'nullable|string|max:50',
        'email'        => 'nullable|string|max:255',
        'address'      => 'nullable|string',
        'map_embed'    => 'nullable|string',
        'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'image_alt'    => 'nullable|string|max:255',
    ]);

    try {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/contact-us');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $image->move($uploadPath, $imageName);
        }

        \App\Models\ContactUs::create([
            'page_heading' => $request->page_heading,
            'pre_heading'  => $request->pre_heading,
            'sub_heading'  => $request->sub_heading,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'address'      => $request->address,
            'map_embed'    => $request->map_embed,
            'image'        => $imageName,
            'image_alt'    => $request->image_alt,
        ]);

        return redirect()->route('contact.us')->with('success', 'Contact Us saved successfully!');
    } catch (\Exception $e) {
        return redirect()->route('contact.us')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function contactUsUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'page_heading' => 'nullable|string|max:255',
        'pre_heading'  => 'nullable|string|max:255',
        'sub_heading'  => 'nullable|string',
        'phone'        => 'nullable|string|max:50',
        'email'        => 'nullable|string|max:255',
        'address'      => 'nullable|string',
        'map_embed'    => 'nullable|string',
        'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'image_alt'    => 'nullable|string|max:255',
    ]);

    try {
        $contactUs = \App\Models\ContactUs::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($contactUs->image && file_exists(public_path('uploads/contact-us/' . $contactUs->image))) {
                unlink(public_path('uploads/contact-us/' . $contactUs->image));
            }
            $image     = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads/contact-us');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $image->move($uploadPath, $imageName);
            $contactUs->image = $imageName;
        }

        $contactUs->page_heading = $request->page_heading;
        $contactUs->pre_heading  = $request->pre_heading;
        $contactUs->sub_heading  = $request->sub_heading;
        $contactUs->phone        = $request->phone;
        $contactUs->email        = $request->email;
        $contactUs->address      = $request->address;
        $contactUs->map_embed    = $request->map_embed;
        $contactUs->image_alt    = $request->image_alt;
        $contactUs->save();

        return redirect()->route('contact.us')->with('success', 'Contact Us updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('contact.us')->with('error', 'Failed: ' . $e->getMessage());
    }
}

public function contactUsDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $contactUs = \App\Models\ContactUs::findOrFail($id);
        
        if ($contactUs->image && file_exists(public_path('uploads/contact-us/' . $contactUs->image))) {
            unlink(public_path('uploads/contact-us/' . $contactUs->image));
        }
        
        $contactUs->delete();

        return redirect()->route('contact.us')->with('success', 'Deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('contact.us')->with('error', 'Failed: ' . $e->getMessage());
    }
}

// ============================================
// FAQ MANAGEMENT
// ============================================

public function faq()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $faqs = Faq::orderBy('created_at', 'desc')->get();
    $faqCount = Faq::count();
    return view('backend.faq', compact('faqs', 'faqCount'));
}



public function faqEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $faq = Faq::findOrFail($id);
    $faqs = Faq::orderBy('created_at', 'desc')->get();
    $faqCount = Faq::count();
    
    return view('backend.faq', [
        'faqs' => $faqs,
        'editFaq' => $faq,
        'faqCount' => $faqCount
    ]);
}

public function faqStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    try {
        Faq::create([
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()->route('faq')->with('success', 'FAQ added successfully!');
    } catch (\Exception $e) {
        return redirect()->route('faq')->with('error', 'Failed to add: ' . $e->getMessage());
    }
}

public function faqUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $request->validate([
        'heading' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    try {
        $faq = Faq::findOrFail($id);
        $faq->update([
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()->route('faq')->with('success', 'FAQ updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('faq')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}

public function faqDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    try {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('faq')->with('success', 'FAQ deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('faq')->with('error', 'Failed to delete: ' . $e->getMessage());
    }
}


public function gallery()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $galleries = Gallery::with('media')
                        ->orderBy('created_at', 'desc')
                        ->get();
    
    return view('backend.gallery', compact('galleries'));
}
 
/**
 * ✅ Gallery create page
 */
public function galleryCreate()
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    // ✅ YE ADD KARO:
    $galleries = Gallery::with('media')->orderBy('created_at', 'desc')->get();
    
    return view('backend.gallery', compact('galleries'));
}
 
/**
 * ✅ Gallery store (create new gallery)
 */
public function galleryStore(Request $request)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
 
    $request->validate([
        'title'              => 'required|string|max:255',
        'slug'               => 'nullable|string|max:255|unique:galleries,slug',
        'description'        => 'nullable|string',
        'media_type'         => 'nullable|in:image,video',
        'images.*'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        'videos.*'           => 'nullable|mimes:mp4,webm,ogg,mov,avi',
        'image_alts.*'       => 'nullable|string|max:255',
        'image_titles.*'     => 'nullable|string|max:255',
        'video_titles.*'     => 'nullable|string|max:255',
        'video_thumbnails.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
    ]);
 
    try {
        $slug = $request->slug
            ? \Illuminate\Support\Str::slug($request->slug)
            : Gallery::generateUniqueSlug($request->title);
 
        $gallery = Gallery::create([
            'title'       => $request->title,
            'slug'        => $slug,
            'description' => $request->description,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ]);
 
        // ✅ Upload Images
        if ($request->media_type === 'image' && $request->hasFile('images')) {
            $imagesPath     = public_path('uploads/gallery/images');
            $thumbnailsPath = public_path('uploads/gallery/thumbnails');
 
            if (!file_exists($imagesPath))     mkdir($imagesPath,     0755, true);
            if (!file_exists($thumbnailsPath)) mkdir($thumbnailsPath, 0755, true);
 
            foreach ($request->file('images') as $i => $imageFile) {
                $ext       = $imageFile->getClientOriginalExtension();
                $imageName = time() . '_gallery_img_' . $i . '_' . uniqid() . '.' . $ext;
 
                $imageFile->move($imagesPath, $imageName);
 
                GalleryMedia::create([
                    'gallery_id' => $gallery->id,
                    'media_type' => 'image',
                    'file_name'  => $imageName,
                    'thumbnail'  => null,
                    'alt_tag'    => $request->image_alts[$i]   ?? '',
                    'title'      => $request->image_titles[$i] ?? '',
                    'sort_order' => $i,
                ]);
            }
        }
 
        // ✅ Upload Videos
        if ($request->media_type === 'video' && $request->hasFile('videos')) {
            $videosPath     = public_path('uploads/gallery/videos');
            $thumbnailsPath = public_path('uploads/gallery/thumbnails');
 
            if (!file_exists($videosPath))     mkdir($videosPath,     0755, true);
            if (!file_exists($thumbnailsPath)) mkdir($thumbnailsPath, 0755, true);
 
            foreach ($request->file('videos') as $i => $videoFile) {
                $ext = strtolower($videoFile->getClientOriginalExtension());
                if (in_array($ext, ['mov', 'avi'])) $ext = 'mp4';
 
                $videoName = time() . '_gallery_vid_' . $i . '_' . uniqid() . '.' . $ext;
                $videoFile->move($videosPath, $videoName);
 
                $thumbnailName = null;
                if ($request->hasFile('video_thumbnails') && isset($request->file('video_thumbnails')[$i])) {
                    $thumbFile     = $request->file('video_thumbnails')[$i];
                    $thumbnailName = time() . '_video_thumb_' . $i . '_' . uniqid() . '.' . $thumbFile->getClientOriginalExtension();
                    $thumbFile->move($thumbnailsPath, $thumbnailName);
                }
 
                GalleryMedia::create([
                    'gallery_id' => $gallery->id,
                    'media_type' => 'video',
                    'file_name'  => $videoName,
                    'thumbnail'  => $thumbnailName,
                    'alt_tag'    => '',
                    'title'      => $request->video_titles[$i] ?? '',
                    'sort_order' => $i,
                ]);
            }
        }
 
        return redirect()->route('gallery.index')->with('success', 'Gallery created successfully!');
 
    } catch (\Exception $e) {
        \Log::error('❌ Gallery creation failed: ' . $e->getMessage());
        return redirect()->route('gallery.index')->with('error', 'Failed: ' . $e->getMessage());
    }
}
 
/**
 * ✅ Gallery edit page
 */
public function galleryEdit($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
    
    $gallery   = Gallery::with('media')->findOrFail($id);
    $galleries = Gallery::with('media')->orderBy('created_at', 'desc')->get();
    
    return view('backend.gallery', compact('gallery', 'galleries'));
}
 
/**
 * ✅ Gallery update
 */
public function galleryUpdate(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
 
    $request->validate([
        'title'              => 'required|string|max:255',
        'slug'               => 'nullable|string|max:255|unique:galleries,slug,' . $id,
        'description'        => 'nullable|string',
        'media_type'         => 'nullable|in:image,video',
        'images.*'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        'videos.*'           => 'nullable|mimes:mp4,webm,ogg,mov,avi',
        'image_alts.*'       => 'nullable|string|max:255',
        'image_titles.*'     => 'nullable|string|max:255',
        'video_titles.*'     => 'nullable|string|max:255',
        'video_thumbnails.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
    ]);
 
    try {
        $gallery = Gallery::findOrFail($id);
 
        $slug = $request->slug
            ? \Illuminate\Support\Str::slug($request->slug)
            : $gallery->slug;
 
        $gallery->update([
            'title'       => $request->title,
            'slug'        => $slug,
            'description' => $request->description,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ]);
 
        // ✅ Upload New Images (only if media_type = image)
        if ($request->media_type === 'image' && $request->hasFile('images')) {
            $imagesPath     = public_path('uploads/gallery/images');
            $thumbnailsPath = public_path('uploads/gallery/thumbnails');
 
            if (!file_exists($imagesPath))     mkdir($imagesPath,     0755, true);
            if (!file_exists($thumbnailsPath)) mkdir($thumbnailsPath, 0755, true);
 
            $maxSort = $gallery->media()->max('sort_order') ?? 0;
 
            foreach ($request->file('images') as $i => $imageFile) {
                $ext       = $imageFile->getClientOriginalExtension();
                $imageName = time() . '_gallery_img_' . $i . '_' . uniqid() . '.' . $ext;
 
                // ✅ FIX: Move karo original file ko images folder mein
                $imageFile->move($imagesPath, $imageName);
 
                // ✅ FIX: Thumbnail ke liye copy karo (original move ho chuki, isliye same naam use karo)
                // Thumbnail alag folder mein same file naam se track karein
                $thumbnailName = $imageName; // Same file naam, alag folder concept
 
                GalleryMedia::create([
                    'gallery_id' => $gallery->id,
                    'media_type' => 'image',
                    'file_name'  => $imageName,
                    'thumbnail'  => null, // Image ke liye thumbnail = null (file_url se serve hogi)
                    'alt_tag'    => $request->image_alts[$i]   ?? '',
                    'title'      => $request->image_titles[$i] ?? '',
                    'sort_order' => $maxSort + $i + 1,
                ]);
 
                \Log::info('✅ Image uploaded: ' . $imageName);
            }
        }
 
        // ✅ Upload New Videos (only if media_type = video)
        if ($request->media_type === 'video' && $request->hasFile('videos')) {
            $videosPath     = public_path('uploads/gallery/videos');
            $thumbnailsPath = public_path('uploads/gallery/thumbnails');
 
            if (!file_exists($videosPath))     mkdir($videosPath,     0755, true);
            if (!file_exists($thumbnailsPath)) mkdir($thumbnailsPath, 0755, true);
 
            $maxSort = $gallery->media()->max('sort_order') ?? 0;
 
            foreach ($request->file('videos') as $i => $videoFile) {
                $ext = strtolower($videoFile->getClientOriginalExtension());
 
                // Browser support ke liye mp4 force karo
                if (in_array($ext, ['mov', 'avi'])) {
                    $ext = 'mp4';
                }
 
                $videoName = time() . '_gallery_vid_' . $i . '_' . uniqid() . '.' . $ext;
                $videoFile->move($videosPath, $videoName);
 
                // Video thumbnail (optional)
                $thumbnailName = null;
                if ($request->hasFile('video_thumbnails') && isset($request->file('video_thumbnails')[$i])) {
                    $thumbFile     = $request->file('video_thumbnails')[$i];
                    $thumbnailName = time() . '_video_thumb_' . $i . '_' . uniqid() . '.' . $thumbFile->getClientOriginalExtension();
                    $thumbFile->move($thumbnailsPath, $thumbnailName);
                }
 
                GalleryMedia::create([
                    'gallery_id' => $gallery->id,
                    'media_type' => 'video',
                    'file_name'  => $videoName,
                    'thumbnail'  => $thumbnailName,
                    'alt_tag'    => '',
                    'title'      => $request->video_titles[$i] ?? '',
                    'sort_order' => $maxSort + $i + 1,
                ]);
 
                \Log::info('✅ Video uploaded: ' . $videoName);
            }
        }
 
        return redirect()->route('gallery.edit', $id)->with('success', 'Gallery updated successfully!');
 
    } catch (\Exception $e) {
        \Log::error('❌ Gallery update failed: ' . $e->getMessage());
        return redirect()->route('gallery.edit', $id)->with('error', 'Failed: ' . $e->getMessage());
    }
}
 
/**
 * ✅ Delete single media item (AJAX)
 */
public function galleryDeleteMedia($id)
{
    if (!Session::has('user_id')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
 
    try {
        $media = GalleryMedia::findOrFail($id);
        $galleryId = $media->gallery_id;
 
        // Delete files
        if ($media->media_type === 'image') {
            $filePath = public_path('uploads/gallery/images/' . $media->file_name);
            if (file_exists($filePath)) unlink($filePath);
        } else {
            $filePath = public_path('uploads/gallery/videos/' . $media->file_name);
            if (file_exists($filePath)) unlink($filePath);
        }
 
        // Delete thumbnail
        if ($media->thumbnail) {
            $thumbPath = public_path('uploads/gallery/thumbnails/' . $media->thumbnail);
            if (file_exists($thumbPath)) unlink($thumbPath);
        }
 
        $media->delete();
 
        \Log::info('✅ Media deleted: ' . $media->file_name);
 
        return response()->json([
            'success' => true,
            'message' => 'Media deleted successfully'
        ]);
 
    } catch (\Exception $e) {
        \Log::error('❌ Media delete failed: ' . $e->getMessage());
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}
 
/**
 * ✅ Delete entire gallery
 */
public function galleryDelete($id)
{
    if (!Session::has('user_id')) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
 
    try {
        $gallery = Gallery::findOrFail($id);
 
        // Delete all media files
        foreach ($gallery->media as $media) {
            if ($media->media_type === 'image') {
                $filePath = public_path('uploads/gallery/images/' . $media->file_name);
                if (file_exists($filePath)) unlink($filePath);
            } else {
                $filePath = public_path('uploads/gallery/videos/' . $media->file_name);
                if (file_exists($filePath)) unlink($filePath);
            }
 
            if ($media->thumbnail) {
                $thumbPath = public_path('uploads/gallery/thumbnails/' . $media->thumbnail);
                if (file_exists($thumbPath)) unlink($thumbPath);
            }
        }
 
        $gallery->delete();
 
        return redirect()->route('gallery.index')->with('success', 'Gallery deleted successfully!');
 
    } catch (\Exception $e) {
        \Log::error('❌ Gallery delete failed: ' . $e->getMessage());
        return redirect()->route('gallery.index')->with('error', 'Failed: ' . $e->getMessage());
    }
}
 
/**
 * ✅ Update media sort order (AJAX drag-drop)
 */
public function gallerySortMedia(Request $request)
{
    if (!Session::has('user_id')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
 
    try {
        $request->validate([
            'media_ids'   => 'required|array',
            'media_ids.*' => 'integer|exists:gallery_media,id',
        ]);
 
        foreach ($request->media_ids as $index => $mediaId) {
            GalleryMedia::where('id', $mediaId)->update(['sort_order' => $index]);
        }
 
        return response()->json([
            'success' => true,
            'message' => 'Media order updated'
        ]);
 
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
 
/**
 * ✅ Update media title/alt (AJAX inline edit)
 */
public function galleryUpdateMediaInfo(Request $request, $id)
{
    if (!Session::has('user_id')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
 
    try {
        $request->validate([
            'title'   => 'nullable|string|max:255',
            'alt_tag' => 'nullable|string|max:255',
        ]);
 
        $media = GalleryMedia::findOrFail($id);
        $media->update([
            'title'   => $request->title,
            'alt_tag' => $request->alt_tag,
        ]);
 
        return response()->json([
            'success' => true,
            'message' => 'Media info updated'
        ]);
 
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



    public function logout()
    {
        Session::flush();
        return redirect('/admin');
    }
	
	
}
