<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteConfig;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
    public function index(){
        return view('Backend.Admin.WebsiteSettings.index');
    }

    public function settings_tab_index($tab){
        abort_if(!method_exists($this, $tab.'_settings'), 404);

        $form_fields = $this->{$tab.'_settings'}();
        return view('Backend.Admin.WebsiteSettings.form', compact('form_fields', 'tab'));
    }

    public function settings_tab_save(Request $request, $tab){
        abort_if(!method_exists($this, $tab.'_settings'), 404);
        $form_fields = collect($this->{$tab.'_settings'}())->map(function($field) {
            return str_replace(['[', ']'], ['.', ''], $field['name']);
        })->toArray();

        $data = $request->only($form_fields);

        foreach ($data as $key => $value) {
            $key = str_replace('__', '.', $key);
            $existing_one = SiteConfig::where('key', $key)->first();
            if($existing_one) {
                $existing_one->value = array_merge($existing_one->value, $value);
                $existing_one->save();
            }else{
                SiteConfig::create(['key' => $key, 'value' => $value]);
            }
        }

        return to_route('backend.website-settings.tab', $tab)->with('success', __('Data Updated Successfully'));
    }


    //Bank settings
    private function bank_settings(){
        return [
            $this->field_data(['title' => 'Name','name' => 'app__bank[name]','id' => 'bank__name', 'value' => config('app.bank.name')]),
            $this->field_data(['title' => 'Account holder','name' => 'app__bank[account_holder]','id' => 'bank__account_holder', 'value' => config('app.bank.account_holder')]),
            $this->field_data(['title' => 'Account number','name' => 'app__bank[account_number]','id' => 'bank__account_number', 'value' => config('app.bank.account_number')]),
            $this->field_data(['title' => 'IBAN','name' => 'app__bank[IBAN]','id' => 'bank__IBAN', 'value' => config('app.bank.IBAN')]),
        ];
    }

    //Function to set default field data
    private function field_data(array $field_data){
        $default = [
            'type'  => 'text',
            'title' => '',
            'name'  => '',
            'id'    => '',
            'root_class' => '',
            'value' => '',
        ];

        return array_merge($default, $field_data);
    }
}
