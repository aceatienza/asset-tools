<?php

use Models\Asset;

class PortfolioController extends BaseController {

    protected $portfolio;

    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $portfolios = $this->portfolio->all();
        return View::make('portfolios.index', compact('portfolios')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('portfolios.create');
        // TODO: add ability to add Assets while creating
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        // TODO: add Validator

        $portfolio = $this->portfolio->create($input);
        if($portfolio) {
            // json response
            // echo $portfolio;
            // return View::make('portfolio.edit')->with('portfolio', $portfolio);
            return Redirect::route('control.portfolio.edit', array($portfolio->getId()) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $portfolio = $this->portfolio->find($id);
        $assets = Asset::all();  
        $asset_list =  Asset::lists('name', 'id');

        if (is_null($portfolio))
        {
            return Redirect::route('control');
        }

        return View::make('portfolios.edit', compact('portfolio'))
            ->with('assets', $assets)
            ->with('assetlist', $asset_list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = array_except(Input::all(), '_method');
        $validation = Validator::make($input, Portfolio::$rules);
        
        $assets = Input::get('asset_ids');

        if ($validation->passes())
        {
            $portfolio = $this->portfolio->find($id);
            $portfolio->assets()->sync($assets);  // already checks to see if already in table
            $portfolio->update($input);  

            return Redirect::route('control.portfolio.edit', array($id));
        }

        return Redirect::route('control.portfolios.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->portfolio->find($id)->delete();

        return Redirect::route('control'); 
    }

}