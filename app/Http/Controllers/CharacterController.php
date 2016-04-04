<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Character;

class CharacterController extends Controller
{

	public function __construct() {

		// insert characters if db is empty
		if (Character::get()->isEmpty()) {
			Character::initialize();
		}
    }

    public function index() {

    	# get all characters
    	$characters = Character::get();

    	# return view with characters
    	return view('characters.index',compact('characters'));

    }

    public function create(Request $request) {

    	#validate input
    	$this->validate($request, [
	        'firstname' => 'required|max:255',
	        'lastname' => 'required|max:255',
	        'email' => 'required|max:255|email',
	        'house' => 'required|max:255',
	        'actor_firstname' => 'required|max:255',
	        'actor_lastname' => 'required|max:255',
	    ]);

    	#if validated create new character
	    Character::create($request->all());

	    #redirect to last page
	    return back();
    }


}
