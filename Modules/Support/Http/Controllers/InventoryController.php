<?php namespace Modules\Support\Http\Controllers;

use App\InventarioProducts;
use App\Http\Controllers\Controller;
use App\Warehouse;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Modules\Support\Http\Requests\InventarioForm;

class InventoryController extends Controller {
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $inventarios = InventarioProducts::where('product_id',$request->id)
                                        ->where('estatus','!=', -1)
                                        ->where('wharehouse_id','!=', 0)
                                        ->with('almacenes')
                                        ->get();

        $almacenes = $this->registrosFaltantes(
                                        Warehouse::where('estatus','1')->get(),
                                        $inventarios
                                    );
        $inventario = $this->getPermisos($inventarios,$almacenes);

        return response()->json($inventario);
    }


    public function show($id)
    { 

    	$products = Product::where('product_id',$id)->first();


        return view('support::inventory.index', compact('products'));

    }


    public function store(Request $request,InventarioForm $inventarioForm)
    {

        $inventario = InventarioProducts::updateOrCreate(
            ['product_id' => $request->product_id, 'wharehouse_id' => $request->almacen],
            [
                'estatus' => 1,
                'wharehouse_id' => $request->almacen,
                'product_id' => $request->product_id,                                
                'stock' => 0,

            ]
        );       
        return response()->json($inventario);
    }    


    public function destroy($id)
    {

        $product = InventarioProducts::find($id);
        $product->estatus = -1;
        $product->save();        
        return response()->json(['done']);
    }

    public function on($id)
    {

        $product = InventarioProducts::find($id);
        $product->estatus = 1;
        $product->save();        
        return response()->json(['done']);
    }

    public function off($id)
    {

        $product = InventarioProducts::find($id);
        $product->estatus = 0;
        $product->save();        
        return response()->json(['done']);
    }      

    private function registrosFaltantes($catalogo, $registros)
    {
        /* echo "<pre>";
        var_dump($catalogo);
        echo "</pre>";
        echo "<pre>";
        var_dump($registros);
        echo "</pre>";
        die(); */
        foreach ($catalogo as $key => $a) {

            foreach ($registros as $key1 => $i) {
                if($a->wharehouse_id == $i->wharehouse_id){
                    unset($catalogo[$key]);
                }
            }
        }
        if(count($catalogo) === 0){
            $catalogo[0] = [ 
                'almacen' => ''
            ];
        }
        return $catalogo;
    }  
    private function getPermisos($inventarios,$almacenes)
    { 
        return $inventario = [
            'inventario' => $inventarios,
            'almacenes' => $almacenes,
            /* 'status' => Auth::user()->can('status', InventarioProducts::class),
            'delete' => Auth::user()->can('delete', InventarioProducts::class), */
        ];
    }
}
