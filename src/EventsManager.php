<?php
namespace PogScience;

use Symfony\Component\Yaml\Yaml;

class EventsManager
{
    public array $events = [];

    public function load() {
        $raw_events = Yaml::parseFile("../data/events.yaml", Yaml::PARSE_DATETIME);
        $flat_events = [];

        foreach ($raw_events as $raw_event) {
            $flat_events[] = new Event($raw_event);
        }

        // We sort events by date
        usort($flat_events, function($a, $b) {
            if ($a->date === $b->date) {
                return 0;
            }

            return $a->date < $b->date ? -1 : 1;
        });

        // Then group events by day
        foreach ($flat_events as $event) {
            $this->events[$event->date->format("Y-m-d")][] = $event;
        }
    }
}