<?php namespace Premmerce\DevTools\DataGenerator\Providers\Attributes;

trait TechTrait
{
    protected $connectionTypes = [
        'Fibre Channel',
        'SCSI',
        'SAS',
        'Ethernet',
        'USB',
        'Firewire',
        'Bluetooth',
        'Serial',
        'ATA',
        'SATA',
        'WIFI',
        'DSL',
        'Cable',
        'Wireless',
        'LAN',
        'WAN',
        'NFC',
        'IDE',
        'ATA',
        'UDMA',
        'DMA',
        'MCA',
        'PCI',
        'AGP',
        'ISA',
    ];

    protected $prefixes = [
        'm',
        'SO',
        'Extended',
        'ex',
        'X',
        'L',
        'A',
        'Hydro',
        'Resistive',
        'Super',
        'Mega',
        'Extra',
        'Multi',
        'Ultra',
        'Mini',
        'Mid',
        'Full',
        'Micro',
        'Flex',
        'Digital',
        'Touch',
        'Capacitive',
        'Organic',
        'Tactile',
    ];

    protected $suffixes = [
        'II',
        'III',
        'v1',
        'v2',
        'v3',
        '3.x',
        '+',
        '3D',
        'x',
        'XL',
        's',
        'Plus',
        'One',
        'X',
        'LTE',
        'Express',
        'Exp',
        'g',
        'G',
    ];

    public function connectionType() {
        return $this->generator->randomElement($this->connectionTypes);
    }

    public function prefix() {
        $prefix = $this->generator->randomElement($this->prefixes);

        return $prefix;
    }

    public function suffix() {
        $suffix = $this->generator->randomElement($this->suffixes);

        return $suffix;
    }
}