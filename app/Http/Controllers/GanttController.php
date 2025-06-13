<?php
namespace App\Http\Controllers;
use App\Models\GanttLink;
use App\Models\GanttTask;
use App\Models\Project;
use Carbon\Carbon;
use Dhtmlx\Connector\GanttConnector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class GanttController extends Controller
{
    public function data($project_id) {
        $tasks = GanttTask::where('project_id', $project_id)->orderBy('sortorder')->get();

        echo $this->data_json($tasks);
    }

    public function all_data() {
        $projects = Project::where('type', 'work')->get();
        $colors = Config::get('color.gantt_colors');

        $tasks_array = [];
        $links_array = [];

        if (count($projects) > 0) {
            foreach ($projects as $project) {
                if (count($project->gantt_tasks) > 0) {
                    $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $project->gantt_tasks()->min('start_date'));
                    $tasks_array[] = ['id' => 'p' . $project->id, 'start_date' => $project->gantt_tasks()->min('start_date'), 'duration' => $start_date->diffIndays(Carbon::createFromFormat('Y-m-d H:i:s', $project->gantt_tasks()->max('end_date'))), 'text' => $project->production_name() . ' ' . $project->name, 'progress' => ($project->gantt_tasks()->sum('progress')) / count($project->gantt_tasks), 'sortorder' => 0, 'parent' => 0, 'color' => $colors['project_overview']];

                    foreach ($project->gantt_tasks as $task) {

                        $tasks_array[] = ['id' => $task->id, 'start_date' => $task->start_date, 'duration' => $task->duration, 'text' => $task->text, 'progress' => $task->progress, 'sortorder' => $task->sortorder, 'parent' => 'p' . $project->id, 'color' => isset($colors[$task->operation]) ? $colors[$task->operation] : ''];

                        if (!is_null($task->links) && sizeof($task->links) > 0) {
                            $links_array = array_merge($links_array, $task->links->toArray());
                        }
                    }
                }

            }
        }

        /*
         * QUICK FIX // @TODO Peter: remove
         */
        $tasks_array = [
            [
                'id' => 'p22',
                'start_date' => '2017-04-03 00:00:00',
                'duration' => 125,
                'text' => '347GM GENERAL Gotec',
                'progress' => '70.0',
                'sortorder' => 0,
                'parent' => 0,
                'color' => '#7b8d8e'
            ],
            [
                'id' => 'p114',
                'start_date' => '2017-06-12 00:00:00',
                'duration' => 24,
                'text' => '383PS Polipol Consolidare Hala1',
                'progress' => '50.0',
                'sortorder' => 0,
                'parent' => 0,
                'color' => '#7b8d8e'
            ],
            [
                'id' => 'p130',
                'start_date' => '2017-06-13 00:00:00',
                'duration' => 33,
                'text' => '384HA Hala depozit',
                'progress' => '5.0',
                'sortorder' => 0,
                'parent' => 0,
                'color' => '#7b8d8e'
            ],
            [
                'id' => 'p124',
                'start_date' => '2017-06-21 00:00:00',
                'duration' => 52,
                'text' => '390SK SERVICE AUTO KOVACS SERVICE TASNAD',
                'progress' => '0.0',
                'sortorder' => 0,
                'parent' => 0,
                'color' => '#7b8d8e'
            ],
            [
                'id' => 'p128',
                'start_date' => '2017-06-28 00:00:00',
                'duration' => 6,
                'text' => '394PF Feronerie',
                'progress' => '50.0',
                'sortorder' => 0,
                'parent' => 0,
                'color' => '#7b8d8e'
            ],
            [
                'id' => 'p129',
                'start_date' => '2017-06-30 00:00:00',
                'duration' => 32,
                'text' => '395CP Corp Exterior - CONTAINER',
                'progress' => '0.0',
                'sortorder' => 0,
                'parent' => 0,
                'color' => '#7b8d8e'
            ],
        ];
        /*
         * END QUICKFIX
         */

        echo '{"data": ' . json_encode($tasks_array) . ', "collections": { "links" : ' . json_encode($links_array) . '}}';
    }

    public function store() {
        //dd($request->all());
        unset($_POST[$_POST['ids'] . '_color']);

        $connector = new GanttConnector(null, "PHPLaravel");
        $connector->render_links(new GanttLink(), "id", "source,target,type");
        $connector->render_table(new GanttTask(),"id","start_date,duration,text,progress,parent");
    }

    private function data_json($tasks = null) {
        $tasks_array = [];
        $links_array = [];
        $colors = Config::get('color.gantt_colors');
        if (!is_null($tasks) && sizeof($tasks) > 0) {
            foreach ($tasks as $task) {
                $tasks_array[] = ['id' => $task->id, 'start_date' => $task->start_date, 'duration' => $task->duration, 'text' => $task->text, 'progress' => $task->progress, 'sortorder' => $task->sortorder, 'parent' => $task->parent, 'color' => isset($colors[$task->operation]) ? $colors[$task->operation] : ''];

                if (!is_null($task->links) && sizeof($task->links) > 0) {
                    $links_array = array_merge($links_array, $task->links->toArray());
                }
            }
        }

        return '{"data": ' . json_encode($tasks_array) . ', "collections": { "links" : ' . json_encode($links_array) . '}}';
    }
}