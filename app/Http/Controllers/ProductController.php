<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Hobby;
use App\Models\State;
use App\Models\Country;
use App\Models\Product;
use App\Models\Hobby_Product_Mapping;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('countries', 'states', 'cities','hobby_mapping')->get();
        // print_r($products->toArray());exit;

        return view('products.index', compact('products'));

    }
    
    public function create()
    {
        $countries = Country::get();
        $states = State::get();
        $cities = City::get();
        $products = Product::get();
        $hobbies = Hobby::get();
        // print_r($countries);exit;

        $title = 'create';
        return view('products.create', compact('title', 'countries', 'states', 'cities', 'products','hobbies'));
    }

    public function getState(Request $request)
    {
        $stateData = State::select('id', 'state_name')->where('country_id', $request->country_id)->orderBy('state_name', 'asc')->get();

        $html = '<option value="">Select State</option>';
        foreach ($stateData as $row) {
            $html .= '<option value="' . $row->id . '">' . $row->state_name . '</option>';
        }

        return response()->json(['html' => $html]);
    }

    public function getCity(Request $request)
    {
        $cityData = City::select('id', 'city_name')->where('state_id', $request->state_id)->orderBy('city_name', 'asc')->get();

        $html = '<option value="">Select City</option>';
        foreach ($cityData as $row) {
            $html .= '<option value="' . $row->id . '">' . $row->city_name . '</option>';
        }

        return response()->json(['html' => $html]);
    }

    public function edit($id)
    {
        $title = 'Update';
        $id_data = base64_decode($id);
        $product = Product::where('id', $id_data)->first();
        $countries = Country::get();
        $states = State::get();
        $cities = City::get();
        $hobbies = Hobby::get();
        $edit = Product::with('hobby_mapping')->where('id',$id_data)->first();
        $hobby_id = $edit->hobby_mapping->pluck('hobby_id')->toArray();
        // print_r($title);exit;
        return view('products.create', compact('product', 'title', 'countries','states','cities','hobbies','edit','hobby_id'));
    }

    public function destroy($id)
    {
        $id_data = base64_decode($id);
        //  print_r($id_data);
        $products = Product::where('id', $id_data)->first();

        $img = public_path('products/' . $products->image);
        if (file_exists($img)) {
            unlink($img);
        }
        $products->delete();
        return redirect()->route('products.index');
    }

    public function view($id)
    {

        $id_data = base64_decode($id);
        //  print_r($id_data);
        $product = Product::where('id', $id_data)->first();
        //  $products->delete();
        return view('products.view', compact('product'));
    }

    public function store(Request $request)
    {
      
        switch ($request->button) {

            case 'Update':
                $request->validate([
                    'name' => 'required|regex:/^[a-zA-Z\s]+$/',
                    'email' => 'required',
                    'address' => 'required',
                    'country' => 'required',
                    'state' => 'required',
                    'city' => 'required',
                    'hobby' => 'required',
                    'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1000',
                    'status' => 'required'

                ]);
                $product = Product::where('id', $request->id)->first();
                $product->name = $request->name;
                $product->email = $request->email;
                $product->address = $request->address;
                $product->fromdate = date('Y-m-d', strtotime($request->fromdate));
                $product->todate = date('Y-m-d', strtotime($request->todate));
                // dd($request->country);
                $product->country_id = $request->country;
                $product->state_id = $request->state;
                $product->city_id = $request->city;
                // $product->image = $imageName;
                if ($request->hasFile('image')) {
                    $imageName = time() . '.' . $request->image->extension();
                    $request->image->move(public_path('products'), $imageName);
                    // $product->image=$imageName;

                    if ($product->image) {
                        unlink(public_path('products/' . $product->image));
                    }
                    $product->image = $imageName;
                }
                $product->updated_at = date('Y-m-d H:i:s');
                $product->save();

                $product_id = $product->id;
                Hobby_Product_Mapping::where('product_id',$product_id)->delete();
                $hobbies = $request->hobby;

                foreach($hobbies as $value){
                    $var = new Hobby_Product_Mapping;
                    $var->product_id = $product_id;
                    $var->hobby_id = $value;
                    $var->save();
                }
                
                break;

            default:
                $request->validate([
                    'name' => 'required|regex:/^[a-zA-Z\s]+$/',
                    'email' => 'required',
                    'address' => 'required',
                    'country' => 'required',
                    'state' => 'required',
                    'city' => 'required',
                    'hobby' => 'required',
                    // 'image' => 'required|mimes:jpeg,jpg,png,gif|max:1000',
                    'image' => 'required|image:gif,png,jpeg,jpg',
                    'status' => 'required'

                ]);

                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('products'), $imageName);

                // Eloquent ORM method
                $product = new Product; // created object(instance) of class 'Product'.
                $product->image = $imageName;
                $product->name = $request->name;
                $product->email = $request->email;
                $product->address = $request->address;
                $product->fromdate = date('Y-m-d', strtotime($request->fromdate));
                $product->todate = date('Y-m-d', strtotime($request->todate));
                // $product->country_id = $request->country;
                $product->country_id = $request->country;
                $product->state_id = $request->state;
                $product->city_id = $request->city;
                $product->save();

                $product_id = $product->id;
                // Hobby_Product_Mapping::where('product_id',$product_id->id)->delete();
                $hobbies = $request->hobby;

                foreach($hobbies as $value){
                    $var = new Hobby_Product_Mapping;
                    $var->product_id = $product_id;
                    $var->hobby_id = $value;
                    $var->save();
                }
                break;
        }
        // print_r($request->button);exit;

        return redirect()->route('products.index');
    }


    public function product_ajax(Request $request)
    {

        if ($request->ajax()) {
            $data = Product::with('countries', 'states', 'cities','hobby_mapping')->get();
            return Datatables::of($data)->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $edit = '<a href="' . route('products.edit', base64_encode($row->id)) . '"class="text-white btn btn-warning btn-sm"><i
                    class="fa-regular fa-pen-to-square"></i>
                    </a>';

                    $del = '<a href="' . route('products.destroy', base64_encode($row->id)) . '"class="text-white btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this row?\')"><i
                    class="fa-solid fa-trash-can"></i></a>';

                    $view = '<a href="' . route('products.view', base64_encode($row->id)) . '"class="text-white btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>';
                    return $edit . ' ' . $view . ' ' . $del;
                })

                ->addColumn('image', function ($row) {
                    $img = '<img src="' . url("public/products/" . $row->image) . '" alt="" height="70px" width="70px">';
                    return $img;
                })

                ->addColumn('fromdate', function ($row) {
                    $date = date('d F Y', strtotime($row->fromdate));
                    return $date;
                })

                ->addColumn('todate', function ($row) {
                    $date1 = date('d F Y', strtotime($row->todate));
                    return $date1;
                })

                ->addColumn('country', function ($row) {

                    $test = $row->countries->country_name;
                    return $test;
                })

                ->addColumn('state', function ($row) {

                    $test = $row->states->state_name;

                    return $test;
                })

                ->addColumn('city', function ($row) {

                    $test = $row->cities->city_name;

                    return $test;
                })
                ->addColumn('hobby', function ($row) {

                    $test = $row->hobby_mapping->pluck('hobby.hobby_name')->implode(',');

                    return $test;
                })
                ->addColumn('status', function ($row) {
                    if($row->status=='active'){
                        $test = '<button class="btn btn-success btn-sm" name="status" onclick="statuschange(`'.$row->status.'`,`'.$row->id.'`)"  id="st" value='.$row->status.' >'.ucfirst($row->status).'</button>';
                    }
                    else{
                        $test = '<button class="btn btn-danger btn-sm" name="status"  onclick="statuschange(`'.$row->status.'`,`'.$row->id.'`)" id="st" value='.$row->status.' >'.ucfirst($row->status).'</button>';
                    }
                    return $test;
                })    
                ->rawColumns(['action', 'image', 'fromdate', 'todate', 'country', 'state', 'city','status','hobby'])
                ->make(true);
        }

        return view('products.index');
    }

    public function status(Request $request){
        if(isset($request->id)){
            if($request->status == 'active'){
                $status = 'inactive';
            }else{
                $status = 'active';
            }
            $model = Product::where('id',$request->id)->first();
            $model->status = $status;
            $model->update();
        }
        
        return redirect()->route('products.index');
    }

    public function exportproduct(Request $request)
    {
        return Excel::download(new ProductsExport($request->from, $request->to), 'products.xlsx');
    }

    public function import(Request $request){
        // print_r($request->all());exit;
        Excel::import(new ProductsImport,$request->file('file'));
        return back()->withsuccess('Data inserted....');
    }

    public function pdf(){
        $products=[
            'title'=>'Products data pdf',
            'date'=>date('m/d/Y'),
            'products'=>Product::get(),
        ];
        // dd($users);
        $pdf = Pdf::loadView('products.pdf', $products);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('products_data.pdf');
        // return back()->withsuccess('PDf downloaded successfully');
    }
}
