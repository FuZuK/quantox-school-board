<?php
namespace Controllers;

class SchoolStudentGrades extends Base
{
    public function create($arguments, $data) {
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
            return $this->redirectWithError('/schools/' . $school['id'], 'School student is not found');
        }

        $stmt = $connection->prepare(
            'SELECT COUNT(*) FROM `school_student_grades` WHERE `school_student_id` = ?'
        );
        $stmt->execute([ $student['id'] ]);
        $grades_number = $stmt->fetchColumn();

        if ($grades_number >= $this->config['grades']['max']) {
            return $this->redirectWithError(
                '/schools/' . $school['id'],
                'The maximum number of grades was defined for this student'
            );
        }

        return $this->view('schools/students/grades/create', [
            'school' => $school,
            'student' => $student,
            'range' => $this->config['grades']['range']
        ]);
    }

    public function insert($arguments, $data) {
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
            return $this->redirectWithError('/schools/' . $school['id'], 'School student is not found');
        }

        $stmt = $connection->prepare(
            'SELECT COUNT(*) FROM `school_student_grades` WHERE `school_student_id` = ?'
        );
        $stmt->execute([ $student['id'] ]);
        $grades_number = $stmt->fetchColumn();

        if ($grades_number >= $this->config['grades']['max']) {
            return $this->redirectWithError(
                '/schools/' . $school['id'],
                'The maximum number of grades was defined for this student'
            );
        }

        if (!array_key_exists('grade', $data) || empty($data['grade'])) {
            return $this->redirectWithError('/schools/' . $school['id'], 'Invalid grade');
        }

        $grade = intval($data['grade']);

        if ($grade < $this->config['grades']['range']['from'] || $grade > $this->config['grades']['range']['to']) {
            return $this->redirectWithError('/schools/' . $school['id'], 'Invalid grade');
        }

        $stmt = $connection->prepare(
            'INSERT INTO `school_student_grades` (`school_id`, `school_student_id`, `grade`) ' .
            'VALUES (?, ?, ?)'
        );
        $stmt->execute([ $school['id'], $student['id'], $grade ]);

        return $this->redirectWithMessage('/schools/' . $school['id'], 'Grade successfully added');
    }
}