<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;

class AdController extends Controller
{
    public function create()
    {
        return view('ads.create');
    }

    public function edit(Ad $ad)
    {
        return view('ads.edit', compact('ad'));
    }

    public function delete($id)
    {
        $ad = Ad::withTrashed()->findOrFail($id);

        foreach($ad->images() as $image){
            
            $image->delete(); 
        }

        File::deleteDirectory(storage_path('/app/public/ads/'.$id));
        
        $ad->forceDelete();
    
        return redirect()->back()->with('success', trans('ui.ad_deleted_success'));
    }
 
    public function show(Ad $ad)
    {
        if($ad->is_accepted) {
            return view('ads.show', compact('ad'));
        } else {
            abort(403);
        }
    }

    public function news(Request $request)
    {
        $title = 'Last items';
        $orderby = $request->input('orderby', 'default');

        if ($orderby != 'default') {
            $ads = Ad::where('is_accepted', true)
                    ->orderBy('price', $orderby)
                    ->paginate(8)
                    ->appends($request->all());
        } else {
            $ads = Ad::where('is_accepted', true)
                    ->latest()
                    ->paginate(8)
                    ->appends($request->all());
        }

        return view('ads.index', compact('ads', 'orderby', 'title'));
    }

    public function popular(Request $request)
    {
        $title = 'Popular';
        $orderby = $request->input('orderby', 'default');

        if ($orderby != 'default') {
            $ads = Ad::where('is_accepted', true)
                    ->latest()
                    ->withCount('favBy')
                    ->orderByDesc('fav_by_count')
                    ->orderBy('price', $orderby)
                    ->paginate(8)
                    ->appends($request->all());
        } else {
            $ads = Ad::where('is_accepted', true)
                    ->latest()
                    ->withCount('favBy')
                    ->orderByDesc('fav_by_count')
                    ->paginate(8)
                    ->appends($request->all());
        }

        return view('ads.index', compact('ads', 'title', 'orderby'));
    }

    public function adsByCategory(Category $category, Request $request)
    {
       
        if (app()->getLocale() == 'it'){ 
            $title=$category->title_it;
        }else if(app()->getLocale() == 'en'){
            $title=$category->title_en;
        }else if(app()->getLocale() == 'es'){
            $title=$category->title_es;
        }

        $id = $category->id;        
        $orderby = $request->input('orderby', 'default');

        if ($orderby != 'default') {
            $ads = Ad::where('category_id', $id)
                ->where('is_accepted',true)
                ->orderBy('price', $orderby)
                ->paginate(8)
                ->appends($request->all());
        } else {
            $ads = Ad::where('category_id', $id)
                ->where('is_accepted',true)
                ->latest()
                ->paginate(8)
                ->appends($request->all());
        }

        return view('ads.index', compact('ads','orderby','title','id'));

    }

    public function adsByUser(User $user, Request $request)
    {   
        $title=trans('ui.items_by').$user->name;
        $id = $user->id;
        
        $orderby = $request->input('orderby', 'default');

        if ($orderby != 'default') {
            $ads = Ad::where('user_id', $id)
                ->where('is_accepted',true)
                ->orderBy('price', $orderby)
                ->paginate(8)
                ->appends($request->all());
        } else {
            $ads = Ad::where('user_id', $id)
                ->where('is_accepted',true)
                ->latest()
                ->paginate(8)
                ->appends($request->all());
        }

        return view('ads.index', compact('ads','orderby','title','id'));
    }

    public function favs(Request $request)
    {
        $title="Wishlist";
        $orderby = $request->input('orderby', 'default');
        $user = Auth::user();

        if ($orderby != 'default') {
            $ads = $user->favAds()
                ->where('is_accepted',true)
                ->orderBy('price', $orderby)
                ->paginate(8)
                ->appends($request->all());
        } else {
            $ads = $user->favAds()
                ->where('is_accepted',true)
                ->latest()
                ->paginate(8)
                ->appends($request->all());
        }

        return view('ads.index', compact('ads','orderby','title'));

    }

    public function searchAds(Request $request)
    {   
        $query=$request->input('searched');
        $title=trans('ui.items_about').$query;
        $orderby = $request->input('orderby', 'default');

        if($orderby != 'default'){
           
            $ads = Ad::search($request->searched)
                ->where('is_accepted',true)
                ->orderBy('price', $orderby)
                ->paginate(8)
                ->appends($request->all());
        }else{
            $ads = Ad::search($request->searched)
                ->where('is_accepted',true)
                ->paginate(8)
                ->appends($request->all());
        }        

        return view('ads.index', compact('ads', 'title', 'orderby','query'));       
        
    }

    
}
