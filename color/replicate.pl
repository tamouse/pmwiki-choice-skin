#!/sw/bin/perl -w

# replicate style sheet for custom colours across all colors schemes

$template = <<EOF;

#nav li a:hover {
	color: COLOR_VALUE;
}

#head h2, #head .sitetag {
	color: COLOR_VALUE;
}

/*#right li a:hover, #right dt a:hover, #right dd a:hover,
.right2 li a:hover, .right2 dt a:hover, .right2 dd a:hover, 
.sidehead a:hover*/
a:hover {
	color: COLOR_VALUE;
	border-bottom: none;
}

h2, .date {
	color: COLOR_VALUE;
}

/*#content a, #content2 a, #foot a, .blogit-listmore a {
	color: COLOR_VALUE;
	border-bottom: 1px dotted colors_VALUE;
}*/
a {
	color: COLOR_VALUE;
	border-bottom: 1px dotted colors_VALUE;
}

img.content, a img.content {
	background-color: COLOR_VALUE;
}

table tr th, thead th, tbody th {
	color: COLOR_VALUE;
}
EOF

$colors{'blue_bold'} = '#3366CC';
$colors{'blue_muted'} = '#82B0BF';
$colors{'green_bold'} = '#6C0';
$colors{'green_muted'} = '#92BF92';
$colors{'orange_bold'} = '#FF9900';
$colors{'orange_muted'} = '#D89C6B';
$colors{'red_bold'} = 'red';
$colors{'red_muted'} = 'FireBrick';
$colors{'purple_bold'} = 'MediumVioletRed';
$colors{'purple_muted'} = 'PaleVioletRed';


while(($scheme, $color) = each(%colors)) {
	open FH, ">$scheme.css";
	$thiscolor = $template;
	$thiscolor =~ s/COLOR_VALUE/$color/msg;
	print FH $thiscolor;
	close FH;
}

