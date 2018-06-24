<?php

namespace App\Http\Controllers\Relations;

use App\User;
use App\Courses;
use App\Faculties;
use App\UserAdminRelation;
use App\UserFacultyRelation;
use App\CoursePrerequisiteRelation;
use App\UserAcademicProgramRelation;
use Illuminate\Support\Facades\Facade;


class RelationsFacade extends Facade {

	/*public static function getFacadeAccessor(){
		return 'relations';
	}*/

	public static function getProgramRelation($user_id){
		$program = UserAcademicProgramRelation::where('user_id',$user_id)->first();
		return $program;
	}

	public static function getFacultyRelation($user_id){
		$faculty = UserFacultyRelation::where('user_id',$user_id)->first();
		return $faculty;
	}

	public static function getAdminRelation($user_id){
		$admin = UserAdminRelation::where('user_id',$user_id)->first();
		return $admin;
	}

	public static function resolveRole($user_id){
		$faculty = UserFacultyRelation::where('user_id',$user_id)->first();
		if(!is_null($faculty))
			return $faculty->role;
		
		$program = UserAcademicProgramRelation::where('user_id',$user_id)->first();
		if(!is_null($program))
			return $program->role;

		$admin = UserAdminRelation::where('user_id',$user_id)->first();
		if(!is_null($admin))
			return $admin->role;
		
		return -1;
	}

	public static function relationTree($user_id){
		/*$faculty_id = UserFacultyRelation::where('user_id',$user_id)->first();
		if($faculty_id){
			$faculty = Faculties::find(faculty_id);
			if($faculty)
				return $faculty->name;
		}

		$program = UserAcademicProgramRelation::where('user_id',$user_id)->first();

		if(!is_null($program))
			return $program;

		$admin = UserAdminRelation::where('user_id',$user_id)->first();
		if(!is_null($admin))
			return $admin;
		*/
		return null;
	}

	public static function getRelation($user_id){
		$faculty = UserFacultyRelation::where('user_id',$user_id)->first();
		if(!is_null($faculty))
			return $faculty;

		$program = UserAcademicProgramRelation::where('user_id',$user_id)->first();

		if(!is_null($program))
			return $program;

		$admin = UserAdminRelation::where('user_id',$user_id)->first();
		if(!is_null($admin))
			return $admin;
		
		return null;
	}

	public static function bindUserFaculty($user_id,$role,$faculty_id){
		$relation = new UserFacultyRelation;
		$relation->user_id = $user_id;
		$relation->role= $role;
		$relation->faculty_id = $faculty_id;

		return $relation->save();		
	}

	public static function bindUserProgram($user_id,$role,$program_id){
		$relation = new UserAcademicProgramRelation;
		$relation->user_id = $user_id;
		$relation->role= $role;
		$relation->program_id = $program_id;

		return $relation->save();		
	}

	public static function isFacultyBinded($user_id){
		$faculty = UserFacultyRelation::where('user_id',$user_id)->first();
		return !is_null($faculty);
	}

	public static function isProgramBinded($user_id){
		$program = UserAcademicProgramRelation::where('user_id',$user_id)->first();
		return !is_null($program);
	}

	public static function isAdmin($user_id){
		$user = UserAdminRelation::where('user_id',$user_id)->first();
		
		if(!is_null($user))
			return $user->role == 0;

		return false;
	}

	public static function isTeacher($user_id){
		$user = UserAcademicProgramRelation::where('user_id',$user_id)->first();
		
		if(!is_null($user))
			return $user->role == 1;

		return false;
	}

	public static function isDirector($user_id){
		$user = UserAcademicProgramRelation::where('user_id',$user_id)->first();
		
		if(!is_null($user))
			return $user->role == 2;

		return false;
	}

	public static function isDean($user_id){
		$user = UserFacultyRelation::where('user_id',$user_id)->first();
		
		if(!is_null($user))
			return $user->role == 3;

		return false;
	}

	public static function bindCoursePrerequisite($course_id,$prerequisite){
		$relation = CoursePrerequisiteRelation::where('course_id',$course_id)->where('prerequisite',$prerequisite)->first();
		if(is_null($relation))
			$relation = new CoursePrerequisiteRelation;
		$relation->course_id = $course_id;
		$relation->prerequisite = $prerequisite;
		return $relation->save();
	}

	public static function unbindCoursePrerequisite($course_id,$prerequisite_id){
		$relation = CoursePrerequisiteRelation::where('course_id',$course_id)->where('prerequisite',$prerequisite_id)->first();
		if(is_null($relation))
			return false;

		return $relation->delete();
	}

	public static function getCoursePrerequisites($course_id){
		$relation = CoursePrerequisiteRelation::where('course_id',$course_id)->get();
		$preList = [];
		foreach($relation as $row){
			$course = Courses::find($row->prerequisite);
			array_push($preList, $course);
		}

		return $preList;
	}
	
}