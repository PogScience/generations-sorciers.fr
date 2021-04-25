<?php
namespace PogScience;

use Symfony\Component\Yaml\Yaml;

class EventsManager
{
    public array $events = [];
    public int $events_count = 0;
    public bool $has_hidden_events = false;

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
}
