<?php

namespace App\Console\Commands;

use App\Block;
use App\Event;
use App\EventSettings;
use App\Item;
use App\Map;
use App\Program;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateEventData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate fake event data to test with';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $date = Carbon::now();
//
//        $event = New Event;
//        $event->name = 'The cool kids invation event';
//        $event->description = '<h1>test</h1>';
//        $event->save();
//
//        $event = Event::query()->where('name', 'The cool kids invation event')->first();
//
//        $settings = new EventSettings;
//        $settings->event_id = $event->id;
//        $settings->visible_registrations = EventSettings::__VISIBLE_REGISTRATIONS__;
//        $settings->max_registrations = EventSettings::__MAX_REGISTRATIONS__;
//        $settings->primary_color = "#7d4497";
//        $settings->secondary_color = "#649744";
//        $settings->date_start = $date;
//        $settings->date_end = $date->copy()->addWeek();
//        $settings->active = true;
//        $settings->save();
//
//        $program = new Program;
//        $program->name = "some program";
//        $program->type = Program::__PROGRAM__;
//        $program->description = "testeesttes";
//        $program->date_start = $date->copy()->addHour();
//        $program->date_end = $date->copy()->addHour(4);
//        $program->event_id = $event->id;
//        $program->active = true;
//        $program->save();
//
//        $program = Program::query()->where('name', 'some program')->first();
//
//        $block = new Block;
//        $block->program_id = $program->id;
//        $block->date_start = $date->copy()->addHour();
//        $block->date_end = $date->copy()->addHour(1);
//        $block->save();
//
//        $block = Block::query()->where('program_id', $program->id)->first();
//
//        $item = new Item;
//        $item->name = "Item 1";
//        $item->type = Item::__KEYNOTES__;
//        $item->description = "<p>test bro xd some message</p>";
//        $item->block_id = $block->id;
//        $item->date_start = $date->copy()->addHour();
//        $item->date_end = $date->copy()->addHour(1);
//        $item->active = true;
//        $item->save();
//
//        $item = new Item;
//        $item->name = "Item 2";
//        $item->type = Item::__NONE__;
//        $item->description = "<p>test bro xd some message</p>";
//        $item->block_id = $block->id;
//        $item->date_start = $date->copy()->addHour();
//        $item->date_end = $date->copy()->addHour(1);
//        $item->active = true;
//        $item->save();
//
//        $map = new Map;
//        $map->name = "Map name";
//        $map->json = "{}";
//        $map->event_id = $event->id;
//        $map->active = true;
//        $map->save();
//
//        return 'success created fake event';
    }
}
