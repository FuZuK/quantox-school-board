<?php

return [
    'GET /' => 'Schools.list',
    'GET /schools' => 'Schools.list',
    'GET /schools/create' => 'Schools.create',
    'POST /schools/create' => 'Schools.insert',
    'GET /schools/:id' => 'Schools.show',
    'POST /schools/:id/delete' => 'Schools.delete',
    'GET /schools/:id/students/create' => 'SchoolStudents.create',
    'POST /schools/:id/students/create' => 'SchoolStudents.insert',
    'POST /schools/:school_id/students/:student_id/delete' => 'SchoolStudents.delete',
    'GET /schools/:school_id/students/:student_id' => 'SchoolStudents.show'
];
