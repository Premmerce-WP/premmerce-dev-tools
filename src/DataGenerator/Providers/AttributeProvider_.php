<?php namespace Premmerce\DevTools\DataGenerator\Providers;

use Faker\Provider\Base;

class AttributeProvider_ extends Base
{
    private $attributes = [
        'Processor'               => '{{processorName}}',
        'Graphics Processor'      => '{{processorName}}',
        'Operating System'        => '{{operatingSystem}}',
        'Computer Platform'       => '{{operatingSystem}}',
        'RAM Size'                => '{{powTwo}} {{ciPrefix}}B',
        'RAM Capacity'            => '{{powTwo}} {{ciPrefix}}B',
        'Capacity'                => '{{powTwo}} {{ciPrefix}}B',
        'Storage Memory'          => '{{powTwo}} {{ciPrefix}}B',
        'Memory Capacity'         => '{{powTwo}} {{ciPrefix}}B',
        'Drive Capacity'          => '{{powTwo}} {{ciPrefix}}B',
        'Hard Drive Size'         => '{{intSize}} {{ciPrefix}}B',
        'Flash Size'              => '{{intSize}} {{ciPrefix}}B',
        'CPU Speed'               => '{{dotSize}} {{ciPrefix}}Hz',
        'Color'                   => '{{colorName}}',
        'Frame Finish'            => '{{colorName}}',
        'Wood Finish'             => '{{colorName}}',
        'Furniture Finish'        => '{{colorName}}',
        'Desk Design'             => '{{shape}} {{colorName}}',
        'Design'                  => '{{shape}} {{colorName}}',
        'Display'                 => '{{displayType}}',
        'Display Technology'      => '{{displayType}}',
        'Display Size'            => '{{dotSize}}"',
        'Drive Size'              => '{{dotSizeLarge}} Inch',
        'Aspect Ratio'            => '{{aspectRatio}}',
        'Resolution'              => '{{resolution}}',
        'Native Resolution'       => '{{resolution}}',
        'Display Resolution'      => '{{resolution}}',
        'Weight'                  => '{{dotSize}} {{weightUnit}}',
        'Width'                   => '{{dotSize}} {{lengthUnit}}',
        'Height'                  => '{{dotSize}} {{lengthUnit}}',
        'Length'                  => '{{dotSize}} {{lengthUnit}}',
        'Stool Seat Height'       => '{{dotSize}} {{lengthUnit}}',
        'Box Height'              => '{{dotSize}} {{lengthUnit}}',
        'GPM'                     => '{{dotSize}} GPM',
        'Weight Capacity'         => '{{intSize}} pounds',
        'Pieces in Set'           => '{{intSize}} Pieces',
        'Number of Pieces'        => '{{intSize}} Pieces',
        'Table Length'            => '{{intSize}} Inches',
        'Maximum Pressure'        => '{{intSize}} PSI',
        'Air Flow'                => '{{intSize}} CFM',
        'Power HP'                => '{{dotSizeLarge}} HP',
        'Voltage'                 => '{{dotSizeLarge}} Volts',
        'Optical Zoom'            => '{{dotSizeLarge}}x',
        'Tank Capacity'           => '{{dotSizeLarge}} Gallons',
        'Number of CPU Cores'     => '{{intSize}}',
        'Number of Ports'         => '{{intSize}} Ports',
        'Connectivity Technology' => '{{prefixLight}}{{intSize}}{{suffixLight}}',
        'Connection Type'         => '{{prefixLight}}{{connectionType}} {{suffix}}',
        'Protocol Compatibility'  => '{{prefixLight}}{{connectionType}} {{suffix}}',
        'Gateway Compatibility'   => '{{prefixLight}}{{connectionType}} {{suffix}}',
        'Interface'               => '{{prefixLight}}{{connectionType}} {{suffix}}',
        'Connectivity Type'       => '{{prefixLight}}{{connectionType}} {{suffix}}',
        'File System'             => '{{prefixLight}}{{fileSystem}} {{suffix}}',
        'Rotational Speed'        => '{{intSizeLarge}}00 RPM',
        'Print Resolution'        => '{{intSizeLarge}}00 DPI',
        'Pressure'                => '{{intSizeLarge}} PSI',
        'BTU Output'              => '{{intSizeLarge}}00 BTU',
        'Calories'                => '{{intSizeLarge}} Calories',
        'Heating Area'            => '{{intSizeLarge}} square feet',
        'Brightness'              => '{{intSizeLarge}} Lumens',
        'Contrast Ratio'          => '{{intSizeLarge}},{{threeDigits}}:1',
        'Textile'                 => '{{textile}} {{colorName}}',
        'Cover Material'          => '{{textile}} {{colorName}}',
        'Fabric Type'             => '{{textile}} {{colorName}}',
        'Material'                => '{{material}}',
        'Upholstery Material'     => '{{material}}',
        'Fill Material'           => '{{material}}',
        'Frame Material'          => '{{material}}',
        'Seat Material'           => '{{material}}',
        'Cookware Finish'         => '{{material}}',
        'Cookware Material'       => '{{material}}',
        'Fuel Type'               => '{{material}}',
        'Top Material'            => '{{material}}',
        'Base Material'           => '{{material}}',
        'Surface Material'        => '{{material}}',
        'Activity Type'           => '{{activityType}} {{activitySuffix}}',
        'Activity'                => '{{activityType}} {{activitySuffix}}',
        'Memory Type'             => 'DDR{{versionNum}} {{suffix}}',
        'Case Type'               => '{{prefix}} Towel {{suffix}}',
        'Memory Technology'       => 'DDR{{versionNum}} {{suffix}}',
        'Form Factor'             => '{{prefix}} ATX {{suffix}}',
        'Connectors'              => '{{intSizeLarge}} Pin',
        'Power'                   => '{{intSizeLarge}} Watts',
        'Wattage'                 => '{{intSizeLarge}} Watts',
        'Memory Form Factor'      => '{{intSizeLarge}}-pin {{prefix}}-DIMM',
        'Frame Size'              => '{{sizeX}}',
        'Picture Size'            => '{{sizeX}}',
        'Shape'                   => '{{shape}} {{sizeX}}',
        'Size & Type'             => '{{shape}} {{sizeX}}',
        'Theme'                   => '{{theme}} & {{theme}}',
        'Tabletop Occasion'       => '{{theme}} & {{theme}}',
        'Sculpture Type'          => '{{theme}} & {{theme}}',
        'Weathervane Theme'       => '{{theme}} & {{theme}}',
        'Genre'                   => '{{theme}}',
        'Subject'                 => '{{theme}}',
        'Pattern'                 => '{{pattern}} {{shape}}',
        'Chair Back Style'        => '{{pattern}} {{shape}}',
        'Style'                   => '{{pattern}} {{shape}}',
        'Scent'                   => '{{fruit}} {{theme}}',
        'Size'                    => '{{prefix}} {{clothesSize}}',
        'Thickness'               => '{{intSizeLarge}} Inches',
        'Piece Count'             => '{{intSize}}}',
        'Thread Count'            => '{{intSizeLarge}}',
        'Seating Capacity'        => '{{intSizeLarge}}',
        'Language'                => '{{country}}',
        'Country'                 => '{{country}}',
        'Manufacturer Country'    => '{{country}}',
        'Author'                  => '{{firstName}} {{lastName}}',
    ];

