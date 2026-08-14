<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$content = view('recordjob.index', ['jobs' => collect([])])->render();
echo 'View render OK'.PHP_EOL;
