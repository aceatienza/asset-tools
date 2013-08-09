<?php

class Portfolio extends Eloquent {

	// lower-case, plural name of the class will be used as the table name unless another name is explicitly specified
	protected $fillable = array('client_name', 'description', 'date', 'url');
    protected $guarded = array();

    public static $rules = array();

    public function getId()
    {
        return $this->id;
    }
    public function createNewPortfolio($input) {
    	$this->client_name = $input['client_name'];
    	$this->description = $input['description'];
    	$this->date = $input['date'];
    	$this->url = $input['url'];

    	if($this->validate($input)) {
	    	$this->save();
	    	return $this->toJson();
	    } else {
	    	return False;
	    }
    }
    public function validate($input) {
    	$rules = array(
    		'client_name' => array(),
    		'description' => array(),
    		'date' => array(),
    		'url' => array()
    	);
    	$validator = Validator::make($input, $rules);

    	if($validator->passes()) 
    		return True;
    	else 
    		return False;
    }
    public function users()
    {
    	return $this->belongsToMany('User');
    }
    public function assets()
    {
        return $this->belongsToMany('Models\Asset'); // works
        // return $this->belongsToMany('Asset'); // doesn't work
    }
}