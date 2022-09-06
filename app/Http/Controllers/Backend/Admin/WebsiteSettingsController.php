<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WebsiteSettingsController extends Controller
{
    public function index()
    {
        return view('Backend.Admin.WebsiteSettings.index');
    }

    public function settings_tab_index($tab)
    {
        abort_if(!method_exists($this, $tab . '_settings'), 404);

        $form_fields = $this->{$tab . '_settings'}();
        return view('Backend.Admin.WebsiteSettings.form', compact('form_fields', 'tab'));
    }

    public function settings_tab_save(Request $request, $tab)
    {
        abort_if(!method_exists($this, $tab . '_settings'), 404);
        $form_fields = collect($this->{$tab . '_settings'}())->map(function ($field) {
            return str_replace(['[', ']'], ['.', ''], $field['name']);
        })->toArray();



        $data = $request->only($form_fields);

        if($request->has('reset_defaults')){
            $keys_to_be_removed_from_db = collect($this->{$tab . '_settings'}())->map(function ($field) {
                return str_replace('__', '.', preg_replace('/\[(.*?)\]/', '', $field['name']));
            })->unique()->values()->toArray();
            SiteConfig::whereIn('key', $keys_to_be_removed_from_db)->delete();

            Cache::forget('db_config');

            return to_route('backend.website-settings.tab', $tab)->with('success', __('Default settings has been reseted successfully'));
        }
        foreach ($data as $key => $value) {
            $key = str_replace('__', '.', $key);
            $existing_one = SiteConfig::where('key', $key)->first();
            if ($existing_one && is_array($existing_one)) {
                $existing_one->value = array_merge($existing_one->value, $value);
                $existing_one->save();
            } else {
                SiteConfig::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return to_route('backend.website-settings.tab', $tab)->with('success', __('Data Updated Successfully'));
    }


    //Bank settings
    private function bank_settings()
    {
        return [
            $this->field_data(['title' => 'Name', 'name' => 'app__bank[name]', 'id' => 'bank__name', 'value' => config('app.bank.name')]),
            $this->field_data(['title' => 'Account holder', 'name' => 'app__bank[account_holder]', 'id' => 'bank__account_holder', 'value' => config('app.bank.account_holder')]),
            $this->field_data(['title' => 'Account number', 'name' => 'app__bank[account_number]', 'id' => 'bank__account_number', 'value' => config('app.bank.account_number')]),
            $this->field_data(['title' => 'IBAN', 'name' => 'app__bank[IBAN]', 'id' => 'bank__IBAN', 'value' => config('app.bank.IBAN')]),
        ];
    }

    //SMTP settings
    private function smtp_settings()
    {
        return [
            $this->field_data(['title' => 'SMTP Host', 'name' => 'mail__mailers__smtp[host]', 'id' => 'mail__mailers__smtp__host', 'value' => config('mail.mailers.smtp.host')]),
            $this->field_data(['title' => 'SMTP Port', 'name' => 'mail__mailers__smtp[port]', 'id' => 'mail__mailers__smtp__port', 'value' => config('mail.mailers.smtp.port')]),
            $this->field_data(['title' => 'SMTP Encryption', 'name' => 'mail__mailers__smtp[encryption]', 'id' => 'mail__mailers__smtp__encryption', 'value' => config('mail.mailers.smtp.encryption')]),
            $this->field_data(['title' => 'SMTP Username', 'name' => 'mail__mailers__smtp[username]', 'id' => 'mail__mailers__smtp__username', 'value' => config('mail.mailers.smtp.username')]),
            $this->field_data(['title' => 'SMTP Password', 'name' => 'mail__mailers__smtp[password]', 'id' => 'mail__mailers__smtp__password', 'value' => config('mail.mailers.smtp.password')]),
            $this->field_data(['title' => 'From Name', 'name' => 'mail__from[name]', 'id' => 'mail__from__name', 'value' => config('mail.from.name')]),
            $this->field_data(['title' => ' From Address', 'name' => 'mail__from[address]', 'id' => 'mail__from__address', 'value' => config('mail.from.address')]),
        ];
    }

    //General settings
    private function general_settings()
    {
        return [
            $this->field_data(['title' => 'Site name', 'name' => 'app__name', 'id' => 'app__name', 'value' => config('app.name')]),
            $this->field_data(['title' => 'Site URL', 'name' => 'app__url', 'id' => 'app__url', 'value' => config('app.url')]),
            $this->field_data(['type' => 'textarea', 'title' => 'SEO Description', 'name' => 'app__seo[description]', 'id' => 'app__seo__description', 'value' => config('app.seo.description')]),
            $this->field_data(['title' => 'SEO Keywords', 'name' => 'app__seo[keywords]', 'id' => 'app__seo__description', 'value' => config('app.seo.keywords')]),
            $this->field_data(['type' => 'file','title' => 'Favicon', 'name' => 'app__favicon', 'id' => 'app__favicon', 'value' => config('app.favicon'), 'inputAttributes' => 'onchange=_s.uploadImage(this) data-path=favicons']),
            $this->field_data(['type' => 'file','title' => 'Logo', 'name' => 'app__logo', 'id' => 'app__logo', 'value' => config('app.logo'), 'inputAttributes' => 'onchange=_s.uploadImage(this) data-path=logos']),
        ];
    }

    //Ads settings
    private function ads_settings()
    {
        return [
            $this->field_data(['type' => 'textarea', 'title' => 'Home banner ad html code', 'name' => 'app__ads[home_banner_ad]', 'id' => 'app__ads__home_banner_ad', 'value' => config('app.ads.home_banner_ad'), 'inputAttributes' => 'dir=ltr rows=5']),
        ];
    }


    //Function to set default field data
    private function field_data(array $field_data)
    {
        $default = [
            'type'  => 'text',
            'title' => '',
            'name'  => '',
            'id'    => '',
            'root_class' => '',
            'value' => '',
            'inputAttributes' => '',
        ];

        return array_merge($default, $field_data);
    }
}
