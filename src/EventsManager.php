<?php
namespace PogScience;

use Sabre\VObject;
use Symfony\Component\Yaml\Yaml;

class EventsManager
{
    public array $events = [];
    public int $events_count = 0;
    public bool $has_hidden_events = false;
    public bool $all_finished = true;

    public function load() {
        $raw_events = Yaml::parseFile("../data/events.yaml", Yaml::PARSE_DATETIME);
        $flat_events = [];

        foreach ($raw_events as $raw_event) {
            $event = new Event($raw_event);

            if ($event->hidden) {
                $this->has_hidden_events = true;

                if (!defined('GS_PREVIEW')) {
                    continue;
                }
            }

            if (!$event->past()) {
                $this->all_finished = false;
            }

            $flat_events[] = $event;
        }

        // We sort events by date
        usort($flat_events, function($a, $b) {
            if ($a->date === $b->date) {
                return 0;
            }

            return $a->date < $b->date ? -1 : 1;
        });

        $this->events_count = count($flat_events);

        // Then group events by day
        foreach ($flat_events as $event) {
            $this->events[$event->date->format("Y-m-d")][] = $event;
        }
    }

    public function calendar() : VObject\Component\VCalendar {
        $cal = new VObject\Component\VCalendar();

        $cal->NAME = 'Générations Sorciers';
        $cal->DESCRIPTION = 'Tous les streams de l\'événement Générations Sorciers !';
        $cal->URL = 'https://generations-sorciers.fr';
        $cal->{'TIMEZONE-ID'} = 'Europe/Paris';

        $cal->{'X-WR-CALNAME'} = 'Générations Sorciers';
        $cal->{'X-WR-CALDESC'} = 'Tous les streams de l\'événement Générations Sorciers !';
        $cal->{'X-WR-TIMEZONE'} = 'Europe/Paris';

        foreach ($this->events as $date => $events) {
            foreach ($events as $event) {
                $cal->add('VEVENT', $event->as_ical());
            }
        }

        return $cal;
    }
}
