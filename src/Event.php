<?php
namespace PogScience;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Parsedown;

class Event
{
    public string $title;
    public string $subtitle;
    public string $streamer;
    public string $link;
    public string $with;
    public string $description;
    public DateTimeInterface $date;
    public DateInterval $duration;
    public bool $final;
    public bool $hidden;

    public function __construct(array $raw_event)
    {
        $parsedown = new Parsedown();

        $this->title = trim($parsedown->line($raw_event['title']));
        $this->subtitle = isset($raw_event['subtitle']) ? trim($parsedown->line($raw_event['subtitle'])) : "";
        $this->streamer = isset($raw_event['streamer']) ? trim($parsedown->line($raw_event['streamer'])) : "";;
        $this->link = substr($raw_event['link'], 0, 4) === 'http' ? $raw_event['link'] : 'https://twitch.tv/' . $raw_event['link'];
        $this->with = isset($raw_event['with']) ? trim($parsedown->line($raw_event['with'])) : "";
        $this->description = isset($raw_event['description']) ? trim($parsedown->text($raw_event['description'])) : "";

        // Updates the timezone without changing the date so PHP uses the correct timezone without shifting the date on
        // timezone change (and ISO date in <time> tags is correct).
        $this->date = new DateTimeImmutable($raw_event['date']->format('Y-m-d H:i:s'), new DateTimeZone('Europe/Paris'));
        $this->duration = DateInterval::createFromDateString($raw_event['duration']);
        $this->final = $raw_event['final'] ?? false;
        $this->hidden = $raw_event['hidden'] ?? false;
    }

    /**
     * @return string The event's hour in short readable format (either like “20h” or “18h30” if non-zero minutes).
     */
    public function hour() : string {
        return $this->date->format('H') . 'h' . ($this->date->format('i') !== '00' ? $this->date->format('i') : '');
    }

    /**
     * @return string The date in ISO format
     */
    public function dateISO() : string {
        return $this->date->format(DATE_ISO8601);
    }

    /**
     * @return bool True if the stream is currently live, according to the date/duration.
     */
    public function live() : bool {
        $now = new DateTime();
        return $now > $this->date && $now < $this->date->add($this->duration);
    }

    /**
     * @return bool True if the stream is finished, and lies in the past.
     */
    public function past() : bool {
        return new DateTime() > $this->date->add($this->duration);
    }
}
