<?php

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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // make sure to validate in the model and check for http:/ or add it in the model
  //      'client_name' => string 'Nadaaa' (length=6)
  // 'description' => string 'National Association of something something something' (length=53)
  // 'date' => string '03-20-2000' (length=10)
  // 'url' => string 'http://nadaaa.com' (length=17) 
        $input = Input::all();
        // $portfolio = new Portfolio;

        // $success = $portfolio->createNewPortfolio($input);
        $portfolio = $this->portfolio->create($input);
        if($portfolio) {
            // json response
            // echo $portfolio;
            // return View::make('portfolio.edit')->with('portfolio', $portfolio);
            return Redirect::route('control.portfolio.edit', array($portfolio->getId()) );
        }
        // if $success give notice and append newly created portfolio to bottom of list, call show again
        // can return with json_encode for ajax later on
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
        // $portfolio_list = Portfolio::lists('client_name', 'id');
        $assets = Asset::all();

        if (is_null($portfolio))
        {
            return Redirect::route('control');
        }

        return View::make('portfolios.edit', compact('portfolio'))
            ->with('assets', $assets);
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

        if ($validation->passes())
        {
            $portfolio = $this->portfolio->find($id);
            // $portfolio->portfolios()->attach($input['Portfolios']);
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