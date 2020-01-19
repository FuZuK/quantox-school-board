<?php
namespace Controllers;

class SchoolStudents extends Base
{
    public function create($arguments) {
        $connection = \Database::getConnection();
        $stmt = $connection->prepare('SELECT * FROM `schools` WHERE `id` = ?');
        $stmt->execute([ $arguments['id'] ]);
        $school = $stmt->fetch();

        if (!$school) {
            return $this->redirectWithError('/', 'School is not found');
        }

        return $this->view('schools/students/create', [
            'school' => $school
        ]);
    }

    public function insert($arguments, $data) {
        $connection = \Database::getConnection();
        $stmt = $connection->prepare('SELECT * FROM `schools` WHERE `id` = ?');
        $stmt->execute([ $arguments['id'] ]);
        $school = $stmt->fetch();

        if (!$school) {
            return $this->redirectWithError('/', 'School is not found');
        }

        if (!array_key_exists('first_name', $data) || empty($data['first_name'])) {
            return $this->redirectWithError(
                '/schools/' . $school['id'] . '/students/create',
                'Enter first name please'
            );
        }

        if (!array_key_exists('last_name', $data) || empty($data['last_name'])) {
            return $this->redirectWithError(
                '/schools/' . $school['id'] . '/students/create',
                'Enter last name please'
            );
        }

        $stmt = $connection->prepare(
            'INSERT INTO `school_students` (school_id, first_name, last_name) VALUES (?, ?, ?)'
        );
        $stmt->execute([ $school['id'], $data['first_name'], $data['last_name'] ]);

        return $this->redirectWithMessage('/schools/' . $school['id'], 'Student successfully added');
    }

    public function delete($arguments) {
        $connection = \Database::getConnection();
        $stmt = $connection->prepare('SELECT * FROM `schools` WHERE `id` = ?');
        $stmt->execute([ $arguments['school_id'] ]);
        $school = $stmt->fetch();

        if (!$school) {
            return $this->redirectWithError('/', 'School is not found');
        }

        $stmt = $connection->prepare('SELECT * FROM `school_students` WHERE `school_id` = ? AND `id` = ?');
        $stmt->execute([ $arguments['school_id'], $arguments['student_id'] ]);
        $student = $stmt->fetch();

        if (!$student) {
            return $this->redirectWithError('/', 'School student is not found');
        }

        $connection->prepare('DELETE FROM `school_student_grades` WHERE `school_student_id` = ?')
            ->execute([ $arguments['student_id'] ]);
        $connection->prepare('DELETE FROM `school_students` WHERE `id` = ?')
            ->execute([ $arguments['student_id'] ]);

        return $this->redirectWithMessage('/schools/' . $school['id'], 'Student successfully deleted');
    }
}