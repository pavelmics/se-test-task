<?php

use Symfony\Component\HttpFoundation\Request;
use Illuminate\Database\Capsule\Manager as DB;
use Models\Teacher;
use Models\Student;
use Models\BaseModel;
use Models\StudentTeacher;
use Models\Enum;


/**
 * Factory for rest controllers
 *
 * @param Silex\Application $app
 */
return function(Silex\Application &$app) {


    /**
     * Generate model to hash with submodels
     * @param BaseModel $m
     * @param array $with
     * @return array
     */
    $modelToArray = function(BaseModel $m, $with = []) {
        $current = $m->getAttributes();
        foreach($with as $r) {
            $current[$r] = $m->$r;
        }
        $result[] = $current;

        return $current;
    };

    /**
     * Returns model json representation with relations
     *
     * @param BaseModel[] $models
     * @param $with
     * @returns array[]
     * @todo: modelToArray
     */
    $modelsToArray = function($models, array $with = []) {
        $result = [];
        foreach ($models as $m) {
            $current = $m->getAttributes();
            foreach($with as $r) {
                $current[$r] = $m->$r;
            }
            $result[] = $current;
        }

        return $result;
    };

    // rest route namespace
    $rest = $app['controllers_factory'];

    /**
     * list of teachers
     */
    $rest->get('/teachers', function() use($app) {
        $limit = $app['request']->get('limit', 10);
        $offset = $app['request']->get('offset', 0);

        $teachers = Teacher::limit($limit)
            ->offset($offset)
            ->orderBy('created_at', 'desc')
            ->studentCount()
            ->get();

        return $app->json($teachers);
    });

    $rest->get('/teachers/{id}', function($id) use($app, $modelToArray) {
        $teacher = Teacher::findOrFail($id);

        return $app->json($modelToArray($teacher, ['students']));
    })->assert('id', '\d+');

    /**
     * Count of teachers
     */
    $rest->get('/teachers/count', function() use($app) {
        $count = Teacher::all()->count();

        return $app->json(['count' => $count]);
    });

    /**
     * Teacher creation
     */
    $rest->post('/teachers', function(Request $req) use($app) {
        $data = $req->request->all();
        $teacher = new Teacher($data);

        try {
            $teacher->validate();
            $teacher->save();
            return $app->json($teacher, 201);
        } catch(\Models\ValidationException $e) {
            return $app->json(['errors' => $e->getErrors()], 400);
        }
    });

    /**
     * Teachers with april-born students
     */
    $rest->get('/teachers/april-born', function() use($app) {
        $teachers = Teacher::aprilBornStudents()->get();

        return $app->json($teachers);
    });

    /**
     * Get students
     */
    $rest->get('/students', function() use($app, $modelsToArray) {
        $limit = $app['request']->get('limit', 10);
        $offset = $app['request']->get('offset', 0);
        $students = Student::limit($limit)
            ->offset($offset)
            ->orderBy('created_at', 'desc')
            ->get();

        return $app->json($modelsToArray($students, ['level']));
    });

    /**
     * Count of students
     */
    $rest->get('/students/count', function() use($app) {
        $count = Student::all()->count();

        return $app->json(['count' => $count]);
    });

    /**
     * Student by id
     */
    $rest->get('/students/{id}', function($id) use($app, $modelToArray) {
        $model = Student::findOrFail($id);

        return $app->json($modelToArray($model, ['level']));
    })->assert('id', '\d+');

    /**
     * Search students
     */
    $rest->get('/students/search', function() use ($app) {
        $q = addslashes($app['request']->get('query'));
        $search = strtolower($q) . '%';

        $result = DB::select("SELECT `id`
          FROM `students`
          WHERE `name` LIKE '$search';
        ");

        $result = array_map(
            function($itm) { return $itm['id']; }
            , $result
        );

        $students = Student::whereIn('id', $result)->get();

        return $app->json($students);
    });

    /**
     * Student creation
     */
    $rest->post('/students', function(Request $req) use($app) {
        $data = $req->request->all();
        $s = new Student($data);

        try {
            $s->validate();
            $s->save();
            return $app->json($s, 201);
        } catch(\Models\ValidationException $e) {
            return $app->json(['errors' => $e->getErrors()], 400);
        }
    });

    /**
     * Bind teacher to student
     */
    $rest->post('/student-teacher', function(Request $req) use($app) {
        $data = $req->request->all();
        $st = new StudentTeacher($data);

        try {
            $st->validate();
            $st->save();
            return $app->json($st, 201);
        } catch(\Models\ValidationException $e) {
            return $app->json(['errors' => $e->getErrors()], 400);
        }
    });

    /**
     * List of language levels
     */
    $rest->get('/language-levels', function() use($app) {
        $levels = Enum::get('language_levels.*');

        return $app->json($levels);
    });


    $app->mount('/rest', $rest);
};