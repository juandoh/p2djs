<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF; 
use App\Courses; 


class ReportController extends Controller
{
    //

    public function getPDF(){

    	$courses= Courses::all();
    	
    	$pdf = PDF::loadView('pdf.course',['courses'=>$courses]);
    		return $pdf->stream('course.pdf');	
    		
    }
}
