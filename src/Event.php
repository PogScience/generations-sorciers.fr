<?php
namespace PogScience;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Parsedown;
use Sabre\VObject;

class Event
{
    public string $title;
    public string $subtitle;
    public string $streamer;
    public string $link;
    public string $icon;
    public string $with;
    public string $description;
    private string $raw_description;
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
        $this->raw_description = $raw_event['description'] ?? "";

        // Updates the timezone without changing the date so PHP uses the correct timezone without shifting the date on
        // timezone change (and ISO date in <time> tags is correct).
        $this->date = new DateTimeImmutable($raw_event['date']->format('Y-m-d H:i:s'), new DateTimeZone('Europe/Paris'));
        $this->duration = DateInterval::createFromDateString($raw_event['duration']);

        $this->final = $raw_event['final'] ?? false;
        $this->hidden = $raw_event['hidden'] ?? false;

        // The icon is either the `icon` field, or the `link` without `https://twitch.tv/` and with `.png`
        // If the `icon` field is `false`, then, no icon at all.
        if (!isset($raw_event['icon']) || $raw_event['icon'] !== false) {
            $this->icon = '/assets/streamers/' . ($raw_event['icon'] ?? str_replace('https://twitch.tv/', '', $this->link) . '.png');
        }
        else {
            $this->icon = "";
        }
    }

    /**
     * @return string The event's hour in short readable format (either like “20h” or “18h30” if non-zero minutes).
     */
    public function hour() : string {
        return $this->format_time($this->date);
    }

    /**
     * @return string The date in ISO format
     */
    public function dateISO() : string {
        return $this->date->format(DATE_ISO8601);
    }

    /**
     * @return string The date in ISO format
     */
    public function endDateISO() : string {
        return $this->date->add($this->duration)->format(DATE_ISO8601);
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

    public function hour_end() : string {
        return $this->format_time($this->date->add($this->duration));
    }

    /**
     * @return string The event's ending hour in short readable format (either like “20h” or “18h30” if non-zero minutes).
     */
    private function format_time(DateTimeInterface $date) : string {
        return $date->format('H') . 'h' . ($date->format('i') !== '00' ? $date->format('i') : '');
    }

    public function as_ical() : array {
        return [
            "UID"         => md5($this->streamer . $this->dateISO()) . '.generations-sorciers.fr',
            "SUMMARY"     => trim(strip_tags($this->title)),
            "DESCRIPTION" => 'Par ' . trim($this->streamer) . ($this->with ?? "\n" . trim(strip_tags($this->with))) . "\n\n" . trim(strip_tags($this->raw_description)),
            "LOCATION"    => $this->link,
            "DTSTART"     => $this->date,
            "DTEND"       => $this->date->add($this->duration)
        ];
    }
}
