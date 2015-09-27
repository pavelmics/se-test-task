<?php
namespace Models;

use Symfony\Component\Validator\Constraints as Assert;

class StudentTeacher extends BaseModel
{
    /**
     * todo: rename table
     * @var string
     */
    protected $table = 'teacher_student';

    protected $fillable = ['student_id', 'teacher_id'];

    public function rules()
    {
        return new Assert\Collection([
            'teacher_id' => new Assert\NotBlank(),
            'student_id' => [
                new Assert\NotBlank()
                , new Validators\UniqueFieldConstraint($this, [
                    'student_id', 'teacher_id'])
            ],
        ]);
    }
} 