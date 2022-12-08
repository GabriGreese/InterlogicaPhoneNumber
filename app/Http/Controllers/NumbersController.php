<?php

namespace App\Http\Controllers;

use App\Facades\NumberFacade;
use App\Helpers\AppHelper;
use App\Imports\NumbersImport;
use App\Models\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class NumbersController
 *
 * @package App\Http\Controllers
 */
class NumbersController extends Controller
{
    /**
     * Index view
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('numbers');
    }

    /**
     * Ajax data for Datatables
     *
     * @return mixed
     * @throws \Exception
     */
    public function indexAjax(Request $request)
    {
        $numbers = Number::all();

        // if empty import csv
        if ($numbers->count() === 0) {
            $this->importNumbers(); // db table empty, import numbers...
        }

        $numbers = datatables()->of($numbers)->addColumn('correctness', function ($number) {
            $html = '<span class="badge bg-success">Correct</span>';

            $res = NumberFacade::checkValidity($number->sms_phone, true);
            if (!$res['status']) {
                $html = '<span class="badge bg-danger">Invalid</span> <a href="javascript:void(0);" title="Edit number" data-path="' . route('number.edit', $number->id) . '" class="badge bg-primary load-modal">Suggested: &quot;<strong>' . $res['suggested'] . '</strong>&quot;</span>';
            }

            return $html;
        })->addColumn('actions', function ($number) {
            $actions[] = '<a class="dropdown-item load-modal" href="javascript:void(0);" data-path="' . route('number.edit', $number->id) . '">Edit number</a>';
            return AppHelper::datatableActions($actions);
        })->rawColumns(['actions', 'correctness'])->toJson();

        return $numbers;
    }

    /**
     * Import Numbers from CSV
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importNumbers()
    {
        Excel::import(new NumbersImport, Storage::disk('private')->path('south_african_mobile_numbers.csv'));

        return redirect()->route('number.indexAjax');
    }

    /**
     * Phone # edit modal
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $number = Number::findOrFail($id);

        $correctness = NumberFacade::checkValidity($number->sms_phone, true);

        return view('modals.edit', compact('number', 'correctness'));
    }

    /**
     * Phone # Update function
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'sms_phone' => 'required',
        ]);

        $params = $request->only('sms_phone');

        if (!Number::findOrFail($id)->update($params)) {
            return redirect()->route('number.index')->with('error', 'Cannot update Phone #');
        }
        return redirect()->route('number.index')->with('success', 'Phone # updated successfully');
    }

    /**
     * Check for correctness of a mobile number
     * via Ajax
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function checkCorrectness(Request $request)
    {
        $params = $request->only('sms_phone');

        return NumberFacade::checkValidity($params['sms_phone'], true);
    }
}
