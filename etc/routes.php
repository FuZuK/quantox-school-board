<?php

return [
    'GET /' => 'Schools.list',
    'GET /schools' => 'Schools.list',
    'GET /schools/create' => 'Schools.create',
    'POST /schools/create' => 'Schools.insert',
    'GET /schools/:id' => 'Schools.show',
    'POST /schools/:id/delete' => 'Schools.delete'
];
