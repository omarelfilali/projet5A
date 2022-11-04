<?php

namespace App\Http\Controllers\Administration\Materiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use Illuminate\Validation\ValidationException;

use Carbon\Carbon;

class OptionController extends Controller
{
    public function index() {
        $title = __('msg.options');
        $small_title = __('msg.manage');

        $option1 = Option::findOrFail('emprunts_from')->first();
        $emprunts_from = \Carbon::createFromFormat('d/m/Y', $option1->value);

        return view('administration.materiel.options.index')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('emprunts_from', $emprunts_from)
            ;
    }

    public function update(Request $request){
        $rules = [
            'loan_start_date' => [
                'bail',
                'required',
                'date_format:d/m/Y',
            ],
        ];

        $messages = [];
        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            toastr()->error(__('validation.options.updated.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $loan_start_date_carbon = Carbon::createFromFormat('d/m/Y', $request->loan_start_date);
        $loan_start_date = $loan_start_date_carbon->format('d/m/Y');
        $option_loan_start_date = Option::findOrFail('emprunts_from')->first();
        $option_loan_start_date->value = $loan_start_date;
        $option_loan_start_date->save();

        toastr()->success(__('validation.options.updated.success'));

        return redirect()->route('administration.materiel.options.index');
    }

}