    protected $clothesSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
    protected $fruits = [
        'Apple',
        'Apricot',
        'Avocado',
        'Banana',
        'Bilberry',
        'Blackberry',
        'Blackcurrant',
        'Blood Orange',
        'Blueberry',
        'Boysenberry',
        'Cantaloupe',
        'Cherimoya',
        'Cherry',
        'Chico Fruit',
        'Chili Pepper',
        'Clementine',
        'Cloudberry',
        'Coconut',
        'Corn Kernel',
        'Crab Apples',
        'Cranberry',
        'Cucumber',
        'Currant',
        'Custard Apple',
        'Damson',
        'Date',
        'Dragonfruit',
        'Durian',
        'Eggplant',
        'Elderberry',
        'Feijoa',
        'Fig',
        'Goji Berry',
        'Gonzoberry',
        'Gooseberry',
        'Grape',
        'Grapefruit',
        'Guava',
        'Honeyberry',
        'Honeydew',
        'Huckleberry',
        'Jabuticaba',
        'Jackfruit',
        'Jambul',
        'Jujube',
        'Juniper Berry',
        'Kiwano',
        'Kiwifruit',
        'Kumquat',
        'Lemon',
        'Lime',
        'Longan',
        'Loquat',
        'Lychee',
        'Mandarine',
        'Mango',
        'Mangosteen',
        'Marionberry',
        'Melon',
        'Miracle Fruit',
        'Mulberry',
        'Nance',
        'Nectarine',
        'Olive',
        'Orange',
        'Papaya',
        'Passionfruit',
        'Pea',
        'Peach',
        'Pear',
        'Persimmon',
        'Pineapple',
        'Plantain',
        'Plum',
        'Plumcot',
        'Pomegranate',
        'Pomelo',
        'Prune',
        'Pumpkin',
        'Purple Mangosteen',
        'Quince',
        'Raisin',
        'Rambutan',
        'Raspberry',
        'Redcurrant',
        'Salak',
        'Salal Berry',
        'Salmonberry',
        'Satsuma',
        'Soursop',
        'Squash',
        'Star Fruit',
        'Strawberry',
        'Tamarillo',
        'Tamarind',
        'Tangerine',
        'Tomato',
        'Ugli Fruit',
        'Watermelon',
        'Yuzu',
    ];

