<?php namespace Premmerce\DevTools\DataGenerator\Providers\Attributes;

trait ActivityTrait
{
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

    protected $activitySuffixes = [
        'fighting',
        'board games',
        'racing',
        'sports',
        'ball',
        'games',
        'family',
        'twirling',
        'swimming',
        'activities',
        'discipline',
    ];

    public function activitySuffix() {
        return $this->generator->randomElement($this->activitySuffixes);
    }

    public function activityType() {
        return $this->generator->randomElement($this->activityTypes);
    }

}