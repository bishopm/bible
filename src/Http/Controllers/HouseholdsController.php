<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Repositories\HouseholdsRepository;
use Bishopm\Bible\Repositories\GroupsRepository;
use Bishopm\Bible\Repositories\SettingsRepository;
use Bishopm\Bible\Models\Household;
use Bishopm\Bible\Models\User;
use Bishopm\Bible\Models\Individual;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreateHouseholdRequest;
use Bishopm\Bible\Http\Requests\UpdateHouseholdRequest;
use Bishopm\Bible\Models\Setting;
use Illuminate\Http\Request;

class HouseholdsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $household;
    private $groups;
    private $setting;

    public function __construct(HouseholdsRepository $household, GroupsRepository $groups, SettingsRepository $setting)
    {
        $this->household = $household;
        $this->groups = $groups;
        $this->setting = $setting;
    }

    public function index()
    {
        $households = $this->household->all();
        return view('bible::households.index', compact('households'));
    }

    public function edit(Household $household)
    {
        $data['household']=$household;
        foreach ($household->individuals as $indiv) {
            if (strlen($indiv->cellphone)==10) {
                $data['cellphones'][$indiv->id]['name']=$indiv->firstname;
            }
        }
        return view('bible::households.edit', $data);
    }

    public function create()
    {
        return view('bible::households.create');
    }

    public function show(Household $household)
    {
        $pastoralgroup=$this->setting->getkey('pastoral_group');
        if ((isset($pastoralgroup)) and ($pastoralgroup<>'Pastoral group')) {
            $group=$this->groups->find($pastoralgroup);
            foreach ($group->individuals as $indiv) {
                $dum['id']=$indiv->id;
                $dum['firstname']=$indiv->firstname;
                $dum['surname']=$indiv->surname;
                $data['pastors'][]=$dum;
            }
        } else {
            $data['pastors']=array();
        }
        $data['groups']=$this->groups->all();
        $data['household']=$household;
        $data['tags']=Individual::allTags()->get();
        $data['logs']=array();
        foreach ($household->individuals as $indiv) {
            $activity=$indiv->activity->last();
            if ($activity) {
                if ($activity->causer_id) {
                    $user=User::find($activity->causer_id);
                    $thislog=ucfirst($activity['description']) . " by " .  $user->individual->firstname . " " . $user->individual->surname . " on " . date("d M Y", strtotime($activity['created_at']));
                } else {
                    $thislog=ucfirst($activity['description']) . " by System on " . date("d M Y", strtotime($activity['created_at']));
                }
                $data['logs'][$indiv->id]=$thislog;
            }
            if ($indiv->tags) {
                foreach ($indiv->tags as $itag) {
                    $data['itags'][$indiv->id][]=$itag->name;
                }
            }
            if ($indiv->groups) {
                foreach ($indiv->groups as $group) {
                    $data['igroups'][$indiv->id][]=$group->id;
                }
            }
        }
        return view('bible::households.show', $data);
    }

    public function store(CreateHouseholdRequest $request)
    {
        $household=$this->household->create($request->all());

        return redirect()->route('admin.households.show', $household->id)
            ->withSuccess('New household added - now add an individual');
    }

    public function update(Household $household, UpdateHouseholdRequest $request)
    {
        $this->household->update($household, $request->all());
        if (null!==$request->input('latitude')) {
            return redirect()->route('admin.households.index')->withSuccess('Household has been updated');
        } else {
            return redirect()->route('mydetails')->withSuccess('Household has been updated');
        }
    }

    public function api_households(Request $request)
    {
        $q=$request->search;
        $individuals=Individual::with('household')->where('surname', 'like', '%' . $q . '%')->orwhere('firstname', 'like', '%' . $q . '%')->orderBy('surname')->orderBy('firstname')->get();
        return $individuals;
    }

    public function api_household($id)
    {
        return $this->household->findForApi($id);
    }

    public function destroy($id)
    {
        $household=$this->household->find($id);
        $household->delete();
        return redirect()->route('admin.households.index')->withSuccess('Household has been deleted');
    }
}
