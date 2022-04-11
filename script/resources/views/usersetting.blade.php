@extends('layouts.frontend.app')
@section('title','Settings')
@section('content')

<!-- success-alert start -->
<div class="alert-message-area">
	<div class="alert-content">
		<h4 class="ale">{{ __('Your Settings Successfully Updated') }}</h4>
	</div>
</div>
<!-- success-alert end -->

<!-- error-alert start -->
<div class="error-message-area">
	<div class="error-content">
		<h4 class="error-msg">{{ __('Your Settings Successfully Updated') }}</h4>
	</div>
</div>
<!-- error-alert end -->


<!-- main area start -->
<section>
	<div class="main-area pb-50">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="settings-area">
						<div class="user-settings-info text-center">
							<div class="user-img">
								<a href="#"><img src="{{ asset(Auth::User()->image) }}" alt=""> {{ Auth::User()->first_name }} {{ Auth::User()->last_name }}</a>
							</div>
							<div class="alert alert-danger d-none"></div>
						</div>
						<div class="settings-menu">
							<ul class="nav nav-tabs justify-content-center">
								<li class="active"><a data-toggle="tab" class="active" href="#description">{{ __('General') }}</a></li>
								<li><a data-toggle="tab" href="#menu1">{{ __('Profile') }}</a></li>
								<li><a data-toggle="tab" href="#menu2">{{ __('Password') }}</a></li>
							</ul>
						</div>
						@php 
						$user = json_decode(Auth::User()->value);
						@endphp
						<div class="product-info-tab">
							<div class="tab-content">
								<div id="description" class="tab-pane fade in active show">
									<form action="{{ route('profile.update') }}" method="POST" class="setting_form">
										@csrf
										<div class="card-section">
											<div class="row">
												<div class="col-lg-6">
													<h6>{{ __('Email') }}</h6>
													<div class="login-form-gorup">
														<input type="text" id="email" class="login-form-control" name="email" placeholder="{{ __('Email') }}" value="{{ Auth::User()->email }}">
													</div>
												</div>
												<div class="col-lg-6">
													<h6>{{ __('Gender') }}</h6>
													<div class="login-birthday-display">
														<div class="login-form-gorup">
															<select name="gender">
																<option {{ !$user->gender? 'selected' : '' }} value="">{{ __('———') }}</option>
																<option {{ $user->gender == 'female' ? 'selected' : '' }} value="female">{{ __('Female') }}</option>
																<option {{ $user->gender == 'male' ? 'selected' : '' }} value="male">{{ __('Male') }}</option>
																<option {{ $user->gender == 'trans' ? 'selected' : '' }} value="trans">{{ __('Trans') }}</option>
																<option {{ $user->gender == 'couple' ? 'selected' : '' }} value="couple">{{ __('Couple') }}</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
													<h6>{{ __('Country') }}</h6>
													<div class="login-birthday-display">
														<div class="login-form-gorup">
															<select name="country">
																@foreach($countries as $country)
																<option {{ $user->country == $country ? 'selected' : '' }} value="{{ $country }}">{{ $country }}</option>
																@endforeach
															</select>
														</div>
													</div>
												</div>
												<div class="col-lg-6">
													<h6>{{ __('Age') }}</h6>
													<div class="login-birthday-display">
														<div class="login-form-gorup">
															<select name="age">
																@for($i=1; $i <= 100; $i++)
																<option {{ $i == $user->age ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
																@endfor
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
													<h6>{{ __('Relation') }}</h6>
													<div class="login-birthday-display">
														<div class="login-form-gorup">
															<select name="relation">
																<option {{ $user->relation == 'single' ? 'selected' : '' }} value="single">{{ __('Single') }}</option>
																<option {{ $user->relation == 'married' ? 'selected' : '' }} value="married">{{ __('Married') }}</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="save-button text-center mt-3">
												<button class="usersettings_update" type="submit">{{ __('Update') }}</button>
											</div>
										</div>
									</form>
								</div>
								<div id="menu1" class="tab-pane fade">
									<form action="{{ route('profile.update') }}" method="POST" class="setting_form">
										@csrf
										<div class="card-section">
											<h6>{{ __('First & Last Name') }}</h6>
											<div class="login-form-gorup">
												<div class="login-form-gorup first-name">
													<input type="text" id="first_name" class="login-form-control" name="first_name" placeholder="{{ __('First Name') }}" value="{{ Auth::User()->first_name }}">
												</div>
											</div>
											<h6>{{ __('About Me') }}</h6>
											<div class="login-form-gorup">
												<textarea name="bio" class="login-form-control" cols="7" rows="5" placeholder="{{ __('About Me') }}" id="biotext">{{ $user->bio }}</textarea>
											</div>
											@if (Auth::User()->check OR Auth::User()->fire OR Auth::User()->heart OR Auth::User()->diamond)
											<h6>{{ __('Onlyfans') }}</h6>
											<div class="login-form-gorup">
												<input type="text" id="onlyfans" class="login-form-control" name="onlyfans" placeholder="{{ __('Onlyfans') }}" value="@if(isset($user->onlyfans)){{ $user->onlyfans }}@endif">
											</div>
											<h6>{{ __('Instagram') }}</h6>
											<div class="login-form-gorup">
												<input type="text" id="instagram" class="login-form-control" name="instagram" placeholder="instagram.com/username" value="{{ $user->instagram }}">
											</div>
											<h6>{{ __('Youtube') }}</h6>
											<div class="login-form-gorup">
												<input type="text" id="youtube" class="login-form-control" name="youtube" placeholder="youtube.com/channel/channel_id" value="@if(isset($user->youtube)){{ $user->youtube }}@endif">
											</div>
											<h6>{{ __('Twitch') }}</h6>
											<div class="login-form-gorup">
												<input type="text" id="twitch" class="login-form-control" name="twitch" placeholder="twitch.tv/channel" value="@if(isset($user->twitch)){{ $user->twitch }}@endif">
											</div>
											<h6>{{ __('Twitter') }}</h6>
											<div class="login-form-gorup">
												<input type="text" id="twitter" class="login-form-control" name="twitter" placeholder="twitter.com/username" value="{{ $user->twitter }}">
											</div>
											<h6>{{ __('Reddit') }}</h6>
											<div class="login-form-gorup">
												<input type="text" id="reddit" class="login-form-control" name="reddit" placeholder="reddit.com/username" value="@if(isset($user->reddit)){{ $user->reddit }}@endif">
											</div>
											<h6>{{ __('Official website') }}</h6>
											<div class="login-form-gorup">
												<input type="text" id="offwebsite" class="login-form-control" name="offwebsite" placeholder="yoursite.com" value="@if(isset($user->offwebsite)){{ $user->offwebsite }}@endif">
											</div>
											@else
											<div class="alert alert-primary" role="alert">Only <a href="">verified</a> users and users with <a href="">achievements</a> can publish links</div>
											@endif
											<div class="save-button text-center mt-3">
												<button class="usersettings_update" type="submit" id="updatesettingbtn">{{ __('Update') }}</button>
											</div>
										</div>
									</form>
								</div>
								<div id="menu2" class="tab-pane fade">
									<form action="{{ route('profile.update') }}" method="POST" class="setting_form">
										@csrf
										<div class="card-section">
											<h6>{{ __('Current Password') }}</h6>
											<div class="login-form-gorup">
												<input type="password" id="current_password" name="current_password" class="login-form-control" placeholder="{{ __('Current Password') }}">
											</div>
											<h6>{{ __('New Password') }}</h6>
											<div class="login-form-gorup">
												<input type="password" id="password" name="password" class="login-form-control" placeholder="{{ __('New Password') }}">
											</div>
											<h6>{{ __('Confirm Password') }}</h6>
											<div class="login-form-gorup">
												<input type="password" id="password_confirmation" name="password_confirmation" class="login-form-control" placeholder="{{ __('Confirm Password') }}">
											</div>
											<div class="save-button text-center mt-3">
												<button class="usersettings_update" type="submit">{{ __('Update') }}</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- main area end -->

@endsection
