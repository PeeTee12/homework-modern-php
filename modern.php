<?php
function callback() {
  echo "Log messages:\n";
}
function getLines(string $input, string $pattern, array $filters) {
  $file = fopen($input, "r");
  $stats = [];
  while($line = fgets($file)) {
    echo $line;
    if (preg_match($pattern, $line, $matches)) {
      $level = strtolower($matches[1]);
    }
    if (!in_array($level, $filters)) {
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

$stats = getLines('example.log', '/test\.(\w+)/', ['warning', 'alert']);
asort($stats);
call_user_func('callback');
foreach ($stats as $level => $count) {
  echo "$level: $count\n";
}
