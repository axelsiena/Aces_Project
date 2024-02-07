<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class RevisorController extends Controller
{
    public function __construct(){
        $this->middleware('is_revisor')->except('workWithUs');
    }

    public function index (){

        $ad_to_check = Ad::where('is_accepted',false)->where('user_id','!=',auth()->user()->id)->first();

        $rejected_ads = Ad::onlyTrashed()->where('user_id','!=',auth()->user()->id)->latest()->paginate(10);
        $accepted_ads = Ad::where('is_accepted',true)->where('user_id','!=',auth()->user()->id)->where('revisioned_by_user_id',auth()->user()->id)->latest()->paginate(10);

        return view('revisor.index', compact('ad_to_check', 'accepted_ads', 'rejected_ads'));
    }

    public function acceptAd (Ad $ad)
    {        
        $ad->update(
            [
                'is_accepted' => true,
                'revisioned_by_user_id' => auth()->user()->id,
            ]
        );
        $ad->save();
        return redirect()->back()->with('success', trans('ui.ad_accepted_success') . ' <a href="' . route('revisor.back', $ad) . '">' . trans('ui.ops') . '</a>');

    }

    public function rejectAd (Ad $ad)
    {
        $ad->update(
            [
                'revisioned_by_user_id' => auth()->user()->id,
            ]
        );
        $ad->save();
        $ad->delete();
        
        return redirect()->back()->with('error', trans('ui.ad_rejected_success') . ' <a href="' . route('revisor.restore', $ad) . '">' . trans('ui.ops') . '</a>');
    }

    public function back(Ad $ad)
    {
        $ad->update(['is_accepted'=> false]);
        return redirect()->back()->with('success',trans('ui.operation_canceled'));
    
    }

    public function restore($id)
    {
        $ad = Ad::withTrashed()->findOrFail($id);

        if ($ad->trashed()) {
            $ad->restore();
        } else {
            return redirect()->back()->with('error', trans('ui.ad_not_found'));
        }

        return redirect()->route('revisor.index')->with('success', trans('ui.ad_restored_success'));
    }

    public function workWithUs(){
        return view('revisor.work');
    }
   
    
}
