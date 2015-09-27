<?php

namespace Models;

use Symfony\Component\Validator\Constraints as Assert;
use Illuminate\Database\Capsule\Manager as DB;


class Teacher extends BaseModel
{
    protected $fillable = ['name', 'sex', 'phone'];

    /**
     * @inheritdoc
     */
    protected function rules() {
        return new Assert\Collection([
            'name' => new Assert\NotBlank(),
            'sex' => new Assert\NotBlank(),
            'phone' => [
                new Assert\NotBlank()
                , new Validators\UniqueFieldConstraint($this, ['phone'])
            ],
        ]);
    }

    /**
     * Many To Many across teacher_student table
     */
    public function students()
    {
        return $this->belongsToMany('Models\\Student', 'teacher_student');
    }

    /**
     * Scope for counting students of the teacher
     *
     * @param $query
     * @return mixed
     */
    public function scopeStudentCount($query)
    {
        $query
            ->select(DB::raw('teachers.*, COUNT(teacher_student.id) `students_count`'))
            ->leftJoin('teacher_student'
                , 'teachers.id', '=', 'teacher_student.teacher_id')
            ->groupBy('teachers.id');

        return $query;
    }

    /**
     * Scope for teachers with april-born students
     *
     * @param $query
     * @return mixed
     */
    public function scopeAprilBornStudents($query)
    {
        $query
            ->select('teachers.*')
            ->join('teacher_student'
                , 'teachers.id', '=', 'teacher_student.teacher_id')
            ->join('students'
                , 'teacher_student.student_id', '=', 'students.id')
            ->where(DB::raw('MONTH(students.birth_date)'), '=', '4');

        return $query;
    }
}