    protected $patterns = [
        'Bordered',
        'Checkered',
        'Floral',
        'Geometric',
        'Gingham',
        'Moiré',
        'Paisley',
        'Patchwork',
        'Plaid',
        'Polka Dot',
        'Print',
        'Solid',
        'Striped',
    ];

    protected $themes = [
        'Bibles',
        'Dieting',
        'Entertainment',
        'Fantasy',
        'Fiction',
        'Graphic Novels',
        'Home',
        'Math',
        'Memoirs',
        'Money',
        'Outdoors',
        'Photography',
        'Relationships',
        'Social Sciences',
        'Spirituality',
        'Suspense',
        'Teaching',
        'Technology',
        'Transportation',
        'Wine',
        'Alphabet',
        'Angels',
        'Animal',
        'Animals',
        'Arts ',
        'Beach Party',
        'Bears ',
        'Beverages',
        'Biographies ',
        'Buildings',
        'Business ',
        'Cactus',
        'Calendars',
        'Candy',
        'Canes',
        'Carnival',
        'Cars',
        'Casino',
        'Cats ',
        'Characters',
        'Churches',
        'Cityscapes',
        'Classic ',
        'Colleges',
        'Colors ',
        'Comics ',
        'Computers ',
        'Cookbooks, Food ',
        'Counting ',
        'Crafts, Hobbies ',
        'Crosses',
        'Dinosaurs',
        'Education ',
        'Elves',
        'Engineering ',
        'Fantasy',
        'Feelings',
        'Fiesta',
        'Flowers',
        'Food ',
        'Foods',
        'Fruit',
        'Gingerbread',
        'Gothic',
        'Health, Fitness ',
        'Hearts',
        'Heroes',
        'History',
        'Houses',
        'Humor ',
        'Icicles',
        'Inspirational',
        'Landscapes',
        'Law',
        'Literature ',
        'Love',
        'Luau',
        'Medical',
        'Military',
        'Monster',
        'Moon',
        'Moon ',
        'Movie Night',
        'Music',
        'Mystery',
        'Nativity',
        'Nautical',
        'Ninja',
        'Novelty',
        'Numbers',
        'Nutcracker',
        'Oktoberfest',
        'Parenting ',
        'Paris',
        'Patriotic',
        'People',
        'Pets',
        'Pineapple',
        'Pirate',
        'Plants',
        'Politics ',
        'Popular',
        'Princess',
        'Reference',
        'Religion ',
        'Religious',
        'Restaurants',
        'Rockstar',
        'Romance',
        'Santa',
        'Schools',
        'Science ',
        'Science Fiction ',
        'Seascapes',
        'Self-help',
        'Shapes',
        'Shops',
        'Sleds',
        'Sleighs',
        'Snowflakes',
        'Snowmen',
        'Sports',
        'Sports ',
        'Stars',
        'Stockings',
        'Superhero',
        'Teddy Bears',
        'Trains',
        'Transportation',
        'Travel',
        'Trees',
        'Unicorn',
        'Universities',
        'Vegetables',
        'Vehicles',
        'Weddings',
        'Western',
        'Wreaths',
        'Zoo',
    ];

    protected $activitySuffixes = ['fighting', 'board games', 'racing', 'sports', 'ball', 'games', 'family', 'twirling', 'swimming', 'activities', 'discipline'];

