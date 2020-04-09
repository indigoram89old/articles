@extends('index')

@section('content')
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-4 offset-md-4">
					<div class="pt-5 mb-5"></div>

					<div class="min-vh-100 pt-5">
						@if(session('import_completed'))
							<div class="alert alert-success">
								{{ __('The import succcessful completed.') }}
							</div>
						@endif
						
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">
									{{ __('Import') }}
								</h5>

								{{ Form::open(['url' => route('import.store'), 'method' => 'post', 'data-form-spinner' => '#spinner']) }}
									@include('errors')

									<div class="form-group">
										{{ Form::label('file', __('Select a JSON feed file'), ['class' => 'form-label']) }}
										<div>
											{{-- TODO: temporaly set the file here (for tests only) --}}
											{{ Form::hidden('file', 'https://ucarecdn.com/a0d70122-fe8a-4bad-ba7c-a138392e41e0/', ['role' => 'uploadcare-uploader']) }}
										</div>
									</div>

									<div class="form-group">
										{{ Form::label('password', __('Your Password'), ['class' => 'form-label']) }}
										{{ Form::password('password', ['class' => 'form-control']) }}
									</div>

									{{ Form::submit(__('Continue'), ['class' => 'btn btn-primary btn-block']) }}
								{{ Form::close() }}
							</div>

							<div data-spinner id="spinner" class="spinner">
								<div class="position-absolute bg-white" style="top: 0; right: 0; bottom: 0; left: 0; opacity: 0.7"></div>
								<div class="spinner-border position-relative"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@include('plugins.uploadcare')