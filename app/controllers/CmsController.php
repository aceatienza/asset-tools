<?php

use Models\Asset;

class CmsController extends BaseController {

    /**
    *   Display home page of cms
    *   @return  Response
    */
    public function index()
    {
        $users = User::all();
        $portfolios = Portfolio::all();
        $assets = Asset::all(); 

        return View::make('cms.index')
            ->with('assets', $assets)
            ->with('users', $users)
            ->with('portfolios', $portfolios);
    }

    /**
    *   Show settings
    *   @return  Response
    */
    public function show()
    {
        $currentSettings= [];
        $settings = DB::table('cms')->get();
        $deleteUrl = 'delete';

        foreach ($settings as $k => $v) {
            $name = $v->name;
            $value = $v->value;

            if(isset($value)) {
                $currentSettings[$name] = $value;
            }
        }

        return View::make('cms.settings')
            ->with('currentSettings', $currentSettings)
            ->with('deleteUrl', $deleteUrl);
    }

    /**
    *   Edit settings
    *   @return  Response
    */
    public function edit()
    {

        $input = Input::except('_token');  

        foreach ($input as $ik => $iv) {
            

            $settings = DB::table('cms')->lists('name');

            if(in_array($ik, $settings)) {
                DB::table('cms')->where('name', $ik)->update(array('value'=>$iv));
            } else if ($ik =='name' && isset($iv)) {
                $iv = str_replace(' ', '_', strtolower($iv));
                $value = str_replace(' ', '_', strtolower($input['value']));

                $id = DB::table('cms')->insertGetId(array('name' => $iv));
                DB::table('cms')->where('id', $id)->update(array('value'=>$value));
            }
            
        }

        return Redirect::route('control.settings');
    }

    /**
    *   Delete cms settings
    */
    public function deleteSetting()
    {
        $name = Input::get('name');

        DB::table('cms')->where('name', '=', $name)->delete();

        // return Redirect::route('control.settings'); // remove item with javascript, no need to refresh if successful event
    }
}