    protected $shapes = [
        'Arched',
        'Circle',
        'Cone',
        'Cylinder',
        'Ellipse',
        'Hexagon',
        'Irregular',
        'Irregular Shape',
        'Octagon',
        'Oval',
        'Parallelogram',
        'Pentagon',
        'Pyramid',
        'Rectangle',
        'Rectangular',
        'Round',
        'Semicircle',
        'Sphere',
        'Square',
        'Star',
        'Sunburst',
        'Trapezoid',
        'Triangle',
        'Wedge',
        'Whorl',
    ];

    protected $activityTypes = [
        'ATV',
        'Acro',
        'Air',
        'Aquatic',
        'Aquatic ',
        'Archery',
        'Auto',
        'Ball-over-net ',
        'Baseball',
        'Basketball',
        'Basketball',
        'Bat-and-ball',
        'Baton ',
        'Bicycle',
        'Board',
        'Boating',
        'Bowling',
        'Boxing',
        'Camping',
        'Canoeing',
        'Card games',
        'Catch games',
        'Cheerleading',
        'Climbing',
        'Combat sports',
        'Competitive',
        'Cue sports',
        'Cycling',
        'Dance',
        'Diving',
        'Equestrian',
        'Equine',
        'Exercise',
        'Fantasy',
        'Field',
        'Fishing',
        'Flying disc',
        'Football',
        'Golf',
        'Grappling',
        'Gymnastics',
        'Handball',
        'Hockey',
        'Hunting',
        'Hurling',
        'Ice',
        'Kayaking',
        'Kindred',
        'Kite',
        'Lacrosse',
        'Marker',
        'Martial',
        'Mind',
        'Mixed',
        'Motorboat',
        'Motorcycle',
        'Motorized',
        'Musical',
        'Orienteering',
        'Outdoor',
        'Overlapping',
        'Performance',
        'Pilates',
        'Pilota',
        'Polo',
        'Racquet',
        'Racquetball',
        'Rafting',
        'Remote',
        'Rodeo-originated',
        'Rowing',
        'Rugby',
        'Running',
        'Sailing',
        'Shooting',
        'Skateboarding',
        'Skibob',
        'Skiing',
        'Skirmish',
        'Sled',
        'Snow',
        'Snowboarding',
        'Snowmobiling',
        'Snowshoeing',
        'Soccer',
        'Speedcubing',
        'Squash',
        'Stacking',
        'Stick',
        'Strategy',
        'Street',
        'Striking',
        'Subsurface',
        'Surface',
        'Surfing',
        'Swimming',
        'Tag games',
        'Tennis',
        'Track',
        'Triathlon',
        'Underwater',
        'Unicycle',
        'Volleyball',
        'Walking',
        'Wall-and-ball',
        'Water',
        'Weapons',
        'Weightlifting',
        'Windsurfing',
        'Yoga',
    ];

    protected $materials = [
        'ABS',
        'Acacia',
        'Acetal',
        'Acrylic',
        'Aluminium',
        'Aluminum',
        'Antimony',
        'Aramid',
        'Ash',
        'Balsa',
        'Basswood',
        'Beech',
        'Beryllium',
        'Birch',
        'Bismuth',
        'Bloodwood',
        'Bocote',
        'Bone',
        'Boron',
        'Brass',
        'Brazilwood',
        'Bronze',
        'Bubinga',
        'Butternut',
        'Cadmium',
        'Carbon',
        'Cast',
        'Cedar',
        'Chakte',
        'Chechen',
        'Cherry',
        'Chromium',
        'Cobalt',
        'Cocobolo',
        'Concrete',
        'Copper',
        'Diamond',
        'Douglas',
        'Ebony',
        'Elm',
        'Fiberboard',
        'Flax',
        'Glass',
        'Gold',
        'Goncalo',
        'Granite',
        'Graphene',
        'Grey',
        'HDPE',
        'Hemp',
        'Hickory',
        'Holly',
        'Human',
        'Iridium',
        'Iron',
        'Jarrah',
        'Jatoba',
        'Kiaat',
        'Kingwood',
        'Koa',
        'Kwila',
        'LDPE',
        'Lead',
        'Lemonwood',
        'Lignum',
        'MDF',
        'Magnesium',
        'Mahogany',
        'Makore',
        'Manganese',
        'Mango',
        'Maple',
        'Marble',
        'Mercury',
        'Molybdenum',
        'Neoprene',
        'Nickel',
        'Niobium',
        'Nylon',
        'Oak',
        'Osmium',
        'PVC',
        'Padauk',
        'Panga',
        'Phosphor',
        'Pine',
        'Pink',
        'Platinum',
        'Plutonium',
        'Polyamide',
        'Polycarbonate',
        'Polyethylene',
        'Polyimide',
        'Polypropylene',
        'Polystyrene',
        'Polytehylene',
        'Poplar',
        'Potassium',
        'Purpleheart',
        'Redwood',
        'Rhodium',
        'Rosewood',
        'Rubber',
        'Sapele',
        'Sapphire',
        'Selenium',
        'Shedua',
        'Silicon',
        'Silver',
        'Snakewood',
        'Sodium',
        'Spruce',
        'Stainless',
        'Steel',
        'Tantalum',
        'Teak',
        'Teflon',
        'Thorium',
        'Tin',
        'Titanium',
        'Tooth',
        'Tulipwood',
        'Tungsten',
        'Uranium',
        'Vanadium',
        'Verawood',
        'Walnut',
        'Water',
        'Wenge',
        'Wrought',
        'Yellowheart',
        'Zebrawood',
        'Zinc',
        'Ziricote',
    ];

