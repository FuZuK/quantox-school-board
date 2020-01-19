<?php
namespace Controllers;

class Schools extends Base
{
    public function list() {
        $connection = \Database::getConnection();
        $stmt = $connection->prepare(
            'SELECT *, (SELECT COUNT(*) FROM `school_students` WHERE `school_id` = `schools`.`id`) ' .
            'AS `number_of_students` FROM `schools` ORDER BY `name` ASC'
        );
        $stmt->execute();
        $schools = $stmt->fetchAll();
        $boards = $this->config['boards'];
        $schools = array_map(function ($school) use ($boards) {
            $school['board_info'] = current(array_filter($boards, function ($board) use ($school) {
                return $board['id'] === $school['board'];
            }));

            return $school;
        }, $schools);

        return $this->view('schools/list', [
            'schools' => $schools
        ]);
    }

    public function create() {
        $boards = $this->config['boards'];

        return $this->view('schools/create', [
            'boards' => $boards
        ]);
    }

    public function insert($arguments, $data) {
        if (!array_key_exists('name', $data) || empty($data['name'])) {
            return $this->redirectWithError('/schools/create', 'Enter school name please');
        }

        $boards = $this->config['boards'];
        $boardsIds = array_column($boards, 'id');

        if (!array_key_exists('board', $data) || empty($data['board']) || !in_array($data['board'], $boardsIds)) {
            return $this->redirectWithError('/schools/create', 'Select board please');
        }

        $connection = \Database::getConnection();
        $stmt = $connection->prepare('INSERT INTO `schools` (`name`, `board`) VALUES (?, ?)');
        $stmt->execute([ $data['name'], $data['board'] ]);

        return $this->redirectWithMessage('/schools', 'School successfully created');
    }

    public function show($arguments) {
        $connection = \Database::getConnection();
        $stmt = $connection->prepare('SELECT * FROM `schools` WHERE `id` = ?');
        $stmt->execute([ $arguments['id'] ]);
        $school = $stmt->fetch();

        if (!$school) {
            return $this->redirectWithError('/', 'School is not found');
        }

        return $this->view('schools/show', [
            'school' => $school
        ]);
    }

    public function delete($arguments) {
        $connection = \Database::getConnection();
        $stmt = $connection->prepare('SELECT * FROM `schools` WHERE `id` = ?');
        $stmt->execute([ $arguments['id'] ]);
        $school = $stmt->fetch();

        if (!$school) {
            return $this->redirectWithError('/', 'School is not found');
        }

        $connection->prepare('DELETE FROM `school_student_grades` WHERE `school_id` = ?')
            ->execute([ $arguments['id'] ]);
        $connection->prepare('DELETE FROM `school_students` WHERE `school_id` = ?')
            ->execute([ $arguments['id'] ]);
        $connection->prepare('DELETE FROM `schools` WHERE `id` = ?')->execute([ $arguments['id'] ]);

        return $this->redirectWithMessage('/schools', 'School successfully deleted');
    }
}