<?php

namespace entities;

use DateTime;

/**
 * Domain model for Reports
 */
class Report
{
    public ?string $category;
    public DateTime $firstDate;
    public DateTime $lastDate;
    public string $type;
}