# PaperCloudBackend [![Build Status](https://travis-ci.org/C-Lyrics/PaperCloudBackend.svg?branch=master)](https://travis-ci.org/C-Lyrics/PaperCloudBackend)

Continuous Testing Results:
4/24
~phpunit --bootstrap IEEE.php tests/IEEETest.php
PHPUnit 4.5.0 by Sebastien Bergmann and contributors.

.......

Time: 14.92 seconds, Memory: 4.25Mb

OK (6 tests, 28 assertions)

~phpunit --bootstrap arxiv.php tests/arxivTest.php
PHPUnit 4.5.0 by Sebastien Bergmann and contributors.

.....

Time: 3.17 seconds, Memory: 12.75Mb

OK (6 tests, 29 assertions)

4/26
PHPUnit 4.5.0 by Sebastian Bergmann and contributors.
......
Time: 4.4 seconds, Memory: 4.00Mb
OK (6 tests, 28 assertions)
The command "phpunit --bootstrap IEEE.php tests/IEEETest.php" exited with 0.
3.93s$ phpunit --bootstrap arxiv.php tests/arxivTest.php
PHPUnit 4.5.0 by Sebastian Bergmann and contributors.
......
Time: 3.85 seconds, Memory: 14.25Mb
OK (6 tests, 29 assertions)
The command "phpunit --bootstrap arxiv.php tests/arxivTest.php" exited with 0.
Done. Your build exited with 0.
