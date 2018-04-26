<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Repositories\IndividualsRepository;
use Bishopm\Bible\Repositories\EmployeesRepository;
use Bishopm\Bible\Models\Individual;
use Bishopm\Bible\Models\Leaveday;
use Bishopm\Bible\Models\Household;
use Bishopm\Bible\Models\Employee;
use Bishopm\Bible\Http\Requests\CreateEmployeeRequest;
use Bishopm\Bible\Http\Requests\UpdateEmployeeRequest;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StaffController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $individual;

    public function __construct(IndividualsRepository $individual, EmployeesRepository $employee)
    {
        $this->individual = $individual;
        $this->employee = $employee;
    }

    public function index()
    {
        $individuals = $this->individual->staff();
        $memberindivs = Individual::withTag('staff')->get();
        $staffs = array();
        $thisyr=date("Y");
        foreach ($individuals as $indiv) {
            $dum=array();
            $staffs[$indiv->surname . $indiv->firstname]=$indiv;
            foreach ($indiv->employee->leavedays as $leave) {
                if (!isset($dum[$leave->leavetype])) {
                    $dum[$leave->leavetype]=0;
                }
                if (substr($leave->leavedate, 0, 4)==$thisyr) {
                    $dum[$leave->leavetype]=$dum[$leave->leavetype]+1;
                }
            }
            $staffs[$indiv->surname . $indiv->firstname]['leave']=$dum;
        }
        foreach ($memberindivs as $mindiv) {
            $dum=array();
            $staffs[$mindiv->surname . $mindiv->firstname]=$mindiv;
            foreach ($mindiv->employee->leavedays as $leave) {
                if (!isset($dum[$leave->leavetype])) {
                    $dum[$leave->leavetype]=0;
                }
                if (substr($leave->leavedate, 0, 4)==$thisyr) {
                    $dum[$leave->leavetype]=$dum[$leave->leavetype]+1;
                }
            }
            $staffs[$mindiv->surname . $mindiv->firstname]['leave']=$dum;
        }
        asort($staffs);
        return view('bible::staff.index', compact('staffs', 'thisyr'));
    }

    public function show($slug, $thisyr="")
    {
        if (!$thisyr) {
            $thisyr=date('Y');
        }
        $staff=$this->individual->employee($slug);
        $leaveyear=array();
        $yrleave=array();
        $leavedates=array();
        if ($staff->employee) {
            foreach ($staff->employee->leavedays as $leave) {
                if (substr($leave->leavedate, 0, 4)==$thisyr) {
                    $leaveyear[$leave->leavetype][]=$leave->leavedate;
                    if (isset($leaveyear[$leave->leavetype]['total'])) {
                        $leaveyear[$leave->leavetype]['total']=$leaveyear[$leave->leavetype]['total']+1;
                    } else {
                        $leaveyear[$leave->leavetype]['total']=1;
                    }
                    $leavedates[]=$leave->leavedate;
                    $yrleave[]=$leave;
                }
            }
        }
        $leavedates=json_encode($leavedates);
        return view('bible::staff.show', compact('staff', 'leaveyear', 'thisyr', 'leavedates', 'yrleave'));
    }

    public function create(Individual $individual)
    {
        return view('bible::staff.create', compact('individual'));
    }

    public function edit($id)
    {
        $employee= $this->employee->find($id);
        return view('bible::staff.edit', compact('employee'));
    }

    public function store(CreateEmployeeRequest $request)
    {
        $this->employee->create($request->all());
        return redirect()->route('admin.staff.index')
            ->withSuccess('Employee data added');
    }

    public function addleave(Request $request)
    {
        $leavedates=explode(',', $request->leavedate);
        $leavetype=$request->leavetype;
        $indivslug=substr(strrchr($request->server('HTTP_REFERER'), '/'), 1);
        $individ=Individual::where('slug', $indivslug)->first()->employee->id;
        foreach ($leavedates as $ld) {
            $ldt=Leaveday::create(['employee_id' => $individ, 'leavetype' => $leavetype, 'leavedate' => $ld]);
        }
        return redirect()->route('admin.staff.show', $indivslug);
    }

    public function update($employee, UpdateEmployeeRequest $request)
    {
        $this->employee->update($employee, $request->all());
        return redirect()->route('admin.staff.index')
            ->withSuccess('Employee data updated');
    }
}
