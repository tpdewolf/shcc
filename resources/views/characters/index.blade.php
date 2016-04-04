@extends('layouts.default')

@section('content')
	@if ($characters)
	<table>
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>House</th>
			<th>Aka</th>
			<th>Actor</th>
		</tr>
	    @foreach ($characters as $character)
		<tr>
			<td>{{$character->firstname}} {{$character->lastname}}</td>
			<td>{{$character->email}}</td>
			<td>{{$character->house}}</td>
			<td>{{$character->aka}}</td>
			<td>{{$character->actor_firstname}} {{$character->actor_lastname}}</td>
		</tr>
	    @endforeach
    </table>
    @endif
	

	@if (count($errors) > 0)
	<ul class="errors">
		@foreach ($errors->all() as $error)
		<li>{{$error}}</li>
		@endforeach
	</ul>
	@endif

    <form method="post">
		<input type="text" name="firstname" placeholder="First name" value="{{old('firstname')}}"/>
		<input type="text" name="lastname" placeholder="Last name" value="{{old('lastname')}}"/>
		<input type="text" name="email" placeholder="Email" value="{{old('email')}}"/>
		<input type="text" name="house" placeholder="House" value="{{old('house')}}"/>
		<input type="text" name="aka" placeholder="Also known as" value="{{old('aka')}}"/>
		<input type="text" name="actor_firstname" placeholder="Actor Firstname" value="{{old('actor_firstname')}}"/>
		<input type="text" name="actor_lastname" placeholder="Actor Lastname" value="{{old('actor_lastname')}}"/>
		<input type="submit" value="Add character">
    </form>
@stop