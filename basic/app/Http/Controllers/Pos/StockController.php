<?php

namespace App\Http\Controllers\Pos;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Unit;
use Auth;
use Illuminate\Support\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function stockReport() {

        $allData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->get();
        return view('backend.stock.stock_report', compact('allData'));
    }

    public function stockReportPdf(){
        
        $allData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->get();
        return view('backend.pdf.stock_report_pdf', compact('allData'));
    }

    public function stockSupplierWise(){

        $suppliers = Supplier::all();
        $categories = Category::all();

        return view('backend.stock.supplier_product_wise_report', compact('suppliers', 'categories'));
    }

    public function supplierWisePdf(Request $request){

        $allData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->where('supplier_id', $request->supplier_id)->get();
        return view('backend.pdf.supplier_wise_report_pdf', compact('allData'));
    }
}
