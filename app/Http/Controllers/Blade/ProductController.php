<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // list of categories
    public function index()
    {
        $products = Product::with('category:id,name_ru')->get()->all();
        return view('pages.product.index',compact('products'));
    }

    // add category page
    public function add()
    {
        $categories = Category::where('has_subcategory', '=', 0)->get()->all();
        $count = 1;
        return view('pages.product.add',compact('categories','count'));
    }

    //create category
    public function create(Request $request)
    {
        $this->validate($request,[
            'name_uz' => 'required',
            'name_ru' => 'required',
            'name_en' => 'required',
            'code'    => 'required',
            'package_code'    => 'required',
            'vat_percent'    => 'required',
            'price'   => 'required'
        ]);

        $product = Product::create([
            'name_uz' => $request->get('name_uz'),
            'name_ru' => $request->get('name_ru'),
            'name_en' => $request->get('name_en'),
            'photo' => '12',//$request->get('name_ru'),
            'description' => 'no',//$request->get('name_ru'),
            'description_ru' => $request->get('description_ru') ?? '',
            'description_uz' => $request->get('description_uz') ?? '',
            'description_en' => $request->get('description_en') ?? '',
            'in_stock' => '1',//$request->get('name_ru'),
            'price' => $request->get('price'),
            'category_id' => $request->get('category_id'),
            'code' => $request->get('code'),
            'package_code' => $request->get('package_code'),
            'vat_percent' => $request->get('vat_percent'),
        ]);

        if ($request->hasFile('photo'))
        {
            $file = $request->photo;
            $name = (microtime(true)*10000).'.'.$file->extension();
            $product->photo = $name;
            $product->save();

            // upload file to files folder
            $file->move($product->public_path(), $name);
        }
        return redirect()->route('productIndex');
    }

    // edit page
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::where('has_subcategory', '=', 0)->get()->all();
        $products = [];//CategoryController::getAllfromJowi();
        $count = 1;
        return view('pages.product.edit',compact('product','categories','products','count'));
    }

    // update data
    public function update(Request $request,$id)
    {
        $product = Product::find($id);

        $product->name_uz = $request->get('name_uz');
        $product->name_ru = $request->get('name_ru');
        $product->name_en = $request->get('name_en');
        $product->price = $request->get('price');
        $product->category_id = $request->get('category_id');
        $product->code = $request->get('code');
        $product->package_code = $request->get('package_code');
        $product->vat_percent = $request->get('vat_percent');
        $product->description_ru = $request->get('description_ru') ?? '';
        $product->description_uz = $request->get('description_uz') ?? '';
        $product->description_en = $request->get('description_en') ?? '';
        if ($request->hasFile('photo'))
        {
            $file = $request->photo;
            $name = (microtime(true)*10000).'.'.$file->extension();
            $product->photo = $name;
            // upload file to files folder
            $file->move($product->public_path(), $name);
        }
        $product->save();

        return redirect()->route('productIndex');
    }

    // delete permission
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back();
    }

    public function toggleProductActivation($id)
    {
        $product = Product::where('id',$id)->first();
        $product->in_stock = ! $product->in_stock;
        $product->save();
        return [
            'is_active' => $product->in_stock
        ];
    }
}
