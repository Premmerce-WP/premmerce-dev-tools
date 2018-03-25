<?php namespace Premmerce\DevTools\DataGenerator\Providers;

use Faker\Provider\Base;

class AttributeProvider extends Base
{
    private $electronicAttributes = [
        'Processor'               => '{{processorName}}',
        'Graphics Processor'      => '{{processorName}}',
        'Operating System'        => '{{operatingSystem}}',
        'RAM Size'                => '{{powTwo}} {{ciPrefix}}B',
        'Capacity'                => '{{powTwo}} {{ciPrefix}}B',
        'Internal Storage Memory' => '{{powTwo}} {{ciPrefix}}B',
        'Hard Drive Size'         => '{{intSize}} {{ciPrefix}}B',
        'Flash Size'              => '{{intSize}} {{ciPrefix}}B',
        'CPU Speed'               => '{{dotSize}} {{ciPrefix}}Hz',
        'Color'                   => '{{colorName}}',
        'Display'                 => '{{displayType}}',
        'Display Technology'      => '{{displayType}}',
        'Display Size'            => '{{dotSize}}"',
        'Drive Size'              => '{{dotSizeLarge}} Inch',
        'Aspect Ration'           => '{{aspectRatio}}',
        'Resolution'              => '{{resolution}}',
        'Display Resolution'      => '{{resolution}}',
        'Weight'                  => '{{dotSize}} {{weightUnit}}',
        'Width'                   => '{{dotSize}} {{lengthUnit}}',
        'Height'                  => '{{dotSize}} {{lengthUnit}}',
        'Optical Zoom'            => '{{dotSizeLarge}}x',
        'Number of CPU Cores'     => '{{intSize}}',
        'Connectivity Technology' => '{{prefixLight}}{{intSize}}{{suffixLight}}',
        'Connection Type'         => '{{prefixLight}}{{connectionType}}{{suffix}}',
        'Interface'               => '{{prefixLight}}{{connectionType}}{{suffix}}',
        'File System'             => '{{prefixLight}}{{fileSystem}}{{suffix}}',
        'Rotational Speed'        => '{{intSizeLarge}}00 RPM',
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

    protected $connectionTypes = ['mSATA', 'Ethernet', 'USB', 'Firewire', 'Bluetooth', 'Serial', 'ATA', 'SATA', 'WIFI', 'DSL', 'Cable', 'Wireless', 'LAN', 'WAN', 'NFC', 'IDE', 'ATA', 'UDMA', 'DMA', 'MCA', 'PCI', 'AGP', 'ISA'];

    protected $weightUnits = ['g', 'kg', 'lb', 'oz', 'pg', 'mg'];

    protected $lengthUnits = ['km', 'cm', 'm', 'mm', 'um', 'nm', 'in', 'ft', 'yd', 'mi'];

    protected $display = ['LED', 'RED', 'IPS', 'Backlit', 'Screen', 'LCD', 'TFT', 'Plasma', 'Liquid', 'Laser', 'Quantum', 'AMOLED', 'OLED', 'Retina', 'Glass',];

    protected $prefixes = ['ex', 'X', 'L', 'A', 'Hydro', 'Resistive', 'Super', 'Mega', 'Extra', 'Multi', 'Ultra', 'Digital', 'Touch', 'Capacitive', 'Organic', 'Tactile'];

    protected $suffixes = ['II', 'III', 'v1', 'v2', 'v3', '3.x', '+', '3D', 'x', 'XL', 's', 'Plus', 'One', 'X', 'LTE', 'Express', 'Exp', 'g', 'G'];

    protected $arabicNumbers = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X',];

    protected $ciPrefixes = ['h', 'k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'];

    protected $operatingSystems = ['Android', 'FreeBSD', 'ChromeOS', 'Debian', 'Linux', 'CentOS', 'Kubuntu', 'ReactOS', 'Xubuntu', 'Lubuntu', 'SteamOS', 'Ubuntu', 'MacOS', 'iOS', 'Raspberry Pi', 'JavaOS', 'MS-DOS', 'Red Hat', 'openSUSE', 'Symbian', 'Unix', 'Windows', 'Arch Linux', 'Solaris', 'Fedora', 'Elementary OS',];

    protected $versionNames = ['Phone', 'Cupcake', 'Donut', 'Eclair', 'Froyo', 'Gingerbread', 'Honeycomb', 'Sandwich', 'Jelly Bean', 'KitKat', 'Lollipop', 'Marshmallow', 'Nougat', 'Oreo', 'Warthog', 'Hedgehog', 'Badger', 'Drake', 'Eft', 'Fawn', 'Gibbon', 'Heron', 'Ibex', 'Jackalope', 'Koala', 'Lynx', 'Meerkat', 'Narwhal', 'Ocelot', 'Pangolin', 'Quetzal', 'Ringtail', 'Salamander', 'Tahr', 'Unicorn', 'Vervet', 'Werewolf', 'Xerus', 'Yak', 'Zapus', 'Aardvark', 'Beaver', 'X', 'N', 'XP', 'Server', 'Me', 'NT',];

    protected $processorManufacturer = ['Intel', 'AMD', 'Qualcomm', 'MediaTek', 'ARM', 'Atmel', 'NVIDIA', 'VIA', 'IBM', 'Cyrix',];

    protected $processorModel = ['Core', 'Celeron', 'Pentium', 'Xeon', 'Atom', 'Athlon', 'Turion', 'Phenom', 'Sempron', 'Snapdragon'];

    protected $processorVersion = ['i{{versionOdd}}', 'A{{versionEven}}', '{{versionArabic}}', 'S{{versionNum}}', '{{versionHS}}'];

    public function attributeName() {
        $format = static::randomElement(array_keys($this->electronicAttributes));

        return $this->generator->parse($format);
    }

    public function attributeValue($attributeName = null) {

        if (!isset($this->electronicAttributes[$attributeName])) {
            $attributeName = $this->attributeName();
        }

        $valueFormat = $this->electronicAttributes[$attributeName];

        return $this->generator->parse($valueFormat);
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

    public function aspectRatio() {
        return implode(':', $this->aspectRatioArray());
    }

    public function aspectRatioArray() {
        return [
            self::numberBetween(3, 21),
            self::numberBetween(3, 21),
        ];
    }

    public function resolution() {
        $ar = $this->aspectRatioArray();
        $base = $this->powTwo();

        return $ar[0] * $base . 'x' . $ar[1] * $base;

    }


    public function prefix() {
        $prefix = self::randomElement($this->prefixes);

        if (strlen($prefix) > 1) {
            $prefix .= ' ';
        }

        return $prefix;
    }


    public function suffix() {
        $suffix = self::randomElement($this->suffixes);

        if (strlen($suffix) > 1) {
            $suffix = ' ' . $suffix;
        }

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
        return $this->prefix() . self::randomElement($this->display) . $this->suffix();
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