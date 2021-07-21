<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $campaigns = Campaign::latest()->when(request()->q, function($campaigns) {
            $campaigns = $campaigns->where('title', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.campaign.index', compact('campaigns'));
    }
    
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.campaign.create', compact('categories'));
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'             => 'required|image|mimes:png,jpg,jpeg',
            'title'             => 'required',
            'category_id'       => 'required',
            'target_donation'   => 'required|numeric',
            'max_date'          => 'required',
            'description'       => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/campaigns', $image->hashName());

        $campaign = Campaign::create([
            'title'             => $request->title,
            'slug'              => Str::slug($request->title, '-'),
            'category_id'       => $request->category_id,
            'target_donation'   => $request->target_donation,
            'max_date'          => $request->max_date,
            'description'       => $request->description,
            'user_id'           => auth()->user()->id,
            'image'             => $image->hashName()
        ]);

        if($campaign){
            //redirect dengan pesan sukses
            return redirect()->route('admin.campaign.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.campaign.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
    /**
     * edit
     *
     * @param  mixed $campaign
     * @return void
     */
    public function edit(Campaign $campaign)
    {
        $categories = Category::latest()->get();
        return view('admin.campaign.edit', compact('campaign', 'categories'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $campaign
     * @return void
     */
    public function update(Request $request, Campaign $campaign)
    {
        $this->validate($request, [
            'title'             => 'required',
            'category_id'       => 'required',
            'target_donation'   => 'required|numeric',
            'max_date'          => 'required',
            'description'       => 'required'
        ]); 

        //check jika image kosong
        if($request->file('image') == '') {
            
            //update data tanpa image
            $campaign = Campaign::findOrFail($campaign->id);
            $campaign->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'category_id'       => $request->category_id,
                'target_donation'   => $request->target_donation,
                'max_date'          => $request->max_date,
                'description'       => $request->description,
                'user_id'           => auth()->user()->id,
            ]);

        } else {

            //hapus image lama
            Storage::disk('local')->delete('public/campaigns/'.basename($campaign->image));

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/campaigns', $image->hashName());

            //update dengan image baru
            $campaign = Campaign::findOrFail($campaign->id);
            $campaign->update([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title, '-'),
                'category_id'       => $request->category_id,
                'target_donation'   => $request->target_donation,
                'max_date'          => $request->max_date,
                'description'       => $request->description,
                'user_id'           => auth()->user()->id,
                'image'             => $image->hashName()
            ]);
        }

        if($campaign){
            //redirect dengan pesan sukses
            return redirect()->route('admin.campaign.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.campaign.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        Storage::disk('local')->delete('public/campaigns/'.basename($campaign->image));
        $campaign->delete();

        if($campaign){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
