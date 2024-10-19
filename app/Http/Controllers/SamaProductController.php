<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\SamaProductsModel;
use App\Models\InternalProducts;
use App\Models\SamaProductGemstoneDetails;
use App\Models\Settings;
use App\Imports\SamaProductsImport;
use App\Imports\InternalProductImport;
use App\Imports\InternalProductImportW;
use App\Exports\SamaProducts;
use App\Exports\InternalProductExport;

use App\Models\Menu;
use Maatwebsite\Excel\Facades\Excel;

class SamaProductController extends Controller
{
    public function index(Request $request)
    {
        $products = InternalProducts::orderBy('id', 'desc')->paginate(30);
        $info = ['meta_title' => 'Sama Internal Product Listing', 'meta_keyword' => 'Sama Product Listing', 'meta_description' => 'Sama Product Listing'];
        // $products->appends(['filter' => $request->filter, 'type' => $request->type, 'menu' => $request->menu]);
        $menus = Menu::orderBy('id', 'desc')
            ->where('status', 'true')
            ->where('name', '!=', 'BRAND')
            ->where('name', '!=', 'DIAMONDS')
            ->where('name', '!=', 'GEMSTONES')
            ->get();
        $data = [
            'info'=>$info,
            'title' => 'Sama Product List',
            'backtrack' => route('admin.product.dblist'),
            'list' => $products,
            'menus'=>$menus,
            'prifix' => Settings::first()->route_web_prifix,
        ];
        return view('admin.internal-product-list', $data);
    }

    public function importSamaProducts(Request $request)
    {
        if (!empty($request->menu)) {
            if ($request->menu == 'ENGAGEMENT RINGS') {
                $productImport = new InternalProductImport($request->menu);
                // $productImport = new SamaProductsImport($request->menu);
                $res = Excel::import($productImport, $request->file('excel_file'));
            } else {
                $productImport = new InternalProductImportW($request->menu);
                // $productImport = new SamaProductsImport($request->menu);
                $res = Excel::import($productImport, $request->file('excel_file'));
            }

            // $importedData = $importedData->getImportedData();
            $importStatus = $productImport->getImportStatus();
            // var_dump($importStatus);
            if ($importStatus['is_updated'] == 'true') {
                return redirect()->route('sama.internal-product.list')->with('success', 'Product imported successfully');
            } else {
                return redirect()->route('sama.internal-product.list')->with('success', 'Something went wrong');
            }

        } else {
            return "choose menu";
        }
    }

    public function exportProducts()
    {
        return Excel::download(new InternalProductExport, 'internal-products.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
