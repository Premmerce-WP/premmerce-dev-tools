<?php namespace Premmerce\DevTools\DataGenerator\Providers\Attributes;

trait OSTrait
{
    protected $operatingSystems = [
        'Android',
        'FreeBSD',
        'ChromeOS',
        'Debian',
        'Linux',
        'CentOS',
        'Kubuntu',
        'ReactOS',
        'Xubuntu',
        'Lubuntu',
        'SteamOS',
        'Ubuntu',
        'MacOS',
        'iOS',
        'Raspberry Pi',
        'JavaOS',
        'MS-DOS',
        'Red Hat',
        'openSUSE',
        'Symbian',
        'Unix',
        'Windows',
        'Arch Linux',
        'Solaris',
        'Fedora',
        'Elementary OS',
    ];

    protected $versionNames = [
        'Phone',
        'Cupcake',
        'Donut',
        'Eclair',
        'Froyo',
        'Gingerbread',
        'Honeycomb',
        'Sandwich',
        'Jelly Bean',
        'KitKat',
        'Lollipop',
        'Marshmallow',
        'Nougat',
        'Oreo',
        'Warthog',
        'Hedgehog',
        'Badger',
        'Drake',
        'Eft',
        'Fawn',
        'Gibbon',
        'Heron',
        'Ibex',
        'Jackalope',
        'Koala',
        'Lynx',
        'Meerkat',
        'Narwhal',
        'Ocelot',
        'Pangolin',
        'Quetzal',
        'Ringtail',
        'Salamander',
        'Tahr',
        'Unicorn',
        'Vervet',
        'Werewolf',
        'Xerus',
        'Yak',
        'Zapus',
        'Aardvark',
        'Beaver',
        'X',
        'N',
        'XP',
        'Server',
        'Me',
        'NT',
    ];

    public function operatingSystem() {
        return $this->operatingSystemName() . ' ' . $this->operatingSystemVersion();
    }

    public function operatingSystemName() {
        return $this->generator->randomElement($this->operatingSystems);
    }

    public function operatingSystemVersion() {
        return $this->generator->boolean
            ? $this->generator->randomElement($this->versionNames)
            : $this->generator->randomDigit;
    }

}