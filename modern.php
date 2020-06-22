<?php
class Log {
  function callback() {
    echo "Log messages:\n";
  }
  function getLines(string $input, string $pattern, array $filters) : iterable {
    $file = fopen($input, "r");
    $stats = [];
    while($line = fgets($file)) {
      if (preg_match($pattern, $line, $matches)) {
        $level = strtolower($matches[1]);
      }
      if (!in_array($level ?? '', $filters)) {
        if (array_key_exists($level, $stats)) {
          $stats[$level]++;
        }
        else {
          $stats[$level] = 1;
        }
      }
    }
    return $stats;
  }
}
$printLog = function ($stats) {
  $lines = "";
  foreach ($stats as $level => $count) {
    $lines .= "$level: $count\n";
  }
  return $lines;
};

// volání
$log = new Log();
call_user_func(array($log, 'callback'));
$stats = $log->getLines('example.log', '/test\.(\w+)/', ['warning', 'alert']);
echo $printLog($stats);