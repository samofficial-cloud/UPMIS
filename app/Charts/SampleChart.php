<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Traits\dashboardtrait;
use Balping\JsonRaw\Raw;

class SampleChart extends Chart
{
	//use dashboardtrait;
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}
