<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Blog;
use App\Models\Offer;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\CityAlert;
use App\Http\Resources\BlogResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminContentController extends BaseApiController
{
    /**
     * Settings
     */
    public function getSettings() { return $this->sendSuccess(Setting::all()->pluck('value', 'key')); }
    public function updateSettings(Request $request) {
        foreach ($request->all() as $key => $value) { Setting::set($key, $value); }
        return $this->sendSuccess([], 'Settings updated');
    }

    /**
     * Blogs
     */
    public function blogs(Request $request) {
        $query = Blog::latest();
        if ($request->filled('published')) $query->where('is_published', $request->published === 'true');
        return BlogResource::collection($query->paginate($request->get('limit', 15)))->additional(['status' => 'success']);
    }
    public function storeBlog(Request $request) {
        $validator = Validator::make($request->all(), ['title' => 'required', 'slug' => 'required|unique:blogs,slug', 'content' => 'required']);
        if ($validator->fails()) return $this->sendError('Validation failed', $validator->errors(), 422);
        $data = $request->all();
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('blogs', 'public');
        $blog = Blog::create($data);
        return $this->sendSuccess(new BlogResource($blog), 'Blog created', 201);
    }
    public function updateBlog(Request $request, $id) {
        $blog = Blog::find($id);
        if (!$blog) return $this->sendError('Blog not found');
        $data = $request->all();
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('blogs', 'public');
        $blog->update($data);
        return $this->sendSuccess(new BlogResource($blog), 'Blog updated');
    }
    public function destroyBlog($id) {
        $blog = Blog::find($id);
        if (!$blog) return $this->sendError('Blog not found');
        $blog->delete();
        return $this->sendSuccess([], 'Blog deleted');
    }

    /**
     * Offers
     */
    public function offers(Request $request) {
        $query = Offer::latest();
        if ($request->filled('is_active')) $query->where('is_active', $request->is_active === 'true');
        return $this->sendSuccess($query->get());
    }
    public function storeOffer(Request $request) {
        $validator = Validator::make($request->all(), ['title' => 'required', 'description' => 'required']);
        if ($validator->fails()) return $this->sendError('Validation failed', $validator->errors(), 422);
        $data = $request->all();
        if ($request->hasFile('image')) $data['image_path'] = $request->file('image')->store('offers', 'public');
        $offer = Offer::create($data);
        return $this->sendSuccess($offer, 'Offer created', 201);
    }
    public function updateOffer(Request $request, $id) {
        $offer = Offer::find($id);
        if (!$offer) return $this->sendError('Offer not found');
        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($offer->image_path) Storage::disk('public')->delete($offer->image_path);
            $data['image_path'] = $request->file('image')->store('offers', 'public');
        }
        $offer->update($data);
        return $this->sendSuccess($offer, 'Offer updated');
    }
    public function toggleOffer($id) {
        $offer = Offer::find($id);
        if (!$offer) return $this->sendError('Offer not found');
        $offer->update(['is_active' => !$offer->is_active]);
        return $this->sendSuccess(['is_active' => $offer->is_active], 'Status updated');
    }
    public function destroyOffer($id) {
        $offer = Offer::find($id);
        if (!$offer) return $this->sendError('Offer not found');
        $offer->delete();
        return $this->sendSuccess([], 'Offer deleted');
    }

    /**
     * Newsletter & Alerts
     */
    public function subscribers() { return $this->sendSuccess(Subscriber::latest()->paginate(20)); }
    public function destroySubscriber($id) {
        $s = Subscriber::find($id);
        if ($s) $s->delete();
        return $this->sendSuccess([], 'Subscriber removed');
    }
    public function allCityAlerts() { return $this->sendSuccess(CityAlert::with('user')->latest()->paginate(20)); }
    public function destroyCityAlert($id) {
        $a = CityAlert::find($id);
        if ($a) $a->delete();
        return $this->sendSuccess([], 'Alert removed');
    }

    /**
     * Pages
     */
    public function updatePage(Request $request, $slug) {
        $keyMap = ['terms-and-conditions' => 'terms_content', 'privacy-policy' => 'privacy_content', 'condition-policy' => 'condition_content', 'contact-us' => 'contact_content', 'faq' => 'faq_content'];
        if (!isset($keyMap[$slug])) return $this->sendError('Invalid slug');
        Setting::set($keyMap[$slug], $request->content);
        return $this->sendSuccess([], 'Page updated');
    }
}
