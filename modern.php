<?php
class Log {
  function callback() {
    echo "Log messages:\n";
  }
  function getStats(string $inputFile, string $pattern, array $filters) : iterable {
    $file = fopen($inputFile, "r");
    $stats = [];
    $level = "";
    while($line = fgets($file)) {
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
}
$printLog = function (iterable $stats) {
  $logLines = "";
  foreach ($stats as $level => $count) {
    if ($level) {
      $logLines .= "$level: $count\n";
    }
  }
  if ($logLines)
    return $logLines;
  else
    return 'No messages found.';
};

// volání
$log = new Log();
call_user_func(array($log, 'callback'));
$stats = $log->getStats('example.log', '/test\.(\w+)/', ['warning', 'alert']);
echo $printLog($stats);