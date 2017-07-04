<?php
/**
 * Grid CSS
 */

$filler = "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\n";

// build list of units (denominators are keys, values are arrays of nominators)
$units = [1 => [1],];

// keep map to avoid duplicates. keys are rounded to thousands (avoid float issues)
$percentages = [
	'100' => [1, 1],
];

for ($den = 2; $den <= 6; $den++) {
	for ($num = 1; $num < $den; $num++) {
		// avoid duplicates
		$rounded_percentage = (string)round($num / $den, 3);
		if ($num > 1 && isset($percentages[$rounded_percentage])) {
			continue;
		}
		$percentages[$rounded_percentage] = [$num, $den];
		$units[$den][] = $num;
	}
}

// build rows
$rows = [];
$total = 0;
for ($den = 1; $den <= count($units); $den++) {
	// may take multiple rows to use up available units
	while ($units[$den]) {
		$row = [];
		$nom = array_shift($units[$den]);
		$row[] = "$nom/$den";
		$total += $nom;
		if ($total < $den) {
			$nom = $den - $total;
			$row[] = "$nom/$den";
			$total += $nom;
			$index = array_search($nom, $units[$den]);
			if ($index !== false) {
				unset($units[$den][$index]);
			}
		}
		$rows[] = $row;
		$total = 0;
	}
}

?>
<div class="columns">
    <div class="column is-three-quarters">
        <p class="notification is-info">
            <code class="html">is-three-quarters</code>
        </p>
    </div>
    <div class="column">
        <p class="notification is-warning">Auto</p>
    </div>
    <div class="column">
        <p class="notification is-danger">Auto</p>
    </div>
</div>

<div class="columns">
    <div class="column is-two-thirds">
        <p class="notification is-info">
            <code class="html">is-two-thirds</code>
        </p>
    </div>
    <div class="column">
        <p class="notification is-warning">Auto</p>
    </div>
    <div class="column">
        <p class="notification is-danger">Auto</p>
    </div>
</div>

<div class="columns">
    <div class="column is-half">
        <p class="notification is-info">
            <code class="html">is-half</code>
        </p>
    </div>
    <div class="column">
        <p class="notification is-warning">Auto</p>
    </div>
    <div class="column">
        <p class="notification is-danger">Auto</p>
    </div>
</div>

<div class="columns">
    <div class="column is-one-third">
        <p class="notification is-info">
            <code class="html">is-one-third</code>
        </p>
    </div>
    <div class="column">
        <p class="notification is-success">Auto</p>
    </div>
    <div class="column">
        <p class="notification is-warning">Auto</p>
    </div>
</div>

<div class="columns">
    <div class="column is-one-quarter">
        <p class="notification is-info">
            <code class="html">is-one-quarter</code>
        </p>
    </div>
    <div class="column">
        <p class="notification is-success">Auto</p>
    </div>
</div>
