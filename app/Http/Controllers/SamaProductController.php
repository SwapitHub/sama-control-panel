<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\SamaProductsModel;
use App\Models\SamaProductGemstoneDetails;
use App\Models\Settings;
use App\Imports\SamaProductsImport;
use App\Exports\SamaProducts;
use Maatwebsite\Excel\Facades\Excel;

class SamaProductController extends Controller
{
    public function index(Request $request)
    {
        $products = SamaProductsModel::orderBy('id', 'desc')->paginate(30);
        $data['prifix'] =
            $data['info'] = ['meta_title' => 'Sama Internal Product Listing', 'meta_keyword' => 'Sama Product Listing', 'meta_description' => 'Sama Product Listing'];
        // $products->appends(['filter' => $request->filter, 'type' => $request->type, 'menu' => $request->menu]);
        $data = [
            'title' => 'Sama Product List',
            'backtrack' => route('admin.product.dblist'),
            'list' => $products,
            'prifix' => Settings::first()->route_web_prifix
        ];
        return view('admin.internal-product-list', $data);
    }

    public function importSamaProducts(Request $request)
    {
        $request->validate([
            'sama_products' => 'required|file|mimes:csv,xlsx',
        ]);
        $importedData = new SamaProductsImport;
        $res = Excel::import($importedData, $request->file('sama_products'));
        $importStatus = $importedData->getImportStatus();
        if ($importStatus['is_updated'] == 'true') {
            return redirect()->route('admin.product.dblist')->with('success', 'Product imported successfully');
        } else {
            return redirect()->route('admin.product.dblist')->with('success', 'Something went wrong');
        }
    }

    public function exportProducts()
    {
        return Excel::download(new SamaProducts, 'internal-products.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
