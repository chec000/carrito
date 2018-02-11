<?php

namespace Modules\Support\Http\Controllers;

use App\Language;
use App\Product;
use App\Testimony;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\BannerLanguage;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\TestimonyRequest;

class TestimonyController extends Controller
{
    var $testimony_path = 'img/testimony';
    var $product_path = 'img/img-products';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:testimony.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::testimony.index');
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
    public function store(Request $request, TestimonyRequest $testimonyRequest)
    {
        $testimony = new Testimony();
        $testimony->language_id = $request->language_id;
        $testimony->name = $request->name;
        $testimony->modified_by = Auth::user()->id;
        $testimony->estatus = $request->estatus;
        $testimony->testimony = $request->testimony;
        $testimony->product_id = $request->product_id;
        $testimony->usuario_id = Auth::user()->id;
        $testimony->country_id = Auth::user()->country_id;
        $testimony->save();

        if($request->has('photo') ){
            $photo = $testimony->testimony_id.'.'.$request->file('photo')->clientExtension();
            $testimony->photo = $photo;
            $testimony->save();
            $path = $request->file('photo')->storeAs( $this->testimony_path, $photo );
        }

        return response()->json($testimony);
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
        $data['product'] = Product::
            select('product.product_id', 'product.sku', 'product_language.short_description')
            ->where('product.estatus','!=', -1)
            ->where('product.country_id',  Auth::user()->country_id)
            ->join('product_language', 'product_language.product_id', 'product.product_id')
            ->groupBy('product_id')
            ->get();
        $data['testimony'] = Testimony::select('*')
            ->where('testimony.estatus','!=', -1)
            ->where('testimony.country_id', Auth::user()->country_id)
            ->with('language')
            ->with('product')
            ->with('productLanguage')
           ->get();

        foreach ($data['testimony'] as $testimony){
            if( file_exists( public_path($this->testimony_path.  '/' . $testimony->photo) ) &&  $testimony->photo != ''  ){
                $testimony->photo = url($this->testimony_path. '/' .$testimony->photo);
            }
            else
                $testimony->photo = '';
        }

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $testimony = Testimony::find($id);

        if( file_exists( public_path($this->testimony_path.  '/' . $testimony->photo) ) &&  $testimony->photo != ''  )
            $testimony->photo = url($this->testimony_path. '/' .$testimony->photo);
        else
            $testimony->photo = '';

        if( file_exists( public_path($this->product_path.  '/' . $testimony->product->sku.'.jpg') ) &&  $testimony->product->sku != ''  )
            $testimony->product_img = url($this->product_path. '/' .$testimony->product->sku.'.jpg');
        else
            $testimony->product_img = '';


        return response()->json($testimony);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, TestimonyRequest $testimonyRequest)
    {
        $testimony = Testimony::find($id);

        $testimony->language_id = $request->language_id;
        $testimony->name = $request->name;
        $testimony->modified_by = Auth::user()->id;
        $testimony->estatus = $request->estatus;
        $testimony->testimony = $request->testimony;
        $testimony->product_id = $request->product_id;
        $testimony->save();

        if($request->has('photo') ){

            if( file_exists( public_path($this->testimony_path.  '/' . $testimony->photo) ) &&  $testimony->photo != ''  ){
                unlink( public_path($this->testimony_path . '/' . $testimony->photo) );
            }

            $photo = $testimony->testimony_id.'.'.$request->file('photo')->clientExtension();
            $testimony->photo = $photo;
            $testimony->save();
            $path = $request->file('photo')->storeAs( $this->testimony_path, $photo );
        }

        return response()->json([$testimony]);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $testimony = Testimony::find($id);

        if( file_exists( public_path($this->testimony_path.  '/' . $testimony->photo) ) &&  $testimony->photo != ''  ){
            unlink( public_path($this->testimony_path . '/' . $testimony->photo) );
            $testimony->photo = '';
        }

        $testimony->estatus = -1;
        $testimony->deleted_at = date('Y-m-d H:i:s');
        $testimony->save();

        return response()->json([$testimony]);
    }

    public function on($id)
    {
        $testimony = Testimony::find($id);
        $testimony->estatus = 1;
        $testimony->save();
        return response()->json([$testimony]);
    }

    public function off($id)
    {
        $testimony = Testimony::find($id);
        $testimony->estatus = 0;
        $testimony->save();
        return response()->json($testimony);
    }
}
