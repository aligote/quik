@extends('layouts.backend.app')

@section('title', 'Achievments')

@push('css')

@endpush

@section('content')
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>{{ __('Achievments') }}</h1>
			<div class="section-header-breadcrumb">
				<div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></div>
				<div class="breadcrumb-item">{{ __('Achievments') }}</div>
			</div>
		</div>

		<div class="section-body">
			<h2 class="section-title">{{ __('Achievments') }}</h2>
			<p class="section-lead">{{ __('Achievments Section') }}</p>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h4>{{ __('Achievments') }}</h4>
							<div class="card-header-form">
								<form>
									<div class="input-group">
										<input type="text" id="data_search" class="form-control" placeholder="Search">
										<div class="input-group-btn">
											<button class="btn btn-primary"><i class="fas fa-search"></i></button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="card-body p-0">
							<div class="table-responsive">
								<table class="table table-striped">
									<tr>
										<th>{{ __('Id') }}</th>
										<th>{{ __('Username') }}</th>
										<th>{{ __('Check') }}</th>
										<th>{{ __('Fire') }}</th>
										<th>{{ __('Heart') }}</th>
										<th>{{ __('Diamond') }}</th>
									</tr>
									@foreach($users as $key=>$user)
									<tr>
										<td>{{ $key + 1 }}</td>
										@php 
										$user_data = json_decode($user->value);
										@endphp
										<th><a target="__blank" href="{{ route('profile.show', $user->slug) }}">{{ $user->username }}</a></th>
										<td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" rel="check|{{ $user->id }}" class="custom-control-input achivs" id="check_{{ $user->id }}"@if($user->check) checked="checked"@endif>
                                                <label class="custom-control-label" for="check_{{ $user->id }}">On / Off</label>
                                            </div>
                                        </td>
										<td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" rel="fire|{{ $user->id }}" class="custom-control-input achivs" id="fire_{{ $user->id }}"@if($user->fire) checked="checked"@endif>
                                                <label class="custom-control-label" for="fire_{{ $user->id }}">On / Off</label>
                                            </div>
                                        </td>
										<td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" rel="heart|{{ $user->id }}" class="custom-control-input achivs" id="heart_{{ $user->id }}"@if($user->heart) checked="checked"@endif>
                                                <label class="custom-control-label" for="heart_{{ $user->id }}">On / Off</label>
                                            </div>
											
											
										</td>
										<td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" rel="diamond|{{ $user->id }}" class="custom-control-input achivs" id="diamond_{{ $user->id }}"@if($user->diamond) checked="checked"@endif>
                                                <label class="custom-control-label" for="diamond_{{ $user->id }}">On / Off</label>
                                            </div>
											
										</td>
									</tr>
									@endforeach
								</table>
								<div class="f-right">
									{{ $users->links() }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
