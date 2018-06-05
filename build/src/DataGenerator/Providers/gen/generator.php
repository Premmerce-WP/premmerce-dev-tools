<?php

require_once __DIR__ . '/mix.php';

//$prefixes = ['Graphics', 'Core', 'Main', 'Central', 'General', 'Micro', 'Sound'];
//$bases = ['CPU', 'Processor'];
//$suffixes = ['Model', 'Name'];
//$value = '{{processorName}}';


//$prefixes = ['Operating', 'Computer', 'Available'];
//$bases = ['System', 'Platform', 'OS'];
//$suffixes = [];
//$value = '{{operatingSystem}}';

//$prefixes = ['Available'];
//$bases = ['RAM', 'Memory', 'Hard Drive', 'Flash Memory', 'Storage'];
//$suffixes = ['Size', 'Capacity', 'Memory'];
//$value = '{{powTwo}} {{ciPrefix}}B';


//$prefixes = ['CPU', 'Processor', 'Max'];
//$bases = ['Speed', 'Speed (Hz)'];
//$suffixes = [];
//$value = '#.# {{ciPrefix}}Hz';


//$prefixes = [
//    'Furniture','Secondary', 'Wood', 'Frame', 'Main', 'Front', 'Textile', 'Logo', 'Image', 'Base', 'Picture', 'Top', 'Bottom', 'Side',
//];
//$bases = ['Color','Tone','Colour'];
//$suffixes = [];
//
//$value = '{{colorName}}';

//$prefixes = [
//    'Furniture', 'Desc', 'Secondary', 'Wood', 'Frame', 'Main', 'Logo', 'Image', 'Base',
//];
//$bases = ['Design'];
//$suffixes = [];
//
//$value = '{{shape}} {{colorName}}';


//$prefixes = [
//    'Secondary', 'Main', 'Base',
//];
//$bases = ['Display'];
//$suffixes = ['Type', 'Technology'];
//
//$value = '{{displayType}}';

//'Connectivity Technology' => '*{{intSize}}*',
//        'Connection Type'         => '*{{connectionType}} {{suffix}}',
//        'Protocol Compatibility'  => '*{{connectionType}} {{suffix}}',
//        'Gateway Compatibility'   => '*{{connectionType}} {{suffix}}',
//        'Interface'               => '*{{connectionType}} {{suffix}}',
//        'Connectivity Type'       => '*{{connectionType}} {{suffix}}',

//$prefixes = [
//    'Main', 'Base', 'Secondary',
//];
//$bases = ['File System', 'FS'];
//
//$suffixes = ['Type', 'Compatibility'];
//
//$value = '*{{fileSystem}} {{suffix}}';


$items = mix($bases, $prefixes, $suffixes, $value);

file_put_contents(__DIR__ . '/out.php', '<?php return ' . var_export($items, true) . ";\n");

