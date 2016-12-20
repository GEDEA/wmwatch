<?php
$tracked = array(
'amk_watch_xenofilove.html',
'amk_watch_imigranti.html',
'amk_watch_hnusaci.html',
'amk_watch_neomarxiste.html'
);

$prevRev = exec(escapeshellcmd('git rev-parse HEAD^1'));

foreach ($tracked as $file) {
	echo exec('git diff --no-color '.$prevRev.' -- ' . $file . ' > tmpdiff.txt');
	
	$lines = file('tmpdiff.txt');
	$added = array();
	foreach ($lines as $line) {
		if (strpos($line, '+')===0) {
			$matches = array();
			if (preg_match('~<b>(.+)</b>~', $line, $matches)) {
				$added[] = $matches[1];
			}
		}
	}
	
	if (count($added)) {
		echo '## ' . $file . ': ' . PHP_EOL;
		echo ' ' . PHP_EOL;
		foreach ($added as $name) {
			echo ' - ' . $name . PHP_EOL;
		}
		echo ' ' . PHP_EOL;
	}
	
}

exec('rm tmpdiff.txt');
