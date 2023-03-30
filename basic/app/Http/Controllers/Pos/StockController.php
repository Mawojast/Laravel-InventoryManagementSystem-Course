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
}
