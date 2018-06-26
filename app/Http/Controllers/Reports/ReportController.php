<?php

namespace App\Http\Controllers\Reports;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF; 
use App\Courses; 
use App\AcademicPrograms; 


class ReportController extends Controller
{
    //

    public function getCourseReport( $course_id){


    	$course = Courses::find($course_id);
    	
    	$pdf = PDF::loadView('pdf.course',['course'=>$course]);
    	return $pdf->stream('course_'. $course->name .'.pdf');	
    		
    }

    public function getProgramReport($program_id){
    	
    	
    	$program = AcademicPrograms::find($program_id);

    	$pdf = PDF::loadView('pdf.program',['program'=> $program]);
    	return $pdf->stream('program_'. $program->name .'pdf');

    }

    public function getHierachicalReport($course_id){

    	$course = Courses::find($course_id);
    	
    	$pdf = PDF::loadView('pdf.course',['course'=>$course]);
    	return $pdf->stream('course_'. $course->name .'.pdf');
    }

    public function testPdf(){
    	$pdf = PDF::loadView('pdf.test');
    	return $pdf->stream('test.pdf');
    }
}