    protected $textiles = [
        'Azlon',
        'Bombazine',
        'Brocade',
        'Calico',
        'Cambric',
        'Camel hair',
        'Canvas',
        'Cashmere',
        'Cheviot',
        'Chiffon',
        'Chintz',
        'Corduroy',
        'Cotton',
        'Crash',
        'Crepe',
        'Cretonne',
        'Damask',
        'Delaine',
        'Denim',
        'Dimity',
        'Duck',
        'Flannel',
        'Flax',
        'Foulard',
        'Fustian',
        'Gabardine',
        'Gauze',
        'Gingham',
        'Hemp',
        'Holland',
        'Horsehair',
        'Jamdani',
        'Jute',
        'Khaki',
        'Kimkhwāb',
        'Lace',
        'Linen',
        'Mohair',
        'Muslin',
        'Nankeen',
        'Poplin',
        'Rabbit hair',
        'Rayon',
        'Reticella',
        'Satin',
        'Serge',
        'Silk',
        'Taffeta',
        'Toile de Jouy',
        'Tweed',
        'Twill',
        'Velvet',
        'Velveteen',
        'Wool',
        'Yarn',
    ];

    protected $fileSystems = [
        'DECtape',
        'DASD',
        'RT-11',
        'GEC DOS',
        'CP/M',
        'ODS',
        'GEC DOS',
        'FAT',
        'DOS ',
        'UCSD',
        'CBM DOS',
        'ODS-2',
        'FAT12',
        'DFS',
        'ADFS',
        'FFS',
        'ProDOS',
        'FAT16',
        'MFS',
        'Elektronika',
        'HFS',
        'GEMDOS',
        'NWFS',
        'High Sierra',
        'FAT16B',
        'Minix',
        'Amiga',
        'ISO',
        'HPFS',
        'Rock',
        'JFS1',
        'VxFS',
        'ext',
        'AdvFS',
        'NTFS',
        'LFS',
        'ext2',
        'Xiafs',
        'UFS1',
        'XFS',
        'FAT16X',
        'Joliet',
        'UDF',
        'FAT32X',
        'QFS',
        'GPFS',
        'Be',
        'Minix',
        'HFS',
        'NSS',
        'ODS-5',
        'WAFL',
        'ext3',
        'ISO',
        'JFS',
        'GFS',
        'ReiserFS',
        'zFS',
        'FATX',
        'UFS2',
        'OCFS',
        'SquashFS',
        'VMFS2',
        'Lustre',
        'Fossil',
        'Google',
        'ZFS',
        'Reiser4',
        'Non-Volatile',
        'BeeGFS',
        'Minix',
        'OCFS2',
        'NILFS',
        'VMFS3',
        'GFS2',
        'ext4',
        'exFAT',
        'Btrfs',
        'HAMMER',
        'LSFS',
        'UniFS',
        'OrangeFS',
        'ReFS',
        'F2FS',
        'APFS',
        'NOVA',

    ];

