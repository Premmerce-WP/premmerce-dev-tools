<?php namespace Premmerce\DevTools\DataGenerator\Providers;


use Faker\Provider\Base;
use Premmerce\DevTools\DataGenerator\Providers\Attributes\ActivityTrait;
use Premmerce\DevTools\DataGenerator\Providers\Attributes\DesignTrait;
use Premmerce\DevTools\DataGenerator\Providers\Attributes\DisplayTrait;
use Premmerce\DevTools\DataGenerator\Providers\Attributes\FSTrait;
use Premmerce\DevTools\DataGenerator\Providers\Attributes\MaterialTrait;
use Premmerce\DevTools\DataGenerator\Providers\Attributes\MixTrait;
use Premmerce\DevTools\DataGenerator\Providers\Attributes\OSTrait;
use Premmerce\DevTools\DataGenerator\Providers\Attributes\ProcessorTrait;
use Premmerce\DevTools\DataGenerator\Providers\Attributes\TechTrait;
use Premmerce\DevTools\DataGenerator\Providers\Attributes\UnitTrait;

class AttributeProvider extends Base
{

    use ActivityTrait;
    use DesignTrait;
    use DisplayTrait;
    use FSTrait;
    use MaterialTrait;
    use MixTrait;
    use OSTrait;
    use ProcessorTrait;
    use TechTrait;
    use UnitTrait;

