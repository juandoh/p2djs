<?php

namespace App\Http\Controllers\Reports;

use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF; 
use App\Courses; 


class ReportController extends Controller
{
    //

    public function getPDF(){
        $pdf = PDF::loadView('pdf.course');
        return $pdf->download('course.pdf');

<<<<<<< HEAD
    	$courses= Courses::all();
    	
    	$pdf = PDF::loadView('pdf.course',['courses'=>$courses]);
    		return $pdf->stream('course.pdf');	
    		
=======
>>>>>>> 5b82cb85a4a7bc500cf84db30627bc0894bb753c
    }
}
