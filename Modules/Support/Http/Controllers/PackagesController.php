<?php

namespace Modules\Support\Http\Controllers;


use App\Package;
use App\Language;
use App\Product;
use App\ProductPackage;
use App\PackageLanguage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\PackageRequest;
use Illuminate\Support\Facades\DB;



class PackagesController extends Controller
{
    var $package_path = 'img/packages';
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:packages.index', ['only' => ['index']]);

    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::packages.index');
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
    public function store(Request $request, PackageRequest $packageRequest)
    {
        parse_str($request->products, $products);
        parse_str($request->quantities, $quantities);

        $package = new Package();
        $package->country_id = Auth::user()->country_id;
        $package->price = $request->price;
        $package->points = $request->points;
        $package->modified_by = Auth::user()->id;
        $package->estatus = $request->estatus;
        $package->save();

        $packageLanguage = new PackageLanguage();
        $packageLanguage->package_id = $package->package_id;
        $packageLanguage->language_id = $request->language_id;
        $packageLanguage->name = $request->name;
        $packageLanguage->image_package = $request->image_package;
        $packageLanguage->description = $request->description;
        $packageLanguage->video_url = $request->video_url;
        $packageLanguage->modified_by = Auth::user()->id;
        $packageLanguage->estatus = $request->estatus;
        $packageLanguage->save();

        if($request->has('image_package')){
            $packageName = $packageLanguage->package_language_id.'.'.$request->file('image_package')->clientExtension();
            $packageLanguage = PackageLanguage::find($packageLanguage->package_language_id);
            $packageLanguage->image_package = $packageName;
            $packageLanguage->save();
            $path = $request->file('image_package')->storeAs( $this->package_path, $packageName );
        }

        if($products){
            foreach ($products['productos'] as $key => $product){
                $prodPackage = new ProductPackage();
                $prodPackage->package_id = $package->package_id;
                $prodPackage->product_id = $product;
                $prodPackage->quantity = isset($quantities['cantidades'][$key])?  $quantities['cantidades'][$key] : 1;
                $prodPackage->estatus = 1;
                $prodPackage->modified_by = Auth::user()->id;
                $prodPackage->save();
            }
        }

        return response()->json($packageLanguage);
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


        $data['package'] = PackageLanguage::select('*','package_language.estatus')
            ->join('package', 'package_language.package_id', '=', 'package.package_id')
            ->where('package_language.estatus','!=', -1)
            ->where('package.country_id', Auth::user()->country_id)
            ->with('language')
            ->with('productpackage')
            ->get();


        $data['products'] = Product::where('estatus','!=',-1)
                                     ->where('country_id',Auth::user()->country_id)
                                     ->with('productlanguage')
                                     ->get();




        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        /* $package = PackageLanguage::where('package_language_id','=', $id)
                                    ->with('package')->get(); */
        $package['package_language'] = PackageLanguage::find($id);
        $package['package']          = Package::where('package_id', $package['package_language']->package_id)->first();
        $package['products']         = ProductPackage::where('package_id', $package['package_language']->package_id)->where('estatus', '!=', '-1' )->with('productlanguage')->with('product')->get();

        if( file_exists( public_path($this->package_path.  '/' . $package['package_language']->image_package) ) && $package['package_language']->image_package != ''  ){
            $package['package_language']->image_package = url($this->package_path.'/'.$package['package_language']->image_package);
        }
        else
            $package['package_language']->image_package = '';

        return response()->json($package);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, PackageRequest $packageRequest)
    {
        /*$package = new Package();

        $package->country_id = Auth::user()->country_id;
        $package->modified_by = Auth::user()->id;
        $package->is_main_package = $request->is_main_package;
        $package->estatus = $request->estatus;
        $package->list_order = !empty($request->list_order) ? $request->list_order : 0;

        $package->save();

        $packageLanguage = PackageLanguage::find($id);
        $packageLanguage->language_id = $request->language_id;
        $packageLanguage->package = $request->package;
        $packageLanguage->estatus = $request->estatus;
        $packageLanguage->save();
        return response()->json($packageLanguage);*/

        parse_str($request->products, $products);
        parse_str($request->quantities, $quantities);

        $packageLanguage = PackageLanguage::find($id);
        $packageLanguage->language_id = $request->language_id;
        $packageLanguage->name = $request->name;
        $packageLanguage->description = $request->description;
        $packageLanguage->video_url = $request->video_url;
        $packageLanguage->modified_by = Auth::user()->id;
        $packageLanguage->estatus = $request->estatus;
        $packageLanguage->save();

        $package = Package::find($packageLanguage->package_id);
        $package->price = $request->price;
        $package->points = $request->points;
        $package->modified_by = Auth::user()->id;
        $package->estatus = $request->estatus;
        $package->save();

        if($request->has('image_package')){

            if( file_exists( public_path($this->package_path.  '/' . $packageLanguage->image_package) ) &&  $packageLanguage->image_package != ''  ){
                unlink( public_path($this->package_path . '/' . $packageLanguage->image_package) );
            }

            $packageName = $packageLanguage->package_language_id.'.'.$request->file('image_package')->clientExtension();
            $packageLanguage = PackageLanguage::find($packageLanguage->package_language_id);
            $packageLanguage->image_package = $packageName;
            $packageLanguage->save();
            $path = $request->file('image_package')->storeAs( $this->package_path, $packageName );
        }

        ProductPackage::where('package_id', $package->package_id)->update([ 'estatus'=> -1, 'deleted_at'=> date('Y-m-d H:i:s') ]);

        if($products){
            foreach ($products['productos'] as $key => $product){
                $prodPackage = ProductPackage::firstOrNew(array('package_id' => $package->package_id, 'product_id' => $product));
                $prodPackage->estatus = 1;
                $prodPackage->package_id = $package->package_id;
                $prodPackage->product_id = $product;
                $prodPackage->quantity = isset($quantities['cantidades'][$key])? $quantities['cantidades'][$key] : 1;
                $prodPackage->modified_by = Auth::user()->id;
                $prodPackage->deleted_at = null;
                $prodPackage->save();
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $packageLanguage = PackageLanguage::find($id);
        if( file_exists( public_path($this->package_path.  '/' . $packageLanguage->image_package) ) &&  $packageLanguage->image_package != ''  ){
            unlink( public_path($this->package_path . '/' . $packageLanguage->image_package) );
            $packageLanguage->image_package = null;
        }

        $packageLanguage->estatus = -1;
        $packageLanguage->deleted_at = Carbon::now();
        $packageLanguage->save();
        return response()->json([$packageLanguage]);
    }

    public function on($id)
    {
        $packageLanguage = PackageLanguage::find($id);
        $packageLanguage->estatus = 1;
        $packageLanguage->save();
        return response()->json([$packageLanguage]);
    }

    public function off($id)
    {
        $packageLanguage = PackageLanguage::find($id);
        $packageLanguage->estatus = 0;
        $packageLanguage->save();
        return response()->json($packageLanguage);
    }
}