    protected $connectionTypes = ['Fibre Channel', 'SCSI', 'SAS', 'Ethernet', 'USB', 'Firewire', 'Bluetooth', 'Serial', 'ATA', 'SATA', 'WIFI', 'DSL', 'Cable', 'Wireless', 'LAN', 'WAN', 'NFC', 'IDE', 'ATA', 'UDMA', 'DMA', 'MCA', 'PCI', 'AGP', 'ISA'];

    protected $weightUnits = ['g', 'kg', 'lb', 'oz', 'pg', 'mg'];

    protected $lengthUnits = ['km', 'cm', 'm', 'mm', 'um', 'nm', 'in', 'ft', 'yd', 'mi'];

    protected $display = ['LED', 'RED', 'IPS', 'Backlit', 'Screen', 'LCD', 'TFT', 'Plasma', 'Liquid', 'Laser', 'Quantum', 'AMOLED', 'OLED', 'Retina', 'Glass',];

    protected $prefixes = ['m', 'SO', 'Extended', 'ex', 'X', 'L', 'A', 'Hydro', 'Resistive', 'Super', 'Mega', 'Extra', 'Multi', 'Ultra', 'Mini', 'Mid', 'Full', 'Micro', 'Flex', 'Digital', 'Touch', 'Capacitive', 'Organic', 'Tactile'];

    protected $suffixes = ['II', 'III', 'v1', 'v2', 'v3', '3.x', '+', '3D', 'x', 'XL', 's', 'Plus', 'One', 'X', 'LTE', 'Express', 'Exp', 'g', 'G'];

    protected $arabicNumbers = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X',];

    protected $ciPrefixes = ['h', 'k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'];

    protected $operatingSystems = ['Android', 'FreeBSD', 'ChromeOS', 'Debian', 'Linux', 'CentOS', 'Kubuntu', 'ReactOS', 'Xubuntu', 'Lubuntu', 'SteamOS', 'Ubuntu', 'MacOS', 'iOS', 'Raspberry Pi', 'JavaOS', 'MS-DOS', 'Red Hat', 'openSUSE', 'Symbian', 'Unix', 'Windows', 'Arch Linux', 'Solaris', 'Fedora', 'Elementary OS',];

    protected $versionNames = ['Phone', 'Cupcake', 'Donut', 'Eclair', 'Froyo', 'Gingerbread', 'Honeycomb', 'Sandwich', 'Jelly Bean', 'KitKat', 'Lollipop', 'Marshmallow', 'Nougat', 'Oreo', 'Warthog', 'Hedgehog', 'Badger', 'Drake', 'Eft', 'Fawn', 'Gibbon', 'Heron', 'Ibex', 'Jackalope', 'Koala', 'Lynx', 'Meerkat', 'Narwhal', 'Ocelot', 'Pangolin', 'Quetzal', 'Ringtail', 'Salamander', 'Tahr', 'Unicorn', 'Vervet', 'Werewolf', 'Xerus', 'Yak', 'Zapus', 'Aardvark', 'Beaver', 'X', 'N', 'XP', 'Server', 'Me', 'NT',];

    protected $processorManufacturer = ['Intel', 'AMD', 'Qualcomm', 'MediaTek', 'ARM', 'Atmel', 'NVIDIA', 'VIA', 'IBM', 'Cyrix',];

    protected $processorModel = ['Core', 'Celeron', 'Pentium', 'Xeon', 'Atom', 'Athlon', 'Turion', 'Phenom', 'Sempron', 'Snapdragon'];

    protected $processorVersion = ['i{{versionOdd}}', 'A{{versionEven}}', '{{versionArabic}}', 'S{{versionNum}}', '{{versionHS}}'];

    public function attributeName() {
        $format = static::randomElement(array_keys($this->attributes));

        return $this->generator->parse($format);
    }

    public function attributeValue($attributeName = null) {

        if (!isset($this->attributes[$attributeName])) {
            $attributeName = $this->attributeName();
        }

        $valueFormat = $this->attributes[$attributeName];

        return $this->generator->parse($valueFormat);
    }

    public function clothesSize() {
        return static::randomElement($this->clothesSizes);
    }

    public function fruit() {
        return static::randomElement($this->fruits);
    }

    public function pattern() {
        return static::randomElement($this->patterns);
    }

    public function theme() {
        return static::randomElement($this->themes);
    }

    public function shape() {
        return static::randomElement($this->shapes);
    }

    public function activitySuffix() {
        return static::randomElement($this->activitySuffixes);
    }

