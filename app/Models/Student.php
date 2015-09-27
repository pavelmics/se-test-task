<?php

namespace Models;

use Symfony\Component\Validator\Constraints as Assert;

class Student extends BaseModel
{
    protected $fillable = ['name', 'email', 'level_id', 'birth_date'];

    protected function rules()
    {
        return new Assert\Collection([
            'name' => new Assert\NotBlank(),
            'email' => [
                new Assert\NotBlank()
                , new Assert\Email()
                , new Validators\UniqueFieldConstraint($this, ['email'])
            ],
            'level_id' => new Assert\NotBlank(),
            'birth_date' => new Assert\Date(),
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo('\\Models\\Enum', 'level_id');
    }
} 