    private $attributes = [
        'CPU'                      => '{{processorName}}',
        'CPU Model'                => '{{processorName}}',
        'CPU Name'                 => '{{processorName}}',
        'Central CPU'              => '{{processorName}}',
        'Central CPU Model'        => '{{processorName}}',
        'Central CPU Name'         => '{{processorName}}',
        'Central Processor'        => '{{processorName}}',
        'Central Processor Model'  => '{{processorName}}',
        'Central Processor Name'   => '{{processorName}}',
        'Core CPU'                 => '{{processorName}}',
        'Core CPU Model'           => '{{processorName}}',
        'Core CPU Name'            => '{{processorName}}',
        'Core Processor'           => '{{processorName}}',
        'Core Processor Model'     => '{{processorName}}',
        'Core Processor Name'      => '{{processorName}}',
        'General CPU'              => '{{processorName}}',
        'General CPU Model'        => '{{processorName}}',
        'General CPU Name'         => '{{processorName}}',
        'General Processor'        => '{{processorName}}',
        'General Processor Model'  => '{{processorName}}',
        'General Processor Name'   => '{{processorName}}',
        'Graphics CPU'             => '{{processorName}}',
        'Graphics CPU Model'       => '{{processorName}}',
        'Graphics CPU Name'        => '{{processorName}}',
        'Graphics Processor'       => '{{processorName}}',
        'Graphics Processor Model' => '{{processorName}}',
        'Graphics Processor Name'  => '{{processorName}}',
        'Main CPU'                 => '{{processorName}}',
        'Main CPU Model'           => '{{processorName}}',
        'Main CPU Name'            => '{{processorName}}',
        'Main Processor'           => '{{processorName}}',
        'Main Processor Model'     => '{{processorName}}',
        'Main Processor Name'      => '{{processorName}}',
        'Micro CPU'                => '{{processorName}}',
        'Micro CPU Model'          => '{{processorName}}',
        'Micro CPU Name'           => '{{processorName}}',
        'Micro Processor'          => '{{processorName}}',
        'Micro Processor Model'    => '{{processorName}}',
        'Micro Processor Name'     => '{{processorName}}',
        'Processor'                => '{{processorName}}',
        'Processor Model'          => '{{processorName}}',
        'Processor Name'           => '{{processorName}}',
        'Sound CPU'                => '{{processorName}}',
        'Sound CPU Model'          => '{{processorName}}',
        'Sound CPU Name'           => '{{processorName}}',
        'Sound Processor'          => '{{processorName}}',
        'Sound Processor Model'    => '{{processorName}}',
        'Sound Processor Name'     => '{{processorName}}',

        'Available OS'       => '{{operatingSystem}}',
        'Available Platform' => '{{operatingSystem}}',
        'Available System'   => '{{operatingSystem}}',
        'Computer OS'        => '{{operatingSystem}}',
        'Computer Platform'  => '{{operatingSystem}}',
        'Computer System'    => '{{operatingSystem}}',
        'OS'                 => '{{operatingSystem}}',
        'Operating OS'       => '{{operatingSystem}}',
        'Operating Platform' => '{{operatingSystem}}',
        'Operating System'   => '{{operatingSystem}}',
        'Platform'           => '{{operatingSystem}}',
        'System'             => '{{operatingSystem}}',

        'Available Flash Memory'          => '{{powTwo}} {{ciPrefix}}B',
        'Available Flash Memory Capacity' => '{{powTwo}} {{ciPrefix}}B',
        'Available Flash Memory Memory'   => '{{powTwo}} {{ciPrefix}}B',
        'Available Flash Memory Size'     => '{{powTwo}} {{ciPrefix}}B',
        'Available Hard Drive'            => '{{powTwo}} {{ciPrefix}}B',
        'Available Hard Drive Capacity'   => '{{powTwo}} {{ciPrefix}}B',
        'Available Hard Drive Memory'     => '{{powTwo}} {{ciPrefix}}B',
        'Available Hard Drive Size'       => '{{powTwo}} {{ciPrefix}}B',
        'Available Memory'                => '{{powTwo}} {{ciPrefix}}B',
        'Available Memory Capacity'       => '{{powTwo}} {{ciPrefix}}B',
        'Available Memory Memory'         => '{{powTwo}} {{ciPrefix}}B',
        'Available Memory Size'           => '{{powTwo}} {{ciPrefix}}B',
        'Available RAM'                   => '{{powTwo}} {{ciPrefix}}B',
        'Available RAM Capacity'          => '{{powTwo}} {{ciPrefix}}B',
        'Available RAM Memory'            => '{{powTwo}} {{ciPrefix}}B',
        'Available RAM Size'              => '{{powTwo}} {{ciPrefix}}B',
        'Available Storage'               => '{{powTwo}} {{ciPrefix}}B',
        'Available Storage Capacity'      => '{{powTwo}} {{ciPrefix}}B',
        'Available Storage Memory'        => '{{powTwo}} {{ciPrefix}}B',
        'Available Storage Size'          => '{{powTwo}} {{ciPrefix}}B',
        'Flash Memory'                    => '{{powTwo}} {{ciPrefix}}B',
        'Flash Memory Capacity'           => '{{powTwo}} {{ciPrefix}}B',
        'Flash Memory Memory'             => '{{powTwo}} {{ciPrefix}}B',
        'Flash Memory Size'               => '{{powTwo}} {{ciPrefix}}B',
        'Hard Drive'                      => '{{powTwo}} {{ciPrefix}}B',
        'Hard Drive Capacity'             => '{{powTwo}} {{ciPrefix}}B',
        'Hard Drive Memory'               => '{{powTwo}} {{ciPrefix}}B',
        'Hard Drive Size'                 => '{{powTwo}} {{ciPrefix}}B',
        'Memory'                          => '{{powTwo}} {{ciPrefix}}B',
        'Memory Capacity'                 => '{{powTwo}} {{ciPrefix}}B',
        'Memory Memory'                   => '{{powTwo}} {{ciPrefix}}B',
        'Memory Size'                     => '{{powTwo}} {{ciPrefix}}B',
        'RAM'                             => '{{powTwo}} {{ciPrefix}}B',
        'RAM Capacity'                    => '{{powTwo}} {{ciPrefix}}B',
        'RAM Memory'                      => '{{powTwo}} {{ciPrefix}}B',
        'RAM Size'                        => '{{powTwo}} {{ciPrefix}}B',
        'Storage'                         => '{{powTwo}} {{ciPrefix}}B',
        'Storage Capacity'                => '{{powTwo}} {{ciPrefix}}B',
        'Storage Memory'                  => '{{powTwo}} {{ciPrefix}}B',
        'Storage Size'                    => '{{powTwo}} {{ciPrefix}}B',


        'CPU Speed'            => '#.# {{ciPrefix}}Hz',
        'CPU Speed (Hz)'       => '#.# {{ciPrefix}}Hz',
        'Max Speed'            => '#.# {{ciPrefix}}Hz',
        'Max Speed (Hz)'       => '#.# {{ciPrefix}}Hz',
        'Processor Speed'      => '#.# {{ciPrefix}}Hz',
        'Processor Speed (Hz)' => '#.# {{ciPrefix}}Hz',
        'Speed'                => '#.# {{ciPrefix}}Hz',
        'Speed (Hz)'           => '#.# {{ciPrefix}}Hz',

        'Base Color'       => '{{colorName}}',
        'Base Colour'      => '{{colorName}}',
        'Base Tone'        => '{{colorName}}',
        'Bottom Color'     => '{{colorName}}',
        'Bottom Colour'    => '{{colorName}}',
        'Bottom Tone'      => '{{colorName}}',
        'Color'            => '{{colorName}}',
        'Colour'           => '{{colorName}}',
        'Frame Color'      => '{{colorName}}',
        'Frame Colour'     => '{{colorName}}',
        'Frame Tone'       => '{{colorName}}',
        'Front Color'      => '{{colorName}}',
        'Front Colour'     => '{{colorName}}',
        'Front Tone'       => '{{colorName}}',
        'Furniture Color'  => '{{colorName}}',
        'Furniture Colour' => '{{colorName}}',
        'Furniture Tone'   => '{{colorName}}',
        'Image Color'      => '{{colorName}}',
        'Image Colour'     => '{{colorName}}',
        'Image Tone'       => '{{colorName}}',
        'Logo Color'       => '{{colorName}}',
        'Logo Colour'      => '{{colorName}}',
        'Logo Tone'        => '{{colorName}}',
        'Main Color'       => '{{colorName}}',
        'Main Colour'      => '{{colorName}}',
        'Main Tone'        => '{{colorName}}',
        'Picture Color'    => '{{colorName}}',
        'Picture Colour'   => '{{colorName}}',
        'Picture Tone'     => '{{colorName}}',
        'Secondary Color'  => '{{colorName}}',
        'Secondary Colour' => '{{colorName}}',
        'Secondary Tone'   => '{{colorName}}',
        'Side Color'       => '{{colorName}}',
        'Side Colour'      => '{{colorName}}',
        'Side Tone'        => '{{colorName}}',
        'Textile Color'    => '{{colorName}}',
        'Textile Colour'   => '{{colorName}}',
        'Textile Tone'     => '{{colorName}}',
        'Tone'             => '{{colorName}}',
        'Top Color'        => '{{colorName}}',
        'Top Colour'       => '{{colorName}}',
        'Top Tone'         => '{{colorName}}',
        'Wood Color'       => '{{colorName}}',
        'Wood Colour'      => '{{colorName}}',
        'Wood Tone'        => '{{colorName}}',

        'Base Design'      => '{{shape}} {{colorName}}',
        'Desc Design'      => '{{shape}} {{colorName}}',
        'Design'           => '{{shape}} {{colorName}}',
        'Frame Design'     => '{{shape}} {{colorName}}',
        'Furniture Design' => '{{shape}} {{colorName}}',
        'Image Design'     => '{{shape}} {{colorName}}',
        'Logo Design'      => '{{shape}} {{colorName}}',
        'Main Design'      => '{{shape}} {{colorName}}',
        'Secondary Design' => '{{shape}} {{colorName}}',
        'Wood Design'      => '{{shape}} {{colorName}}',


        'Base Display'                 => '{{displayType}}',
        'Base Display Technology'      => '{{displayType}}',
        'Base Display Type'            => '{{displayType}}',
        'Display'                      => '{{displayType}}',
        'Display Technology'           => '{{displayType}}',
        'Display Type'                 => '{{displayType}}',
        'Main Display'                 => '{{displayType}}',
        'Main Display Technology'      => '{{displayType}}',
        'Main Display Type'            => '{{displayType}}',
        'Secondary Display'            => '{{displayType}}',
        'Secondary Display Technology' => '{{displayType}}',
        'Secondary Display Type'       => '{{displayType}}',

        'Base Resolution'      => '{{resolution}}',
        'Display Resolution'   => '{{resolution}}',
        'Main Resolution'      => '{{resolution}}',
        'Max Resolution'       => '{{resolution}}',
        'Min Resolution'       => '{{resolution}}',
        'Native Resolution'    => '{{resolution}}',
        'Resolution'           => '{{resolution}}',
        'Secondary Resolution' => '{{resolution}}',

        'Base Weight'      => '#.# {{weightUnit}}',
        'Box Weight'       => '#.# {{weightUnit}}',
        'Main Weight'      => '#.# {{weightUnit}}',
        'Secondary Weight' => '#.# {{weightUnit}}',
        'Weight'           => '#.# {{weightUnit}}',

        'Base Height'      => '#.# {{lengthUnit}}',
        'Base Length'      => '#.# {{lengthUnit}}',
        'Base Width'       => '#.# {{lengthUnit}}',
        'Box Height'       => '#.# {{lengthUnit}}',
        'Box Length'       => '#.# {{lengthUnit}}',
        'Box Width'        => '#.# {{lengthUnit}}',
        'Height'           => '#.# {{lengthUnit}}',
        'Length'           => '#.# {{lengthUnit}}',
        'Main Height'      => '#.# {{lengthUnit}}',
        'Main Length'      => '#.# {{lengthUnit}}',
        'Main Width'       => '#.# {{lengthUnit}}',
        'Secondary Height' => '#.# {{lengthUnit}}',
        'Secondary Length' => '#.# {{lengthUnit}}',
        'Secondary Width'  => '#.# {{lengthUnit}}',
        'Width'            => '#.# {{lengthUnit}}',


        'Base Connection'                      => '*{{connectionType}} {{suffix}}',
        'Base Connection Compatibility'        => '*{{connectionType}} {{suffix}}',
        'Base Connection Type'                 => '*{{connectionType}} {{suffix}}',
        'Base Connectivity'                    => '*{{connectionType}} {{suffix}}',
        'Base Connectivity Compatibility'      => '*{{connectionType}} {{suffix}}',
        'Base Connectivity Type'               => '*{{connectionType}} {{suffix}}',
        'Base Gateway'                         => '*{{connectionType}} {{suffix}}',
        'Base Gateway Compatibility'           => '*{{connectionType}} {{suffix}}',
        'Base Gateway Type'                    => '*{{connectionType}} {{suffix}}',
        'Base Interface'                       => '*{{connectionType}} {{suffix}}',
        'Base Interface Compatibility'         => '*{{connectionType}} {{suffix}}',
        'Base Interface Type'                  => '*{{connectionType}} {{suffix}}',
        'Base Protocol'                        => '*{{connectionType}} {{suffix}}',
        'Base Protocol Compatibility'          => '*{{connectionType}} {{suffix}}',
        'Base Protocol Type'                   => '*{{connectionType}} {{suffix}}',
        'Connection'                           => '*{{connectionType}} {{suffix}}',
        'Connection Compatibility'             => '*{{connectionType}} {{suffix}}',
        'Connection Type'                      => '*{{connectionType}} {{suffix}}',
        'Connectivity'                         => '*{{connectionType}} {{suffix}}',
        'Connectivity Compatibility'           => '*{{connectionType}} {{suffix}}',
        'Connectivity Type'                    => '*{{connectionType}} {{suffix}}',
        'Gateway'                              => '*{{connectionType}} {{suffix}}',
        'Gateway Compatibility'                => '*{{connectionType}} {{suffix}}',
        'Gateway Type'                         => '*{{connectionType}} {{suffix}}',
        'Interface'                            => '*{{connectionType}} {{suffix}}',
        'Interface Compatibility'              => '*{{connectionType}} {{suffix}}',
        'Interface Type'                       => '*{{connectionType}} {{suffix}}',
        'Main Connection'                      => '*{{connectionType}} {{suffix}}',
        'Main Connection Compatibility'        => '*{{connectionType}} {{suffix}}',
        'Main Connection Type'                 => '*{{connectionType}} {{suffix}}',
        'Main Connectivity'                    => '*{{connectionType}} {{suffix}}',
        'Main Connectivity Compatibility'      => '*{{connectionType}} {{suffix}}',
        'Main Connectivity Type'               => '*{{connectionType}} {{suffix}}',
        'Main Gateway'                         => '*{{connectionType}} {{suffix}}',
        'Main Gateway Compatibility'           => '*{{connectionType}} {{suffix}}',
        'Main Gateway Type'                    => '*{{connectionType}} {{suffix}}',
        'Main Interface'                       => '*{{connectionType}} {{suffix}}',
        'Main Interface Compatibility'         => '*{{connectionType}} {{suffix}}',
        'Main Interface Type'                  => '*{{connectionType}} {{suffix}}',
        'Main Protocol'                        => '*{{connectionType}} {{suffix}}',
        'Main Protocol Compatibility'          => '*{{connectionType}} {{suffix}}',
        'Main Protocol Type'                   => '*{{connectionType}} {{suffix}}',
        'Protocol'                             => '*{{connectionType}} {{suffix}}',
        'Protocol Compatibility'               => '*{{connectionType}} {{suffix}}',
        'Protocol Type'                        => '*{{connectionType}} {{suffix}}',
        'Secondary Connection'                 => '*{{connectionType}} {{suffix}}',
        'Secondary Connection Compatibility'   => '*{{connectionType}} {{suffix}}',
        'Secondary Connection Type'            => '*{{connectionType}} {{suffix}}',
        'Secondary Connectivity'               => '*{{connectionType}} {{suffix}}',
        'Secondary Connectivity Compatibility' => '*{{connectionType}} {{suffix}}',
        'Secondary Connectivity Type'          => '*{{connectionType}} {{suffix}}',
        'Secondary Gateway'                    => '*{{connectionType}} {{suffix}}',
        'Secondary Gateway Compatibility'      => '*{{connectionType}} {{suffix}}',
        'Secondary Gateway Type'               => '*{{connectionType}} {{suffix}}',
        'Secondary Interface'                  => '*{{connectionType}} {{suffix}}',
        'Secondary Interface Compatibility'    => '*{{connectionType}} {{suffix}}',
        'Secondary Interface Type'             => '*{{connectionType}} {{suffix}}',
        'Secondary Protocol'                   => '*{{connectionType}} {{suffix}}',
        'Secondary Protocol Compatibility'     => '*{{connectionType}} {{suffix}}',
        'Secondary Protocol Type'              => '*{{connectionType}} {{suffix}}',


        'Base FS'                             => '*{{fileSystem}} {{suffix}}',
        'Base FS Compatibility'               => '*{{fileSystem}} {{suffix}}',
        'Base FS Type'                        => '*{{fileSystem}} {{suffix}}',
        'Base File System'                    => '*{{fileSystem}} {{suffix}}',
        'Base File System Compatibility'      => '*{{fileSystem}} {{suffix}}',
        'Base File System Type'               => '*{{fileSystem}} {{suffix}}',
        'FS'                                  => '*{{fileSystem}} {{suffix}}',
        'FS Compatibility'                    => '*{{fileSystem}} {{suffix}}',
        'FS Type'                             => '*{{fileSystem}} {{suffix}}',
        'File System'                         => '*{{fileSystem}} {{suffix}}',
        'File System Compatibility'           => '*{{fileSystem}} {{suffix}}',
        'File System Type'                    => '*{{fileSystem}} {{suffix}}',
        'Main FS'                             => '*{{fileSystem}} {{suffix}}',
        'Main FS Compatibility'               => '*{{fileSystem}} {{suffix}}',
        'Main FS Type'                        => '*{{fileSystem}} {{suffix}}',
        'Main File System'                    => '*{{fileSystem}} {{suffix}}',
        'Main File System Compatibility'      => '*{{fileSystem}} {{suffix}}',
        'Main File System Type'               => '*{{fileSystem}} {{suffix}}',
        'Secondary FS'                        => '*{{fileSystem}} {{suffix}}',
        'Secondary FS Compatibility'          => '*{{fileSystem}} {{suffix}}',
        'Secondary FS Type'                   => '*{{fileSystem}} {{suffix}}',
        'Secondary File System'               => '*{{fileSystem}} {{suffix}}',
        'Secondary File System Compatibility' => '*{{fileSystem}} {{suffix}}',
        'Secondary File System Type'          => '*{{fileSystem}} {{suffix}}',

        'Textile'        => '{{textile}} {{colorName}}',
        'Cover Material' => '{{textile}} {{colorName}}',
        'Fabric Type'    => '{{textile}} {{colorName}}',

        'Material'            => '{{material}}',
        'Upholstery Material' => '{{material}}',
        'Fill Material'       => '{{material}}',
        'Frame Material'      => '{{material}}',
        'Seat Material'       => '{{material}}',
        'Cookware Finish'     => '{{material}}',
        'Cookware Material'   => '{{material}}',
        'Fuel Type'           => '{{material}}',
        'Top Material'        => '{{material}}',
        'Base Material'       => '{{material}}',
        'Surface Material'    => '{{material}}',

        'Activity Type' => '{{activityType}} {{activitySuffix}}',
        'Activity'      => '{{activityType}} {{activitySuffix}}',

        'Memory Type'       => 'DDR# {{suffix}}',
        'Memory Technology' => 'DDR# {{suffix}}',

        'Power HP' => '##.# HP',
        'HP'       => '##.# HP',

        'Case Type'   => '{{prefix}} Towel {{suffix}}',
        'Form Factor' => '{{prefix}} ATX {{suffix}}',

        'Voltage'       => '##.# Volts',
        'Power Voltage' => '##.# Volts',

        'Rotational Speed' => '#####00 RPM',
        'Print Resolution' => '#####00 DPI',
        'Pressure'         => '##### PSI',
        'BTU Output'       => '#####00 BTU',
        'Calories'         => '##### Calories',
        'Heating Area'     => '##### square feet',
        'Brightness'       => '##### Lumens',
        'Contrast Ratio'   => '#####,###:1',

        'Display Size'     => '#.#"',
        'Drive Size'       => '##.# Inch',
        'Aspect Ratio'     => '{{aspectRatio}}',
        'GPM'              => '#.# GPM',
        'Weight Capacity'  => '{{intSize}} pounds',
        'Pieces in Set'    => '{{intSize}} Pieces',
        'Piece Count'      => '{{intSize}} Pieces',
        'Number of Pieces' => '{{intSize}} Pieces',
        'Table Length'     => '{{intSize}} Inches',
        'Maximum Pressure' => '{{intSize}} PSI',
        'Air Flow'         => '{{intSize}} CFM',


        'Zoom'                => '##.#x',
        'Optical Zoom'        => '##.#x',
        'Tank Capacity'       => '##.# Gallons',
        'Number of CPU Cores' => '{{intSize}}',
        'Number of Ports'     => '{{intSize}} Ports',

        'Connectors'         => '##### Pin',
        'Power'              => '##### Watts',
        'Wattage'            => '##### Watts',
        'Memory Form Factor' => '#####-pin {{prefix}}-DIMM',
        'Frame Size'         => '{{sizeX}}',
        'Picture Size'       => '{{sizeX}}',

        'Shape'       => '{{shape}} {{sizeX}}',
        'Size & Type' => '{{shape}} {{sizeX}}',

        'Genre'   => '{{theme}}',
        'Subject' => '{{theme}}',

        'Theme'             => '{{theme}} & {{theme}}',
        'Tabletop Occasion' => '{{theme}} & {{theme}}',
        'Sculpture Type'    => '{{theme}} & {{theme}}',
        'Weathervane Theme' => '{{theme}} & {{theme}}',

        'Pattern'          => '{{pattern}} {{shape}}',
        'Chair Back Style' => '{{pattern}} {{shape}}',
        'Style'            => '{{pattern}} {{shape}}',

        'Scent'     => '{{fruit}} {{theme}}',
        'Size'      => '{{prefix}} {{clothesSize}}',
        'Thickness' => '##### Inches',

        'Thread Count'     => '#####',
        'Seating Capacity' => '#####',

        'Language'             => '{{country}}',
        'Country'              => '{{country}}',
        'Manufacturer Country' => '{{country}}',

        'Author'    => '{{firstName}} {{lastName}}',
        'Publisher' => '{{firstName}} {{lastName}}',
    ];

    public function attributeName() {
        $format = $this->generator->randomElement(array_keys($this->attributes));

        return $this->generator->parse($format);
    }

    public function attributeValue($attributeName = null) {

        if (!isset($this->attributes[$attributeName])) {
            $attributeName = $this->attributeName();
        }

        $valueFormat = $this->attributes[$attributeName];

        return $this->generator->parse(
            $this->generator->asciify(
                $this->generator->bothify($valueFormat)
            )
        );
    }

    public function intSize() {
        return $this->generator->numberBetween(1, 500);
    }

    public function powTwo() {
        return pow(2, $this->generator->numberBetween(1, 15));
    }

    public function all() {
        return array_keys($this->attributes);
    }

}