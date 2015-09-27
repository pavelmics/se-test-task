<?php

namespace Console;

use Knp\Command\Command;
use Models\Enum;
use Models\Student;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Models\Teacher;


class GenerateTestDataCommand extends Command
{
    protected $_names = [
        'Aaron', 'Carl', 'Curt', 'Daniel', 'Dean', 'Edgar', 'Evan'
        , 'Fabian', 'Farley', 'Forrest', 'Frasier', 'Gabriel', 'Gilbert'
        , 'Godfrey', 'Gregory', 'Hadden', 'Homer', 'Isaac', 'Ivan'
        , 'Ives', 'Jack', 'Jacob', 'James', 'Jason', 'Jeffrey', 'Jesse',
    ];

    /**
     * @inheritdoc
     */
    public function configure()
    {
        $this
            ->setName("generate-test-data")
            ->setDescription("Generates test data");
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting...');

        // teachers
        $output->writeln('Generating teachers...');
        $this->_generateTeachers(1000);

        // students
        $output->writeln('Generating students...');
        $this->_generateStudents(10000);

        $output->writeln('Finished!');
    }

    /**
     * Generates teachers
     * @param int $amount
     */
    protected function _generateTeachers($amount)
    {
        $phonePrefix = rand(100000, 999999);
        for ($i = 0, $j = $amount; $i !== $j; $i++) {
            $data = [
                'name' => $this->_getName() . '-' . $i,
                'sex' => 1,
                'phone' => $phonePrefix . '-'. $i,
            ];
            $t = new Teacher($data);
            try {
                $t->validate();
                $t->save();
            } catch (\Exception $e) {
                // do nothing
            }
        }
    }

    /**
     * Generates students
     * @param int $amount
     */
    protected function _generateStudents($amount)
    {
        $emailPrefix = rand(100000, 999999);

        for ($i = 0, $j = $amount; $i !== $j; $i++) {
            $name = $this->_getName() . '-' . $i;
            $data = [
                'name' => $name,
                'birth_date' => date('Y-m-d', rand(0, 946684800)), // 2000-01-01
                'email' => $name . $emailPrefix . '-'. $i . '@generated.com',
                'level_id' => Enum::get('language_levels.*')[rand(0, 5)]->id,
            ];

            $s = new Student($data);
            try {
                $s->validate();
                $s->save();
            } catch(\Exception $e) {
                // do nothing
            }
        }
    }

    protected function _getName()
    {
        return $this->_names[rand(0, count($this->_names)-1)];
    }

} 