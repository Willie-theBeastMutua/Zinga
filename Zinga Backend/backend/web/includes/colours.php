<?php
function colours()
{
	$colourArray = array(
					array('Name'=>'AliceBlue ','Code'=>'#F0F8FF'),
					array('Name'=>'AntiqueWhite ','Code'=>'#FAEBD7'),
					array('Name'=>'Aqua ','Code'=>'#00FFFF'),
					array('Name'=>'Aquamarine ','Code'=>'#7FFFD4'),
					array('Name'=>'Azure ','Code'=>'#F0FFFF'),
					array('Name'=>'Beige ','Code'=>'#F5F5DC'),
					array('Name'=>'Bisque ','Code'=>'#FFE4C4'),
					array('Name'=>'Black ','Code'=>'#000000'),
					array('Name'=>'BlanchedAlmond ','Code'=>'#FFEBCD'),
					array('Name'=>'Blue ','Code'=>'#0000FF'),
					array('Name'=>'BlueViolet ','Code'=>'#8A2BE2'),
					array('Name'=>'Brown ','Code'=>'#A52A2A'),
					array('Name'=>'BurlyWood ','Code'=>'#DEB887'),
					array('Name'=>'CadetBlue ','Code'=>'#5F9EA0'),
					array('Name'=>'Chartreuse ','Code'=>'#7FFF00'),
					array('Name'=>'Chocolate ','Code'=>'#D2691E'),
					array('Name'=>'Coral ','Code'=>'#FF7F50'),
					array('Name'=>'CornflowerBlue ','Code'=>'#6495ED'),
					array('Name'=>'Cornsilk ','Code'=>'#FFF8DC'),
					array('Name'=>'Crimson ','Code'=>'#DC143C'),
					array('Name'=>'Cyan ','Code'=>'#00FFFF'),
					array('Name'=>'DarkBlue ','Code'=>'#00008B'),
					array('Name'=>'DarkCyan ','Code'=>'#008B8B'),
					array('Name'=>'DarkGoldenRod ','Code'=>'#B8860B'),
					array('Name'=>'DarkGray ','Code'=>'#A9A9A9'),
					array('Name'=>'DarkGreen ','Code'=>'#006400'),
					array('Name'=>'DarkKhaki ','Code'=>'#BDB76B'),
					array('Name'=>'DarkMagenta ','Code'=>'#8B008B'),
					array('Name'=>'DarkOliveGreen ','Code'=>'#556B2F'),
					array('Name'=>'DarkOrange ','Code'=>'#FF8C00'),
					array('Name'=>'DarkOrchid ','Code'=>'#9932CC'),
					array('Name'=>'DarkRed ','Code'=>'#8B0000'),
					array('Name'=>'DarkSalmon ','Code'=>'#E9967A'),
					array('Name'=>'DarkSeaGreen ','Code'=>'#8FBC8F'),
					array('Name'=>'DarkSlateBlue ','Code'=>'#483D8B'),
					array('Name'=>'DarkSlateGray ','Code'=>'#2F4F4F'),
					array('Name'=>'DarkTurquoise ','Code'=>'#00CED1'),
					array('Name'=>'DarkViolet ','Code'=>'#9400D3'),
					array('Name'=>'DeepPink ','Code'=>'#FF1493'),
					array('Name'=>'DeepSkyBlue ','Code'=>'#00BFFF'),
					array('Name'=>'DimGray ','Code'=>'#696969'),
					array('Name'=>'DodgerBlue ','Code'=>'#1E90FF'),
					array('Name'=>'FireBrick ','Code'=>'#B22222'),
					array('Name'=>'FloralWhite ','Code'=>'#FFFAF0'),
					array('Name'=>'ForestGreen ','Code'=>'#228B22'),
					array('Name'=>'Fuchsia ','Code'=>'#FF00FF'),
					array('Name'=>'Gainsboro ','Code'=>'#DCDCDC'),
					array('Name'=>'GhostWhite ','Code'=>'#F8F8FF'),
					array('Name'=>'Gold ','Code'=>'#FFD700'),
					array('Name'=>'GoldenRod ','Code'=>'#DAA520'),
					array('Name'=>'Gray ','Code'=>'#808080'),
					array('Name'=>'Green ','Code'=>'#008000'),
					array('Name'=>'GreenYellow ','Code'=>'#ADFF2F'),
					array('Name'=>'HoneyDew ','Code'=>'#F0FFF0'),
					array('Name'=>'HotPink ','Code'=>'#FF69B4'),
					array('Name'=>'IndianRed  ','Code'=>'#CD5C5C'),
					array('Name'=>'Indigo  ','Code'=>'#4B0082'),
					array('Name'=>'Ivory ','Code'=>'#FFFFF0'),
					array('Name'=>'Khaki ','Code'=>'#F0E68C'),
					array('Name'=>'Lavender ','Code'=>'#E6E6FA'),
					array('Name'=>'LavenderBlush ','Code'=>'#FFF0F5'),
					array('Name'=>'LawnGreen ','Code'=>'#7CFC00'),
					array('Name'=>'LemonChiffon ','Code'=>'#FFFACD'),
					array('Name'=>'LightBlue ','Code'=>'#ADD8E6'),
					array('Name'=>'LightCoral ','Code'=>'#F08080'),
					array('Name'=>'LightCyan ','Code'=>'#E0FFFF'),
					array('Name'=>'LightGoldenRodYellow ','Code'=>'#FAFAD2'),
					array('Name'=>'LightGray ','Code'=>'#D3D3D3'),
					array('Name'=>'LightGreen ','Code'=>'#90EE90'),
					array('Name'=>'LightPink ','Code'=>'#FFB6C1'),
					array('Name'=>'LightSalmon ','Code'=>'#FFA07A'),
					array('Name'=>'LightSeaGreen ','Code'=>'#20B2AA'),
					array('Name'=>'LightSkyBlue ','Code'=>'#87CEFA'),
					array('Name'=>'LightSlateGray ','Code'=>'#778899'),
					array('Name'=>'LightSteelBlue ','Code'=>'#B0C4DE'),
					array('Name'=>'LightYellow ','Code'=>'#FFFFE0'),
					array('Name'=>'Lime ','Code'=>'#00FF00'),
					array('Name'=>'LimeGreen ','Code'=>'#32CD32'),
					array('Name'=>'Linen ','Code'=>'#FAF0E6'),
					array('Name'=>'Magenta ','Code'=>'#FF00FF'),
					array('Name'=>'Maroon ','Code'=>'#800000'),
					array('Name'=>'MediumAquaMarine ','Code'=>'#66CDAA'),
					array('Name'=>'MediumBlue ','Code'=>'#0000CD'),
					array('Name'=>'MediumOrchid ','Code'=>'#BA55D3'),
					array('Name'=>'MediumPurple ','Code'=>'#9370DB'),
					array('Name'=>'MediumSeaGreen ','Code'=>'#3CB371'),
					array('Name'=>'MediumSlateBlue ','Code'=>'#7B68EE'),
					array('Name'=>'MediumSpringGreen ','Code'=>'#00FA9A'),
					array('Name'=>'MediumTurquoise ','Code'=>'#48D1CC'),
					array('Name'=>'MediumVioletRed ','Code'=>'#C71585'),
					array('Name'=>'MidnightBlue ','Code'=>'#191970'),
					array('Name'=>'MintCream ','Code'=>'#F5FFFA'),
					array('Name'=>'MistyRose ','Code'=>'#FFE4E1'),
					array('Name'=>'Moccasin ','Code'=>'#FFE4B5'),
					array('Name'=>'NavajoWhite ','Code'=>'#FFDEAD'),
					array('Name'=>'Navy ','Code'=>'#000080'),
					array('Name'=>'OldLace ','Code'=>'#FDF5E6'),
					array('Name'=>'Olive ','Code'=>'#808000'),
					array('Name'=>'OliveDrab ','Code'=>'#6B8E23'),
					array('Name'=>'Orange ','Code'=>'#FFA500'),
					array('Name'=>'OrangeRed ','Code'=>'#FF4500'),
					array('Name'=>'Orchid ','Code'=>'#DA70D6'),
					array('Name'=>'PaleGoldenRod ','Code'=>'#EEE8AA'),
					array('Name'=>'PaleGreen ','Code'=>'#98FB98'),
					array('Name'=>'PaleTurquoise ','Code'=>'#AFEEEE'),
					array('Name'=>'PaleVioletRed ','Code'=>'#DB7093'),
					array('Name'=>'PapayaWhip ','Code'=>'#FFEFD5'),
					array('Name'=>'PeachPuff ','Code'=>'#FFDAB9'),
					array('Name'=>'Peru ','Code'=>'#CD853F'),
					array('Name'=>'Pink ','Code'=>'#FFC0CB'),
					array('Name'=>'Plum ','Code'=>'#DDA0DD'),
					array('Name'=>'PowderBlue ','Code'=>'#B0E0E6'),
					array('Name'=>'Purple ','Code'=>'#800080'),
					array('Name'=>'RebeccaPurple ','Code'=>'#663399'),
					array('Name'=>'Red ','Code'=>'#FF0000'),
					array('Name'=>'RosyBrown ','Code'=>'#BC8F8F'),
					array('Name'=>'RoyalBlue ','Code'=>'#4169E1'),
					array('Name'=>'SaddleBrown ','Code'=>'#8B4513'),
					array('Name'=>'Salmon ','Code'=>'#FA8072'),
					array('Name'=>'SandyBrown ','Code'=>'#F4A460'),
					array('Name'=>'SeaGreen ','Code'=>'#2E8B57'),
					array('Name'=>'SeaShell ','Code'=>'#FFF5EE'),
					array('Name'=>'Sienna ','Code'=>'#A0522D'),
					array('Name'=>'Silver ','Code'=>'#C0C0C0'),
					array('Name'=>'SkyBlue ','Code'=>'#87CEEB'),
					array('Name'=>'SlateBlue ','Code'=>'#6A5ACD'),
					array('Name'=>'SlateGray ','Code'=>'#708090'),
					array('Name'=>'Snow ','Code'=>'#FFFAFA'),
					array('Name'=>'SpringGreen ','Code'=>'#00FF7F'),
					array('Name'=>'SteelBlue ','Code'=>'#4682B4'),
					array('Name'=>'Tan ','Code'=>'#D2B48C'),
					array('Name'=>'Teal ','Code'=>'#008080'),
					array('Name'=>'Thistle ','Code'=>'#D8BFD8'),
					array('Name'=>'Tomato ','Code'=>'#FF6347'),
					array('Name'=>'Turquoise ','Code'=>'#40E0D0'),
					array('Name'=>'Violet ','Code'=>'#EE82EE'),
					array('Name'=>'Wheat ','Code'=>'#F5DEB3'),
					array('Name'=>'White ','Code'=>'#FFFFFF'),
					array('Name'=>'WhiteSmoke ','Code'=>'#F5F5F5'),
					array('Name'=>'Yellow ','Code'=>'#FFFF00'),
					array('Name'=>'YellowGreen ','Code'=>'#9ACD32')
	);
	return $colourArray;
}

function get_colour()
{
	$id = rand(0,140);
	$colourArray = colours();
	$ColourCode = $colourArray[$id]['Code'];
	return $ColourCode;
}