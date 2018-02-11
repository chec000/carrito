<?php

namespace Modules\Support\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\BannerLanguage;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\BannerRequest;
use App\Banner;

class BannerController extends Controller
{
    var $banner_path = 'img/banners';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:banners.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::banner.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('support::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, BannerRequest $bannerRequest)
    {
        $banner = new Banner();
        $banner->country_id = Auth::user()->country_id;
        $banner->modified_by = Auth::user()->id;
        $banner->estatus = $request->estatus;
        $banner->save();

        $bannerLang = new BannerLanguage();
        $bannerLang->banner_id = $banner->banner_id;
        $bannerLang->language_id = $request->language_id;
        $bannerLang->main_image = $request->main_image;
        $bannerLang->name = $request->name;
        $bannerLang->modified_by = Auth::user()->id;
        $bannerLang->estatus = $request->estatus;
        $bannerLang->save();

        if($request->has('main_image')){
            $bannerName = $bannerLang->banner_language_id.'.'.$request->file('main_image')->clientExtension();
            $bannerLang = BannerLanguage::find($bannerLang->banner_language_id);
            $bannerLang->main_image = $bannerName;
            $bannerLang->save();
            $path = $request->file('main_image')->storeAs( $this->banner_path, $bannerName );
        }

        return response()->json($bannerLang);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data['language'] = Language::where('estatus','!=', -1)->get();

        $data['banner'] = BannerLanguage::select('*','banner_language.estatus')->join('banner', 'banner_language.banner_id', '=', 'banner.banner_id')
            ->where('banner_language.estatus','!=', -1)
            ->where('banner.country_id', Auth::user()->country_id)
            ->with('language')->get();

        foreach ($data['banner'] as $banner){
            if( file_exists( public_path($this->banner_path.  '/' . $banner->main_image) ) &&  $banner->main_image != ''  ){
                $banner->main_image = url($this->banner_path. '/' .$banner->main_image);
            }
            else
                $banner->main_image = '';
        }

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $banner = BannerLanguage::find($id);

        if( file_exists( public_path($this->banner_path.  '/' . $banner->main_image) ) &&  $banner->main_image != ''  ){
            $banner->main_image = url($this->banner_path.'/'.$banner->main_image);
        }
        else
            $banner->main_image = '';

        return response()->json($banner);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, BannerRequest $bannerRequest)
    {
        $bannerLang = BannerLanguage::find($id);
        $bannerLang->language_id = $request->language_id;
        $bannerLang->name = $request->name;
        $bannerLang->modified_by = Auth::user()->id;
        $bannerLang->estatus = $request->estatus;
        $bannerLang->save();

        if($request->has('main_image') ){

            if( file_exists( public_path($this->banner_path.  '/' . $bannerLang->main_image) ) &&  $bannerLang->main_image != ''  ){
                unlink( public_path($this->banner_path . '/' . $bannerLang->main_image) );
            }

            $bannerName = $bannerLang->banner_language_id.'.'.$request->file('main_image')->clientExtension();
            $bannerLang = BannerLanguage::find($bannerLang->banner_language_id);
            $bannerLang->main_image = $bannerName;
            $bannerLang->save();
            $path = $request->file('main_image')->storeAs( $this->banner_path, $bannerName );
        }

        return response()->json($bannerLang);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $bannerLang = BannerLanguage::find($id);

        if( file_exists( public_path($this->banner_path.  '/' . $bannerLang->main_image) ) &&  $bannerLang->main_image != ''  ){
            unlink( public_path($this->banner_path . '/' . $bannerLang->main_image) );
            $bannerLang->main_image = '';
        }

        $bannerLang->estatus = -1;
        $bannerLang->deleted_at = date('Y-m-d H:i:s');
        $bannerLang->save();

        return response()->json([$bannerLang]);
    }

    public function on($id)
    {
        $bannerLang = BannerLanguage::find($id);
        $bannerLang->estatus = 1;
        $bannerLang->save();
        return response()->json([$bannerLang]);
    }

    public function off($id)
    {
        $bannerLang = BannerLanguage::find($id);
        $bannerLang->estatus = 0;
        $bannerLang->save();
        return response()->json($bannerLang);
    }
}