    public function activityType() {
        return static::randomElement($this->activityTypes);
    }

    public function material() {
        return static::randomElement($this->materials);
    }

    public function textile() {
        return static::randomElement($this->textiles);
    }

    public function fileSystem() {
        return static::randomElement($this->fileSystems);
    }

    public function connectionType() {
        return static::randomElement($this->connectionTypes);
    }

    public function lengthUnit() {
        return static::randomElement($this->lengthUnits);
    }

    public function weightUnit() {
        return static::randomElement($this->weightUnits);
    }

    public function aspectRatio($glue = ':') {
        return implode($glue, $this->aspectRatioArray());
    }


    public function aspectRatioX() {
        return $this->aspectRatio('x');
    }

    public function sizeX() {
        return implode('x', $this->aspectRatioArray(1, 1000));

    }

    public function aspectRatioArray($min = 3, $max = 21) {
        return [
            self::numberBetween($min, $max),
            self::numberBetween($min, $max),
        ];
    }

    public function resolution() {
        $ar = $this->aspectRatioArray();
        $base = $this->powTwo();

        return $ar[0] * $base . 'x' . $ar[1] * $base;

    }


    public function prefix() {
        $prefix = self::randomElement($this->prefixes);

        return $prefix;
    }


    public function suffix() {
        $suffix = self::randomElement($this->suffixes);

        return $suffix;
    }

    public function suffixLight() {
        $str = $this->suffix();

        return isset($str[0]) ? $str[0] : '';
    }

    public function prefixLight() {
        $str = $this->prefix();

        return isset($str[0]) ? $str[0] : '';
    }

    public function displayType() {
        return $this->prefix() . ' ' . self::randomElement($this->display) . ' ' . $this->suffix();
    }


    public function ciPrefix() {
        return self::randomElement($this->ciPrefixes);
    }

    public function dotSizeLarge() {
        return self::numberBetween(1, 50) . '.' . self::numberBetween(0, 9);
    }

    public function dotSize() {
        return self::numberBetween(0, 9) . '.' . self::numberBetween(0, 9);
    }

    public function intSizeLarge() {
        return self::numberBetween(1, 10000);
    }


    public function threeDigits() {
        return $this->generator->randomNumber(3, true);
    }

    public function intSize() {
        return self::numberBetween(1, 500);
    }

    public function powTwo() {
        return pow(2, self::numberBetween(1, 15));
    }

    public function operatingSystem() {
        return $this->operatingSystemName() . ' ' . $this->operatingSystemVersion();
    }

    public function operatingSystemName() {
        return self::randomElement($this->operatingSystems);
    }

    public function operatingSystemVersion() {
        return $this->generator->boolean ? self::randomElement($this->versionNames) : $this->versionNum();
    }


    public function processorName() {
        $name = $this->processorManufacturer();
        $model = '';
        $version = '';

        if ($this->generator->boolean()) {
            $model = ' ' . $this->processorModel();
        }

        if ($this->generator->boolean()) {
            $version = ' ' . $this->processorVersion();
        }


        return $name . $model . $version;
    }


    public function processorManufacturer() {
        return $this->generator->boolean ? $this->processorManufacturerReal() : $this->processorManufacturerFake();
    }

    public function processorModel() {
        return $this->generator->boolean ? $this->processorModelReal() : $this->processorModelFake();
    }

    public function processorVersion() {
        $version = self::randomElement($this->processorVersion);
        $version = $this->generator->parse($version);

        return $version;
    }

    public function processorModelReal() {
        return self::randomElement($this->processorModel);
    }

    public function processorManufacturerReal() {
        return self::randomElement($this->processorManufacturer);
    }


    public function processorManufacturerFake() {
        return $this->generator->mixTwo($this->processorManufacturerReal(), $this->processorManufacturerReal());
    }


    public function processorModelFake() {
        return $this->generator->mixTwo($this->processorModel(), $this->processorModel());
    }


    public function versionArabic() {
        return self::randomElement($this->arabicNumbers);
    }

    public function versionHS() {
        return self::numberBetween(100, 1000);
    }

    public function versionNum() {
        return self::numberBetween(1, 9);
    }

    public function versionOdd() {
        $num = $this->versionNum();

        return $num % 2 === 0 ? ++$num : $num;
    }

    public function versionEven() {
        $num = $this->versionNum();

        return $num % 2 === 1 ? ++$num : $num;
    }


}