<?php

// обрезает заголовок на $count - символов, в конце подставляет $after
// в коде вместо <?php the_title();  нужно писать н-р, <?php trim_title_chars(30, '...');
function trim_title_chars($count, $after) {
	$title = get_the_title();
	if (mb_strlen($title) > $count) $title = mb_substr($title, 0, $count);
	else $after = '';
	echo $title . $after;
}

// обрезает заголовок на $count - слов, в конце подставляет $after
// в коде вместо <?php the_title();  нужно писать н-р, <?php trim_title_words(5, '...');
function trim_title_words($count, $after) {
	$title = get_the_title();
	$words = explode(' ', $title);
	if (count($words) > $count) {
		array_splice($words, $count);
		$title = implode(' ', $words);
	}
	else $after = '';
	echo $title . $after;
}

