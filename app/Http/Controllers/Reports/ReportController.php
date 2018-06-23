<?php

namespace App\Http\Controllers\Reports;

use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    //

    public function getPDF(){
        $pdf = PDF::loadView('pdf.course');
        return $pdf->download('course.pdf');

    }
}
